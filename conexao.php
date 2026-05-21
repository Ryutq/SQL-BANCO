<?php 
$host = "localhost";
$usuario = "root";
$password = "";
$dbname = "bd_contabilidade";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Registro inserido com sucesso!";
} catch (PDOException $erro) {
    header ("Ocorreu o seguinte erro: ".$erro->getMessage());
}

?>
