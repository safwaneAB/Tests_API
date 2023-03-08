<?php

class TestcaseModel
{
    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testbase";
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);
    }
    public function GetTestCaseResult($name = null)
    {
        if (isset($name) && $name != null) {
            $table = 'testcase';
            $name = $_GET['name'];
            $stmt = $this->conn->prepare("SELECT ResultState FROM $table WHERE name = ?");
            $stmt->bind_param('s', $name);
            $stmt->execute();

            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();
            $this->conn->close();
            return  $rows;
        }
    }
    public function GetAllTestCaseResults()
    {
        $table = 'testcase';
        $stmt = $this->conn->prepare("SELECT name,ResultState FROM $table");
        $stmt->execute();

        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $this->conn->close();
        return  $rows;
    }
}
