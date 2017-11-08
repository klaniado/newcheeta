<?php

require_once("db.php");
require_once("dbJSON.php");
require_once("usuario.php");

class dbMySQL extends db {
  private $conn;

  public function __construct() {
    $dsn = "mysql:host=localhost;port=3306;";
    $user = "root";
    $pass = "";
    try {
      $this->conn = new PDO($dsn, $user, $pass);
    } catch (Exception $e) {
      header("location: entrada.php");
    }

  }
  public function crearDB(){

  try {
    $sql = "CREATE DATABASE newdb";
      $query = $this->conn->prepare($sql);
      $query->execute();
        echo "Database created successfully<br>";
      }
      catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
      }

  }

    public function crearTabla() {

      try {
        $sql = "CREATE TABLE newdb.usuarios (
          id INT(6)  AUTO_INCREMENT PRIMARY KEY,
          nombre VARCHAR(30) NOT NULL,
          edad INT(3) NOT NULL,
          pais VARCHAR(10) NOT NULL,
          email VARCHAR(50) NOT NULL,
          password VARCHAR(500) NOT NULL,
          reg_date TIMESTAMP
        )";
        $query = $this->conn->prepare($sql);
        $query->execute();
      } catch (Exception $e) {
        echo $sql . "<br>" . $e->getMessage();
      }


    }
  public function migrarJSONaMySQL() {
    $json = new dbJSON();
    //$us=new Usuario();
    $usuarios = $json->traerTodosLosUsuarios();

    foreach ($usuarios as $usuario) {
      //$usuario = $us->toArray();

      //var_dump($usuario); exit;
      $usuario1 = new Usuario($usuario->getNombre(), $usuario->getEmail(), $usuario->getPassword(), $usuario->getEdad(), $usuario->getPais(), $usuario->getId());

      // echo "<pre>";
      // var_dump($usuario1); exit;
      $this->guardarUsuario($usuario1);
    }
}

  public function traerPorEmail($email) {
    $sql = "Select * from newdb.usuarios where email = :email";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":email", $email);

    $query->execute();

    $array = $query->fetch(PDO::FETCH_ASSOC);

    if (!$array) {
      return NULL;
    }

    return new Usuario($array["nombre"], $array["email"], $array["password"], $array["edad"], $array["pais"], $array["id"]);
  }
  public function traerTodosLosUsuarios() {
    $sql = "Select * from newdb.usuarios";

    $query = $this->conn->prepare($sql);

    $query->execute();

    $arrayDeArrays = $query->fetchAll(PDO::FETCH_ASSOC);

    $arrayDeObjetos = [];

    foreach ($arrayDeArrays as $array) {
      $arrayDeObjetos[] = new Usuario($array["nombre"], $array["email"], $array["password"], $array["edad"], $array["pais"], $array["id"]);
    }

    return $arrayDeObjetos;
  }
  public function guardarUsuario(Usuario $usuario) {
    $sql = "insert into newdb.usuarios values(default, :nombre, :edad, :pais, :email, :password, :reg_date)";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":nombre",$usuario->getNombre());
    $query->bindValue(":edad",$usuario->getEdad());
    $query->bindValue(":pais",$usuario->getPais());
    $query->bindValue(":email",$usuario->getEmail());
    $query->bindValue(":password",$usuario->getPassword());
    $query->bindValue(":reg_date", null);

    $query->execute();

    $usuario->setId($this->conn->lastInsertId());

    //return $usuario;
  }

  public function buscarUsuarios($buscar) {

    $sql = "Select * from usuarios where nombre like :buscar OR email like :buscar";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":buscar", "%$buscar%");

    $query->execute();

    $arrayDeArrays = $query->fetchAll(PDO::FETCH_ASSOC);

    $arrayDeObjetos = [];

    foreach ($arrayDeArrays as $array) {
      $arrayDeObjetos[] = new Usuario($array["nombre"], $array["email"], $array["password"], $array["edad"], $array["pais"], $array["id"]);
    }

    return $arrayDeObjetos;
  }

  public function editarUsuario(Usuario $usuario) {
    $sql = "UPDATE usuarios set nombre = :nombre, email = :email, password = :password, edad = :edad, pais = :pais WHERE id = :id";

    $query = $this->conn->prepare($sql);

    $query->bindValue(":nombre",$usuario->getNombre());
    $query->bindValue(":email",$usuario->getEmail());
    $query->bindValue(":password",$usuario->getPassword());
    $query->bindValue(":edad",$usuario->getEdad());
    $query->bindValue(":pais",$usuario->getPais());
    $query->bindValue(":id",$usuario->getId());

    $query->execute();
  }
}

?>
