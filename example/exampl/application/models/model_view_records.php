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

class Model_View_Records extends Model
{

    /**
     * function return file`s descriptors to the some position
     * @param $fname -processing file
     * @param $ftel -processing file
     * @param $fadress -processing file
     * @param $femail -processing file
     * @param $offset -position
     */
    public function FSEEK_BASE($fname, $ftel, $fadress, $femail, $offset)
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
    public function GetCurrentPerson($fname, $ftel, $faddress, $femail)
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
    public function CountOfRecords()
    {
        $fname = fopen("name.txt", "r");
        $count = 0;
        while (!feof($fname)) {
            fgets($fname, 4096);
            $count++;
        }
        return $count - 1;
        fclose($fname);
    }

    public function get_data($records_on_page=6)
    {
        $fname = fopen("name.txt", "r");
        $ftel = fopen("tel.txt", "r");
        $faddress = fopen("address.txt", "r");
        $femail = fopen("email.txt", "r");

//echo $count_records;
//echo $count_pages;
        if (empty($_GET["cur_page"])) {
            $_GET["cur_page"] = "1";
        }
        $cur_page = $_GET["cur_page"];
//$cur_page = 1;

        $data = array();
        $this->FSEEK_BASE($fname, $ftel, $faddress, $femail, 0);
        for ($i = 0; $i < ($cur_page - 1) * 6; $i++) {
            $this->GetCurrentPerson($fname, $ftel, $faddress, $femail);
        }
        for ($j = 0; $j < $records_on_page; $j++) {
            $cur_person = $this->GetCurrentPerson($fname, $ftel, $faddress, $femail);
            $data[$j]=$cur_person;
        }

        fclose($fname);
        fclose($ftel);
        fclose($faddress);
        fclose($femail);
        return $data;
    }
} ?>




