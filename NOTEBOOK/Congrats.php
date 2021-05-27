<html>
<head>
    <title>Congrats</title>
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

class Base
{
    /**
     * @var array $notebook
     */
    protected $notebook;

    /**
     * Base constructor.
     * @param $new_notebook - array with titles of all files
     */
    function __construct($new_notebook)
    {
        $this->notebook = $new_notebook;
    }

    /**
     * Copy of all records from one file to another
     * @param $from - what file is coped
     * @param $to - file where all records are coped
     * @param $name_to - title of file where all record are coped
     */
    protected function CopyFile($from, $to, $name_to)
    {
        fseek($from, 0);
        file_put_contents($name_to, '');
        while (!feof($from)) {
            $cur_str = fgets($from);
            fwrite($to, $cur_str);
        }
    }

    /**
     * Calculates person`s existing in file with names and phone numbers
     * @param file $fname -where we`re search person
     * @param file $ftel -where we`re search person
     * @param string $person -whom we`re search
     * @return int - 1:exist,0:don`t exist
     */
    protected function PersonExists($person, $fname, $ftel)
    {
        fseek($ftel, 0);
        fseek($fname, 0);
        do {
            $cur_tel = fgets($ftel);
            $cur_name = fgets($fname);
            if (strcmp($cur_name, $person->name) == 0 || strcmp($cur_tel, $person->tel) == 0) {
                return 1;
            }
        } while (!feof($fname));
        return 0;
    }

    /**
     * Write Person`s data to the files with information
     * @param $fname -processing file
     * @param $ftel -processing file
     * @param $fadress -processing file
     * @param $femail -processing file
     * @param Person $person -whom we`re write
     */
    protected function WritePerson($fname, $ftel, $fadress, $femail, $person)
    {
        fwrite($fname, $person->name);
        fwrite($ftel, $person->tel);
        fwrite($fadress, $person->address);
        fwrite($femail, $person->email);
    }

    /**
     * calculate current person in files with information
     * @param $fname -processing file
     * @param $ftel -processing file
     * @param $faddress -processing file
     * @param $femail -processing file
     * @return Person - current person in file
     */
    protected function GetCurrentPerson($fname, $ftel, $faddress, $femail)
    {
        $cur_name = fgets($fname, 4096);
        $cur_tel = fgets($ftel, 4096);
        $cur_address = fgets($faddress, 4096);
        $cur_email = fgets($femail, 4096);
        return new Person($cur_name, $cur_tel, $cur_address, $cur_email);
    }

    /**
     * function return file`s descriptors to the some position
     * @param $fname -processing file
     * @param $ftel -processing file
     * @param $fadress -processing file
     * @param $femail -processing file
     * @param $offset -position
     */
    protected function FSEEK_BASE($fname, $ftel, $fadress, $femail, $offset)
    {
        fseek($fname, $offset);
        fseek($ftel, $offset);
        fseek($fadress, $offset);
        fseek($femail, $offset);
    }

    /**
     * main function of adding person`s data to the data base
     * @param Person $person -person which is added to the data base
     */
    public function CreatePerson($person)
    {
        $fname = fopen($this->notebook[0], "a+");
        $ftel = fopen($this->notebook[1], "a+");
        $faddress = fopen($this->notebook[2], "a+");
        $femail = fopen($this->notebook[3], "a+");
        $ftmp_name = fopen("tmp_name.txt", "w+");
        $ftmp_tel = fopen("tmp_tel.txt", "w+");
        $ftmp_address = fopen("tmp_adress.txt", "w+");
        $ftmp_email = fopen("tmp_email.txt", "w+");
        $this->FSEEK_BASE($fname, $ftel, $faddress, $femail, 0);
        fgetc($fname);
        if (!feof($fname)) {
            if (!$this->PersonExists($person, $fname, $ftel)) {
                $this->FSEEK_BASE($fname, $ftel, $faddress, $femail, 0);
                do {
                    $cur_person = $this->GetCurrentPerson($fname, $ftel, $faddress, $femail);
                    $this->WritePerson($ftmp_name, $ftmp_tel, $ftmp_address, $ftmp_email, $cur_person);
                } while (strcmp($person->name, $cur_person->name) > 0 && !feof($fname));
                fseek($ftmp_name, -strlen($cur_person->name), SEEK_CUR);
                fseek($ftmp_tel, -strlen($cur_person->tel), SEEK_CUR);
                fseek($ftmp_address, -strlen($cur_person->address), SEEK_CUR);
                fseek($ftmp_email, -strlen($cur_person->email), SEEK_CUR);
                $this->WritePerson($ftmp_name, $ftmp_tel, $ftmp_address, $ftmp_email, $person);
                $this->WritePerson($ftmp_name, $ftmp_tel, $ftmp_address, $ftmp_email, $cur_person);
                while (!feof($fname)) {
                    $cur_person = $this->GetCurrentPerson($fname, $ftel, $faddress, $femail);
                    $this->WritePerson($ftmp_name, $ftmp_tel, $ftmp_address, $ftmp_email, $cur_person);
                }
                $this->CopyFile($ftmp_name, $fname, $this->notebook[0]);
                $this->CopyFile($ftmp_tel, $ftel, $this->notebook[1]);
                $this->CopyFile($ftmp_address, $faddress, $this->notebook[2]);
                $this->CopyFile($ftmp_email, $femail, $this->notebook[3]);
            } else
                print $person->name . "Person exists!!!<br/>";
        } else {
            $this->WritePerson($fname, $ftel, $faddress, $femail, $person);
        }
        fclose($ftmp_name);
        fclose($ftmp_tel);
        fclose($ftmp_address);
        fclose($ftmp_email);
        unlink("tmp_name.txt");
        unlink("tmp_tel.txt");
        unlink("tmp_adress.txt");
        unlink("tmp_email.txt");
        fclose($fname);
        fclose($ftel);
        fclose($faddress);
        fclose($femail);
    }


    function __destruct()
    {
    }
}

?>
Contact was added
<form action="AddContact.php">
    <p><input type="submit" value="Add one more"></p>
    <?php
    if (!isset($_POST['address']))
        $address = "";
    else
        $address = $_POST['address'];

    if (!isset($_POST['email']))
        $email = "";
    else
        $email = $_POST['email'];


    $notebook = array('name.txt', 'tel.txt', 'address.txt', 'email.txt');
    $database = new Base($notebook);
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $person = new Person($name . "\n", $tel . "\n", $address . "\n", $email . "\n");
    $database->CreatePerson($person);
    unset($person);
    unset($database);
    ?>
</form>
<a href="main_page.php">Return to the main page</a>

</body>
</html>