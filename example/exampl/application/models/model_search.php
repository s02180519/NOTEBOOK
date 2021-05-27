<?php

class Model_Search
{
    /**
     * Calculates person`s existing in file
     * @param file $ftmp -where we`re search person
     * @param string $name -whom we`re search
     * @return int - 1:exist,0:don`t exist
     */
    public function PersonExists($ftmp, $name)
    {
        fseek($ftmp, 0);
        do {
            $cur_str = fgets($ftmp);
            if (strcmp($name, $cur_str) == 0)
                return 1;
        } while (!feof($ftmp));
        return 0;
    }

    /**
     * Print Person`s information to the intermediate file
     * @param $fname -file with information
     * @param $ftel -file with information
     * @param $faddress -file with information
     * @param $femail -file with information
     * @param $StrNumber -person`s number of string in file with information
     * @param $ftmp -intermediate file
     */
    public function PrintInformation($fname, $ftel, $faddress, $femail, $StrNumber, $ftmp)
    {
        fseek($fname, 0);
        fseek($ftel, 0);
        fseek($faddress, 0);
        fseek($femail, 0);
        for ($i = 1; $i < $StrNumber; $i++) {
            fgets($fname);
            fgets($ftel);
            fgets($faddress);
            fgets($femail);
        }
        $cur_str = substr(fgets($fname), 0, -1) . " " . substr(fgets($ftel), 0, -1)
            . " " . substr(fgets($faddress), 0, -1) . " " . fgets($femail);
        if ($this->PersonExists($ftmp, $cur_str) == 0) {
            fwrite($ftmp, $cur_str);
        }
    }

    /**
     * Searching of string in file`s records
     * @param $fSearch -   file where search
     * @param $SearchStr -string which is searched
     * @param $fname -file with information
     * @param $ftel -file with information
     * @param $faddress -file with information
     * @param $femail -file with information
     * @param $ftmp -intermediate file
     */
    public function SearchInFile($fSearch, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp)
    {
        fseek($fname, 0);
        fseek($ftel, 0);
        fseek($faddress, 0);
        fseek($femail, 0);
        $StrNumber = 0;
        while (!feof($fSearch)) {
            $StrNumber++;
            $str = fgets($fSearch, 4096);
            if (preg_match("/$SearchStr/i", $str)) {
                $this->PrintInformation($fname, $ftel, $faddress, $femail, $StrNumber, $ftmp);
            }
        }
    }

    /**main function of searching and entering of all records
     * @param $SearchStr -string which is searched
     */
    public function Search($SearchStr)
    {
        $fname = fopen("name.txt", "r");
        $ftel = fopen("tel.txt", "r");
        $faddress = fopen("address.txt", "r");
        $femail = fopen("email.txt", "r");
        $ftmp = fopen("tmp.txt", "a+");
        if (preg_match("/tel:/i", $SearchStr) || preg_match("/name:/i", $SearchStr) ||
            preg_match("/address:/i", $SearchStr) || preg_match("/email:/i", $SearchStr)) {
            $array_meta = preg_split("/[\s,]/", $SearchStr);
            foreach ($array_meta as $cur_str) {
                if (preg_match("/^tel:/", $cur_str)) {
                    $cur_str = substr($cur_str, 4);
                    $SearchStr = $cur_str;
                    $this->SearchInFile($ftel, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
                }
                if (preg_match("/^name:/", $cur_str)) {
                    $cur_str = substr($cur_str, 5);
                    $SearchStr = $cur_str;
                    $this->SearchInFile($fname, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
                }
                if (preg_match("/^address:/", $cur_str)) {
                    $cur_str = substr($cur_str, 8);
                    $SearchStr = $cur_str;
                    $this->SearchInFile($faddress, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
                }
                if (preg_match("/^email:/", $cur_str)) {
                    $cur_str = substr($cur_str, 6);
                    $SearchStr = $cur_str;
                    $this->SearchInFile($femail, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
                }
            }
        } else {
            $this->SearchInFile($fname, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
            $this->SearchInFile($ftel, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
            $this->SearchInFile($faddress, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);
            $this->SearchInFile($femail, $SearchStr, $fname, $ftel, $faddress, $femail, $ftmp);

        }
        fseek($ftmp, 0);
        $data = array();
        $i=0;
        do {
            $data[++$i]=fgets($ftmp) . "<br/>";
        } while (!feof($ftmp));
        fclose($fname);
        fclose($ftel);
        fclose($faddress);
        fclose($femail);
        fclose($ftmp);
        unlink("tmp.txt");
        return $data;
    }

    public function get_data()
    {
        $data=null;
        if (isset($_POST['SearchInformation'])) {
            $data=$this->Search($_POST['SearchInformation']);
        }
        return $data;
    }
}