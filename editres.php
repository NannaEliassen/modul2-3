<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<!--UPDATE parameter, fortæller hvad der skal ændres og hvor fra det skal ændres-->
<?php
require_once 'dbcon.php';
$rnam = filter_input(INPUT_POST, 'rnam', FILTER_DEFAULT) or die('Missing/illegal parameter');
$rid = filter_input(INPUT_POST, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');


$sql = 'UPDATE resources SET resources_name=? WHERE resources_id=?';
$stmt = $link->prepare($sql);
$stmt->bind_param('si', $rnam, $rid);
$stmt->execute();
if ($stmt->affected_rows >0 ){
	echo 'Ressourcens navn er nu ændret';
}
else {
	echo 'Ingen forandring, Skriv et andet navn';
}
?>

<a href="resourceslist.php">Gå tilbage til Resourcer</a><br>


</body>
</html>