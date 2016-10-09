<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<head>
<body>
<!--Gør så man kan Updatere og give et nyt navn på allerede eksisterende resource-->
<?php
$rid = filter_input(INPUT_GET, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
require_once 'dbcon.php';
$sql = 'SELECT r.resources_name, r.resources_id
FROM resources r
WHERE r.resources_id=?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $rid);
$stmt->execute();
$stmt->bind_result($rnam, $rid);
?>

<form action="editres.php" method="POST">
<input type="text" name="rnam" value="<?=$rnam?>">
<input type="hidden" name="rid" value="<?=$rid?>">
<input type="submit" value="Update">
</form>
</body>
</html>