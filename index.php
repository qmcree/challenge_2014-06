<?php

class VowelGrabber
{
    private $str = '';
    private $extracted = '';

    /**
     * @param string $str
     */
    public function __construct($str)
    {
        $this->str = $str;
    }

    /**
     * @return string Un-extracted string.
     */
    public function getStr()
    {
        return $this->str;
    }

    /**
     * @return string Extracted string.
     */
    public function getExtracted()
    {
        return $this->extracted;
    }

    /**
     * Extracts vowels from string and sets it.
     */
    public function extract()
    {
        $split = str_split($this->getStr(), 1);
        $extracted = '';

        foreach ($split as $v) {
            $vowels = ['a', 'e', 'i', 'o', 'u'];

            if (in_array($v, $vowels))
                $extracted .= $v;
        }

        $this->extracted = $extracted;
    }

    /**
     * Inserts extracted sring into database.
     */
    public function insert()
    {
        $db = new PDO('mysql:host=localhost;dbname=challenge', 'root', 'password', [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ]);
        $sql = "
            INSERT INTO data (str)
            VALUES (:str)
        ";
        $query = $db->prepare($sql);
        $query->execute([':str' => $this->getExtracted()]);
    }
}

$grabber = new VowelGrabber($_GET['str']);
$grabber->extract();
$grabber->insert();
?>

The extracted string <?php echo $grabber->getExtracted(); ?> has been inserted into the database.
