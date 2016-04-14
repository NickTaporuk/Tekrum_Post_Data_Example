<?php
namespace Tekrum;

/**
 * Задача:
 * Пользователь отправил форму содержащую следующие поля:
 *
 * first_name = Иван
 * last_name = Иванов
 * age = 27
 * birth_date = 25.12.1980

 * Привести пример (ООП), который принимает эти данные и делает запись в базу MySQL
 *
 * Class TecrumPostData
 */

class TecrumPostData implements ITecrumPostData{

    /**
     * @var PDO $db
     */
    protected $db;
    /**
     * @var string $first_name
     */
    protected $first_name;
    /**
     * @var string $last_name
     */
    protected $last_name;
    /**
     * @var integer $age
     */
    protected $age;
    /**
     * @var DateTime $birth_date
     */
    protected $birth_date;

    /**
     * @param PDO $db
     * @param string $first_name
     * @param string $last_name
     * @param integer $age
     * @param DateTime $birth_date
     */
    function __construct(PDO $db,$first_name,$last_name,$age, \DateTime $birth_date)
    {
        $this->db           = $db;
        $this->first_name   = $first_name;
        $this->last_name    = $last_name;
        $this->age          = $age;
        $this->birth_date   = $birth_date;
    }

    /**
     * @return PDO
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param PDO $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @param string  $string
     * @param integer $len
     * @return bool
     */
    public function isString($string,$len)
    {
        return is_string($string) && strlen($string) <= $len;
    }

    /**
     * @param mixed $integer
     * @return bool
     */
    public function isInteger($integer,$len)
    {
        return is_int($integer) && strlen($integer) <= $len;
    }

    /**
     * @param mixed $dateTimeObj
     * @return bool
     */
    public function isDateTimeObj($dateTimeObj)
    {
        return ($dateTimeObj instanceof DateTime);
    }

    /**
     * @return bool|void
     */
    public function insertRecordToDb()
    {
        try {
            if(!$this->isString($this->first_name,255)) throw new Exception('$this->first_name is not string or lenght > 255');
            if(!$this->isString($this->last_name,255)) throw new Exception('$this->last_name is not string or lenght > 255');
            if(!$this->isInteger($this->age,100)) throw new Exception('$this->age is not integer');
            if(!$this->isDateTimeObj($this->birth_date)) throw new Exception('$this->birth_date is not DateTime');

            $this->db->prepare("INSERT INTO users (first_name, last_name,age,birth_date) VALUES (:name, :lastName, :age, :birth_date)");
            $this->db->bindParam(':name', $this->first_name);
            $this->db->bindParam(':lastName', $this->last_name);
            $this->db->bindParam(':age', $this->age);
            $this->db->bindParam(':birth_date', $this->birth_date->format('Y-m-d H:i:s'));
            $this->db->execute();
            return true;
        } catch(Exception $e) {
            error_log($e->getTraceAsString());
            return;
        }
    }

}