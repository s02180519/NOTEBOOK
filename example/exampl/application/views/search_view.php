<html>
<head>
    <title>Searching...</title>
</head>
<body>

<form method="post" action="/Search">
    <p>Enter search information, please...</p><input type="text" name="SearchInformation">
    <input type="submit" value="Searching">
</form>
<?php
//var_dump($data);
if ($data != null) {
    print "<p>Возможные варианты:</p>";
    foreach ($data as $row)
        print $row;
}?>

<a href="/main">Return to the main page</a>

</body>
</html>