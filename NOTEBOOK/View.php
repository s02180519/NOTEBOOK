<html>
<head>
    <title>ViewAllRecords</title>
</head>
<body>
<?php

class Person
{
    /**
     * @var string $name
     * @var string $tel
     * @var string $address
     * @var string $email
     */
    public $name;
    public $tel;
    public $address;
    public $email;

    /**
     * Person constructor.
     * @param $new_name -person`s name
     * @param $new_tel -person`s phone number
     * @param $new_address -person`s address
     * @param $new_email -person`s email
     */
    function __construct($new_name, $new_tel, $new_address, $new_email)
    {
        $this->name = $new_name;
        $this->tel = $new_tel;
        $this->address = $new_address;
        $this->email = $new_email;
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}

/**
 * function return file`s descriptors to the some position
 * @param $fname -processing file
 * @param $ftel -processing file
 * @param $fadress -processing file
 * @param $femail -processing file
 * @param $offset -position
 */
function FSEEK_BASE($fname, $ftel, $fadress, $femail, $offset)
{
    fseek($fname, $offset);
    fseek($ftel, $offset);
    fseek($fadress, $offset);
    fseek($femail, $offset);
}

/**
 * calculate current person in files with information
 * @param $fname -processing file
 * @param $ftel -processing file
 * @param $faddress -processing file
 * @param $femail -processing file
 * @return Person - current person in file
 */
function GetCurrentPerson($fname, $ftel, $faddress, $femail)
{
    $cur_name = fgets($fname, 4096);
    $cur_tel = fgets($ftel, 4096);
    $cur_address = fgets($faddress, 4096);
    $cur_email = fgets($femail, 4096);
    return new Person($cur_name, $cur_tel, $cur_address, $cur_email);
}

/**
 * Calculates the number of records in file
 * @param $fname -processing file
 * @return int - number of records
 */
function CountOfRecords($fname)
{
    $count = 0;
    while (!feof($fname)) {
        fgets($fname, 4096);
        $count++;
    }
    return $count - 1;
}

$fname = fopen("name.txt", "r");
$ftel = fopen("tel.txt", "r");
$faddress = fopen("address.txt", "r");
$femail = fopen("email.txt", "r");

$records_on_page = 6;
$count_records = CountOfRecords($fname);
//echo $count_records;
$count_pages = ceil($count_records / $records_on_page);
//echo $count_pages;
if (empty($_GET["cur_page"])) {
    $_GET["cur_page"] = "1";
}
$cur_page = $_GET["cur_page"];
//$cur_page = 1;
?>
<table cellspacing="0" cellpadding="4" border='1'>
    <thead>
    <tr>
        <th><b>NAME</b></th>
        <th><b>TELEPHONE NUMBER</b></th>
        <th><b>ADDRESS</b></th>
        <th><b>EMAIL</b></th>
    </tr>
    </thead>
    <tbody>
    <?php
    FSEEK_BASE($fname, $ftel, $faddress, $femail, 0);
    for ($i = 0; $i < ($cur_page - 1) * 6; $i++) {
        GetCurrentPerson($fname, $ftel, $faddress, $femail);
    }
    for ($j = 0; $j < $records_on_page; $j++) { ?>
        <tr>
            <?php
            /*$cur_name = fgets($fname, 4096);
            $cur_tel = fgets($ftel, 4096);
            $cur_address = fgets($faddress, 4096);
            $cur_email = fgets($femail, 4096); */
            $cur_person = GetCurrentPerson($fname, $ftel, $faddress, $femail) ?>
            <td><?php echo $cur_person->name; ?></td>
            <td><?php echo $cur_person->tel; ?></td>
            <td><?php echo $cur_person->address; ?></td>
            <td><?php echo $cur_person->email; ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
if ($count_pages > 1) {
    //two pages back
    print "<br><div>";
    if (($cur_page - 2) > 0)
        $p_two_left = "<a class='first_page_link' href='View.php?cur_page=" . ($cur_page - 2) . "'>" . ($cur_page - 2) . "</a>  ";
    else
        $p_two_left = null;

    //one pages back
    if (($cur_page - 1) > 0) {
        $p_one_left = "<a class='first_page_link' href='View.php?cur_page=" . ($cur_page - 1) . "'>" . ($cur_page - 1) . "</a>  ";
        $ptmp = ($cur_page - 1);
    } else {
        $p_one_left = null;
        $ptmp = null;
    }

    //one page forward
    if (($cur_page + 1) <= $count_pages) {
        $p_one_right = "<a class='first_page_link' href='View.php?cur_page=" . ($cur_page + 1) . "'>" . ($cur_page + 1) . "</a>  ";
        $ptmp2 = ($cur_page + 1);
    } else {
        $p_one_right = null;
        $ptmp2 = null;
    }

    //two pages forward
    if (($cur_page + 2) <= $count_pages)
        $p_two_right = "<a class='first_page_link' href='View.php?cur_page=" . ($cur_page + 2) . "'>" . ($cur_page + 2) . "</a>  ";
    else
        $p_two_right = null;

    //to the begin
    if ($cur_page != 1 && $ptmp != 1 && $ptmp != 2)
        $begin = "<a class='first_page_link' href='View.php'> begin</a> ... ";
    else
        $begin = null;

    //to the end
    if ($cur_page != $count_pages && $ptmp2 != $count_pages - 1 && $ptmp2 != $count_pages)
        $end = "... <a class='first_page_link' href='View.php?cur_page=" . $count_pages . "'> end </a>  ";
    else
        $end = null;

    print "<br>" . $begin . $p_two_left . $p_one_left . '<span class="num_page_not_link"><b>' . $cur_page . ' </b></span>' . $p_one_right . $p_two_right . $end;
    print "</div>";
}
?>
<form action="AddContact.php">
    <br>
    <input type="submit" value="Add new record">
</form>
<?php
fclose($fname);
fclose($ftel);
fclose($faddress);
fclose($femail);
?>
<a href="main_page.php">Return to the main page</a>

</body>
</html>