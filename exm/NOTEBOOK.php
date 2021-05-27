<html>
<head>
    <title>ЗАПИСНАЯ КНИЖКА</title>
</head>
<body>
<?php
abstract class Base{

}
class Name extends Base {
    protected $name;
}
class Tel extends Base {
    protected $name;
}
class Adress extends Base {
    protected $name;
}
class Email extends Base {
    protected $name;
}
class TestBase{
    function testBase(){

    }
}
$notebook=array('name.txt','tel.txt','adress.txt','email.txt');
$fname=fopen($notebook[0], "a+");
$ftel=fopen($notebook[1], "a+");
$fadress=fopen($notebook[2], "a+");
$femail=fopen($notebook[3], "a+");
$testing=new TestBase()
fclose($fname);
fclose($ftel);
fclose($fadress);
fclose($femail);
?>
</body>
</html>
