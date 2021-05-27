<html>
<head>
    <title>ОБЪЕКТНО-ОРИЕНТИРОВАННОЕ ПРОГРАММИРОВАНИЕ</title>
</head>
<body>
<?php
require_once ('./classes.php');

ini_set('display_errors',1);
error_reporting(E_ALL);

class ShootingRange{
    function  testWeapon($weapon){
        echo 'Model: ' . $weapon->getModel() . '<br/>';
        echo 'Max ammo: ' . $weapon->getMaxAmmo() . '<br/>';
        echo 'Current ammo: ' . $weapon->getAmmo() . '<br/>';
        $weapon->fire();
        echo 'Current ammo: ' . $weapon->getAmmo() . '<br/>';
        $weapon->fire();
        $weapon->fire();
        $weapon->fire();
        echo 'Current ammo: ' . $weapon->getAmmo() . '<br/>';
        $weapon->reload();
        echo 'Current ammo: ' . $weapon->getAmmo() . '<br/>';
    }
}

$shootingRange=new ShootingRange();
$shootingRange->testWeapon(new AK47(8));
echo "<br/>";
$shootingRange->testWeapon(new BerettaM1934(2));
echo "<br/>";
$shootingRange->testWeapon(new BerettaM1934(8));
?>
</body>
</html>
