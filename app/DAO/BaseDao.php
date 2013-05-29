
<?php

class BaseDAO {

    protected $user = "student1";
    protected $password = "password";
    protected $dbname = "Banko";
    protected $dbh = null;

    function openConn(){
        $this->dbh = new PDO("mysql:host=localhost;dbname=" . $this->dbname, $this->user, $this->password);
    }

    function closeConn(){
        $this->dbh = null;
    }

}

?>