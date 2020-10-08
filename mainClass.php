<?php
require_once('config.php');

// MainClass for connectiong to the database with PDO
class mainClass
{
  private $host = DBHOST;
  private $db_name = DBDATABASE;
  private $username = DBUSER;
  private $password = DBPASSWORD;
  public $connect;
  private $query;

  // Constructor for connecting to the database
  public function __construct()
  {
    try {
      $this->connect = new PDO(
        "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
        $this->username,
        $this->password
      );
      $this->connect->exec("set names utf8");
    } catch (PDOException $expection) {
      echo "connection failed " . $expection->getMessage();
    }
  }
  // Method for retriving data
  function getData()
  {
    $this->query = "SELECT * FROM courseinfo";
    $result = $this->connect->prepare($this->query);
    $result->execute();
    $data = $result->fetchAll(\PDO::FETCH_ASSOC);
    return json_encode($data);
  }
  // Method for retriving a single row based on the id
  function getSingleData($id)
  {
    $this->query = "SELECT * FROM courseinfo WHERE ID = :id";
    $result = $this->connect->prepare($this->query);
    $result->execute(['id' => $id]);
    $data = $result->fetch(\PDO::FETCH_ASSOC);
    return json_encode($data);
  }

  // Method for Inserting data
  function insertData($courseID, $coursename, $progression, $courseSyllabus)
  {
    //Create a query
    $this->query = "INSERT into
                           courseinfo(courseID, coursename, progression, courseSyllabus)
                    VALUES 
                           (:id, :coursename, :progression, :courseSyllabus)";

    $result = $this->connect->prepare($this->query);
    // USing prepared statement 
    if ($result->execute(['id' => $courseID, 'coursename' => $coursename, 'progression' => $progression, 'courseSyllabus' => $courseSyllabus])) {
      return true;
    }
    return false;
  }
  // Method for changing data
  function updateData($id, $courseID, $coursename, $progression, $courseSyllabus)
  {
    $this->query = "UPDATE 
                          courseinfo
                    SET 
                          courseID = :courseID, coursename = :coursename, progression = :progression, courseSyllabus = :courseSyllabus
                    WHERE 
                          ID = :id;";

    $result = $this->connect->prepare($this->query);
    if ($result->execute(['id' => $id, 'courseID' => $courseID, 'coursename' => $coursename, 'progression' => $progression, 'courseSyllabus' => $courseSyllabus])) {
      return true;
    }
    return false;
  }


  // Method for delete data with the courseID
  function deleteData($id)
  {
    $this->query = "DELETE FROM courseinfo where courseID = :ID";
    $result = $this->connect->prepare($this->query);
    if ($result->execute(['ID' => $id])) {
      return true;
    }
    return false;
  }
}
