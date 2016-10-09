<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
$rid = filter_input(INPUT_POST, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
require_once 'dbcon.php';
$sql = 'DELETE FROM project_has_resources WHERE resources_resources_id=? AND project_project_id=?';
$stmt = $link->prepare($sql);
$stmt->bind_param('ii', $rid, $pid);
$stmt->execute();
if ($stmt->affected_rows >0 ){
	echo 'Ressource er nu slettet fra Projektet';
}
else {
	echo 'Ingen forandring - Ressourcen var ikke på Projektet';
}
?>
<a href="projectdetails.php?pid=<?=$pid?>"> Se projektdetaljer</a><br>

</body>
</html>