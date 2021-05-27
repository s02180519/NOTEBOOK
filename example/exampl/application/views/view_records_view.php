<html>
<head>
    <title>ViewAllRecords</title>
</head>
<body>
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
    foreach ($data as $row)
        echo '<tr height="50"><td>' . $row->name . '</td><td>' . $row->tel . '</td><td>' . $row->address . '</td><td>' . $row->email . '</td></tr>';
    ?>
    </tbody>
</table>
<?php
$count_pages = ceil($count_records / $records_on_page);
if (empty($_GET["cur_page"])) {
    $_GET["cur_page"] = "1";
}
$cur_page = $_GET["cur_page"];
if ($count_pages > 1) {
//two pages back
    print "<br>
<div>";
    if (($cur_page - 2) > 0)
        $p_two_left = "<a class='first_page_link' href='/view_records?cur_page=" . ($cur_page - 2) . "'>" . ($cur_page - 2) .
            "</a> ";
    else
        $p_two_left = null;

    //one pages back
    if (($cur_page - 1) > 0) {
        $p_one_left = "<a class='first_page_link' href='/view_records?cur_page=" . ($cur_page - 1) . "'>" . ($cur_page - 1) .
            "</a> ";
        $ptmp = ($cur_page - 1);
    } else {
        $p_one_left = null;
        $ptmp = null;
    }

    //one page forward
    if (($cur_page + 1) <= $count_pages) {
        //$p_one_right = "<a class='first_page_link' href='/View/?cur_page=" . ($cur_page + 1) . "'>" . ($cur_page + 1) . "</a>";
        $p_one_right = "<a class='first_page_link' href='/view_records?cur_page=" . ($cur_page + 1) . "'>" . ($cur_page + 1) . "</a>";

        $ptmp2 = ($cur_page + 1);
    } else {
        $p_one_right = null;
        $ptmp2 = null;
    }

    //two pages forward
    if (($cur_page + 2) <= $count_pages)
        $p_two_right = "<a class='first_page_link' href='/view_records?cur_page=" . ($cur_page + 2) . "'>" . ($cur_page + 2) .
            "</a> ";
    else
        $p_two_right = null;

    //to the begin
    if ($cur_page != 1 && $ptmp != 1 && $ptmp != 2)
        $begin = "<a class='first_page_link' href='/view_records'> begin</a> ... ";
    else
        $begin = null;

    //to the end
    if ($cur_page != $count_pages && $ptmp2 != $count_pages - 1 && $ptmp2 != $count_pages)
        $end = "... <a class='first_page_link' href='/view_records?cur_page=" . $count_pages . "'> end </a> ";
    else
        $end = null;

    print "<br>" . $begin . $p_two_left . $p_one_left . '<span
            class="num_page_not_link"><b>' . $cur_page . ' </b></span>' . $p_one_right . $p_two_right . $end;
    print "</div>";
} ?>

</body>
</html>