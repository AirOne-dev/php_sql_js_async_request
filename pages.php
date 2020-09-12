<?php

try {
	$db = new PDO("pgsql:host=localhost;port=5433;dbname=m3104_martine", "username", "password");
	$db->exec('SET search_path TO vehicle_martine');
} catch (PDOException $e) {
	echo $e->getMessage();
}

spl_autoload_register(function($class) {
	include_once($class.".php");
});

$nb = 10; // nombre d'items par pages

if(isset($_GET['p']) && !empty($_GET['p'])) {
	if($_GET['p'] < 1) { $p = 1; }
	else { $p = $_GET['p']; }
}
else { $p = 1; }

$next = $p+1;
$prev = $p-1;

$vehicles = Vehicle::get_vehicle_range(($p-1)*$nb, $nb);

echo '<div id="vehicle_container">';
foreach ($vehicles as $vehicle) {
	echo $vehicle.'<br />';
}
echo '</div>';