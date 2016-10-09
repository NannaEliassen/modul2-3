<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Project Details</title>
</head>

<body>
<!--Henter informationer om det valgte Projekt-->
<?php
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT p.project_id, p.project_name, p.project_startdate, p.project_enddate, p.project_detail
FROM project p
WHERE p.project_id=?'; 
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($pid, $pnam, $psd, $ped, $pdetail);
while($stmt->fetch()) { }
?>
<h1><?=$pnam?></h1> 
<p>
Start Dato: <?=$psd?><br>
Slut Dato: <?=$ped?><br>
</p>
<p>
Kommentar: <?=$pdetail?></p>
	
<h2>Ressourcer</h2>
<ul>
<!--Henter hvilke ressourcer der er tilkoblet det valgte projekt-->
<?php
require_once 'dbcon.php';
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$sql = 'SELECT r.resources_id, r.resources_name, rt.resource_type_name
FROM project_has_resources pr, resources r, resource_type rt
WHERE pr.project_project_id=?
AND pr.Resources_resources_id=r.resources_id
AND r.resource_type_resource_type_id=rt.resource_type_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $rtnam);

while($stmt->fetch()) {
	echo '<li><a href="resourceslist.php?rid='.$rid.'">'.$rnam.', '.$rtnam.'</a>';
?>
<!--Delete form-->
<form action="deleteresourcefromproject.php" method="post">
<input type="hidden" name="pid" value="<?=$pid?>">
<input type="hidden" name="rid" value="<?=$rid?>">
<input type="submit" value="Delete">
</form>	
	<?php
	echo '</li>';
}
?>
</ul>
<!--Tilføj resourcer til valgte Projekt-->
<form action="addresourcetoproject.php" method="post">
	<input type="hidden" name="pid" value="<?=$pid?>">
	<select name="rid">
<?php
require_once 'dbcon.php';

$sql = 'SELECT r.resources_id, r.resources_name, rt.resource_type_name
FROM resources r, resource_type rt
WHERE  r.resource_type_resource_type_id = rt.resource_type_id';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($rid, $rnam, $rtnam);

while($stmt->fetch()) {
	echo '<option value="'.$rid.'">'.$rnam.' - '.$rtnam.'</option>'.PHP_EOL;
}
?>
 
    </select>
    <input type="submit" value="add">
</form>
</ul>
<!--Lister de Klienter der er tilkoblet Projektet-->
<h2>Klienter</h2>
<ul>
<?php
require_once 'dbcon.php';
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$sql = 'SELECT c.client_id, c.client_name
FROM client c, project p
WHERE p.project_id=?
AND c.client_id = p.client_client_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($cid, $cnam);
while($stmt->fetch()) {
echo '<li><a href="clientdetails.php?cid='.$cid.'">'.$cnam.'</a></li>';
}
?>
</ul>
</body>
</html>