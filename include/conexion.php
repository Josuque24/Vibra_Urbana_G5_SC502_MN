<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost';
$usuario = 'root';
//$contrasenia = 'emilyL2006';
$contrasenia = '24457285';
$base_datos = 'vibra_urbana';

$mysqli = new mysqli($host,$usuario,$contrasenia,$base_datos);
if($mysqli->connect_error){
    echo "<div class='alert alert-danger'>Error en la conexion a base de datos</div>";
}else {
    $mysqli->set_charset('utf8mb4');
}

?>