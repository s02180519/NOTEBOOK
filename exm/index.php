<html>
<head>
    <title>Основы</title>
</head>
<body>
<?php

function loggingCall(){
    $fp=fopen("CreateTime.txt","a");
    $time=date("H:i:s");
    fwrite($fp,$time);
    fwrite($fp,"\n");
    fclose($fp);
}

function StraightCount($fp){
fseek($fp,0);
$count=0;
while(!feof($fp)) {
    $str = fgets($fp,4096);
    $count++;
}
return $count;
}
/////////////////////////////////////
echo "<b>РАБОТА С ФАЙЛАМИ</b><br />";
loggingCall();
echo "<br>";
/////////////////////////////////////
$name="FileInfo.txt";
$fp=fopen($name,"w+");
fwrite($fp,"rsgniergierggrr \n ergtehtegeth \n tethrthr \n trht\nfg");
$count=filesize($name);
echo "Размер файла: $count<br />";
$count=StraightCount($fp);
echo "Количество строк в файле: $count<br/>";
fclose($fp);
?>
</body>
</html>