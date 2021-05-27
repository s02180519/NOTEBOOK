<html>
<head>
    <title>ЗАПИСНАЯ КНИЖКА</title>
</head>
<body>

<?php

class Person
{
    public $name;
    public $tel;
    public $address;
    public $email;

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
    protected $notebook;


    function __construct($new_notebook)
    {
        $this->notebook = $new_notebook;
    }


    /*  protected function SortingBase()
      {
          $fname = fopen($this->notebook[0], "a+");
          $ftel = fopen($this->notebook[1], "a+");
          $fadress = fopen($this->notebook[2], "a+");
          $femail = fopen($this->notebook[3], "a+");

          fclose($fname);
          fclose($ftel);
          fclose($fadress);
          fclose($femail);
      }*/

    protected function CopyFile($from, $to, $name_to)
    {
        fseek($from, 0);
        file_put_contents($name_to, '');
        while (!feof($from)) {
            $cur_str = fgets($from);
            fwrite($to, $cur_str);
        }
    }

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

    /* protected function LineToPrint($person, $fname){
         $number=1;
         fseek($fname, 0);
         do {
             $cur_name = fgets($fname, 4096);
             //fwrite($ftmp, $cur_name);
         } while (strcmp($person->name, $cur_name) > 0 && !feof($fname));
         return --$number;
     }*/

    protected function WritePerson($fname, $ftel, $fadress, $femail, $person)
    {
        fwrite($fname, $person->name);
        fwrite($ftel, $person->tel);
        fwrite($fadress, $person->address);
        fwrite($femail, $person->email);
    }

    protected function GetCurrentPerson($fname, $ftel, $faddress, $femail)
    {
        $cur_name = fgets($fname, 4096);
        $cur_tel = fgets($ftel, 4096);
        $cur_address = fgets($faddress, 4096);
        $cur_email = fgets($femail, 4096);
        return new Person($cur_name, $cur_tel, $cur_address, $cur_email);
    }

    protected function FSEEK_BASE($fname, $ftel, $fadress, $femail, $offset)
    {
        fseek($fname, $offset);
        fseek($ftel, $offset);
        fseek($fadress, $offset);
        fseek($femail, $offset);
    }

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

    public function PrintList()
    {
        $fname = fopen($this->notebook[0], "a+");
        $ftel = fopen($this->notebook[1], "a+");
        $fadress = fopen($this->notebook[2], "a+");
        $femail = fopen($this->notebook[3], "a+");
        // fseek($this->fname, 0);
        while (!feof($fname)) {
            $cur_person = $this->GetCurrentPerson($fname, $ftel, $fadress, $femail);
            print $cur_person->name . " " . $cur_person->tel . " " . $cur_person->address . " " . $cur_person->email . "<br/>";
        }
        fclose($fname);
        fclose($ftel);
        fclose($fadress);
        fclose($femail);
    }

    function __destruct()
    {
    }
}


$notebook = array('name.txt', 'tel.txt', 'address.txt', 'email.txt');
$database = new Base($notebook);
$person = new Person("Dmitry" . "\n", "56495" . "\n", "Africa" . "\n", "dmytry@mail.ru" . "\n");
$database->CreatePerson($person);
unset($person);
$person = new Person("Dmitr" . "\n", "56475" . "\n", "Africa" . "\n", "dmytry@mail.ru" . "\n");
$database->CreatePerson($person);
unset($person);

$person = new  Person("Mariya" . "\n", "56951" . "\n", "Moscow" . "\n", "mariya@mail.ru" . "\n");
$database->CreatePerson($person);
unset($person);

$person = new  Person("Valentin" . "\n", "58951" . "\n", "Moscow" . "\n", "mariya@mail.ru" . "\n");
$database->CreatePerson($person);
unset($person);

//$database->PrintList();

?>
</body>
</html>
