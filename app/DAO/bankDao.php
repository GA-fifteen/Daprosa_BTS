<?php
include 'BaseDao.php';
class bankDao extends BaseDao {

    function register($lastName, $firstName, $gender, $address, $contact, $userName, $password, $rePassword, $register_as) {

        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT userName FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        if($stmt->fetch()){
            echo "<script> alert('username already exist!')</script>";
        }else {
            $stmt = $this->dbh->prepare("INSERT INTO users (lastName, firstName, gender, address, contact, userName, password, confirm_password, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $lastName);
            $stmt->bindParam(2, $firstName);
            $stmt->bindParam(3, $gender);
            $stmt->bindParam(4, $address);
            $stmt->bindParam(5, $contact);
            $stmt->bindParam(6, $userName);
            $stmt->bindParam(7, $password);
            $stmt->bindParam(8, $rePassword);
            $stmt->bindParam(9, $register_as);
            $stmt->execute();
        }

        $this->closeConn();
    }

    function logIn($userName,$password, $as){

        $this->openConn();

        $stmt = $this->dbh->prepare("SELECT userName, password FROM users WHERE position = ?");
        $stmt->bindParam(1, $as);
        $stmt->execute();
        $found = false;
        while($row = $stmt->fetch()){
            if($row[0]==$userName && $row[1] == $password){
                $found = true;
            }
        }

        $stmt = $this->dbh->prepare("UPDATE users SET status = 'ON' WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();

        $this->closeConn();
        return $found;
    }

    function logOut($userName){
        $this->openConn();

        $stmt=$this->dbh->prepare("UPDATE users SET status = 'OFF' WHERE userName = ? ");
        $stmt->bindParam(1, $userName);
        $stmt->execute();

        $this->closeConn();

    }

//---------------------------------------------  C U S T O M E R S  --------------------------------------------------

    function viewSavings($userName){

        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT s.date, s.deposit, s.withdraw, s.balance FROM users_to_savings AS uts, users AS u, savings AS s WHERE uts.users_id = u.users_id AND u.userName = ? AND uts.savings_id = s.savings_id");
        $stmt->bindParam(1, $userName);
        $stmt->execute();

        $this->closeConn();
        while($row = $stmt->fetch()){
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "</tr>";
        }
    }


    function viewProfileCustomer($userName){

        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT * FROM users WHERE userName = ? ");
        $stmt->bindParam(1, $userName);
        $stmt->execute();

        $this->closeConn();
        while($row = $stmt->fetch()){
            echo "<div id=".$row[0].">";
            echo "<strong>Name : </strong>  ".$row[1].", ".$row[2]."<br/><br/>";
            echo "<strong>Gender : </strong>  ".$row[3]."<br /><br/>";
            echo "<strong>Address : </strong>  ".$row[4]."<br /><br/>";
            echo "<strong>Contact No. </strong>  : ".$row[5]."<br /><br/>";
            echo "<strong>Username : </strong>  ".$row[6]."<br /><br/>";
            echo "<strong>Password : </strong>  ".$row[7]."<br /><br/>";
            echo "<button onclick='editCustomers(".$row[0].")'>edit</button>";
            echo "</div>";
        }
    }


    function editCustomer($id){

        $this->openConn();

        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE users_id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $record = $stmt->fetch();
        $bank = array("users_id"=>$record[0], "lastName"=>$record[1], "firstName"=>$record[2], "gender"=>$record[3], "address"=>$record[4], "contact"=>$record[5], "userName"=>$record[6], "password"=>$record[7], "confirm_password"=>$record[8]);
        $json_string = json_encode($bank);
        echo $json_string;

        $this->closeConn();
    }


    function saveCustomers($id, $firstName, $lastName, $gender, $address, $contact, $userName, $password, $confirm_password){

        $this->openConn();

        $stmt = $this->dbh->prepare("UPDATE users SET firstName = ?, lastName = ?, gender = ?, address = ?, contact = ?, userName = ?, password = ?, confirm_password = ? WHERE users_id = ?");
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->bindParam(3, $gender);
        $stmt->bindParam(4, $address);
        $stmt->bindParam(5, $contact);
        $stmt->bindParam(6, $userName);
        $stmt->bindParam(7, $password);
        $stmt->bindParam(8, $confirm_password);
        $stmt->bindParam(9, $id);
        $stmt->execute();


        $this->closeConn();
    }


//--------------------------------     TELLER SECTION! ---------------------------------------

    function deposit( $deposit_amount, $userName){

        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT userName FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        if($stmt->fetch()){

            $stmt = $this->dbh->prepare("INSERT INTO `Banko`.`savings` (`date`, `deposit`) VALUES ( NOW(), ?)");
            $stmt->bindParam(1, $deposit_amount);
            $stmt->execute();
            $savings_id = $this->dbh->lastInsertId();

            $stmt1=$this->dbh->prepare("SELECT users_id FROM users WHERE userName = ?");
            $stmt1->bindParam(1, $userName);
            $stmt1->execute();
            $users_id = $stmt1->fetch();

            $stmt2 = $this->dbh->prepare("INSERT INTO users_to_savings (savings_id, users_id) VALUES (?, ?)");
            $stmt2->bindParam(1, $savings_id);
            $stmt2->bindParam(2, $users_id[0]);
            $stmt2->execute();

            $stmt3=$this->dbh->prepare("SELECT sum(s.deposit) - sum(s.withdraw) FROM users_to_savings as uts, users as u, savings as s WHERE uts.users_id = u.users_id AND u.users_id = ? AND uts.savings_id = s.savings_id");
            $stmt3->bindParam(1, $users_id[0]);
            $stmt3->execute();
            $Balance = $stmt3->fetch();

            $stmt4=$this->dbh->prepare("UPDATE savings SET balance = ? WHERE savings_id = ?");
            $stmt4->bindParam(1, $Balance[0]);
            $stmt4->bindParam(2, $savings_id);
            $stmt4->execute();

            $stmt5=$this->dbh->prepare("SELECT b.balance_id FROM users AS u, users_to_balance AS utb, balance AS b WHERE utb.users_id = u.users_id AND u.users_id = ? AND utb.balance_id = b.balance_id ");
            $stmt5->bindParam(1, $users_id[0]);
            $stmt5->execute();

            if($balance_id=$stmt5->fetch()){
                $stmt6=$this->dbh->prepare("UPDATE balance SET balance = ? WHERE balance_id = ?");
                $stmt6->bindParam(1, $Balance[0]);
                $stmt6->bindParam(2, $balance_id[0]);
                $stmt6->execute();
            }else{
                $stmt7=$this->dbh->prepare("INSERT INTO balance (balance) VALUES (?)");
                $stmt7->bindParam(1, $Balance[0]);
                $stmt7->execute();

                $stmt8=$this->dbh->prepare("SELECT balance_id FROM balance ORDER BY balance_id DESC limit 1");
                $stmt8->execute();
                $bal_id=$stmt8->fetch();

                $stmt9 = $this->dbh->prepare("INSERT INTO users_to_balance (users_id, balance_id) VALUES (?, ?)");
                $stmt9->bindParam(1, $users_id[0]);
                $stmt9->bindParam(2, $bal_id[0]);
                $stmt9->execute();
            }
            echo $userName." added Php ".$deposit_amount." to his/her savings account";
        }else{
            echo $userName." didn't exist!";
        }

        $this->closeConn();
    }


    function withdraw( $withdraw_amount, $userName){
        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT userName FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        if($stmt->fetch()){

            $stmt = $this->dbh->prepare("SELECT b.balance FROM users_to_balance AS utb, users AS u, balance AS b WHERE utb.users_id = u.users_id AND utb.balance_id = b.balance_id AND u.userName = ?");
            $stmt->bindParam(1, $userName);
            $stmt->execute();
            $remainBal=$stmt->fetch();

            if($remainBal[0]>$withdraw_amount){

                $stmt1 = $this->dbh->prepare("INSERT INTO `Banko`.`savings` (`date`, `withdraw`) VALUES (NOW(), ?)");
                $stmt1->bindParam(1, $withdraw_amount);
                $stmt1->execute();
                $savings_id = $this->dbh->lastInsertId();

                $stmt2=$this->dbh->prepare("SELECT users_id FROM users WHERE userName = ?");
                $stmt2->bindParam(1, $userName);
                $stmt2->execute();
                $users_id = $stmt2->fetch();

                $stmt3 = $this->dbh->prepare("INSERT INTO users_to_savings (savings_id, users_id) VALUES (?, ?)");
                $stmt3->bindParam(1, $savings_id);
                $stmt3->bindParam(2, $users_id[0]);
                $stmt3->execute();

                $stmt4=$this->dbh->prepare("SELECT sum(s.deposit) - sum(s.withdraw) FROM users_to_savings as uts, users AS u, savings as s WHERE uts.users_id = u.users_id AND u.users_id = ? AND uts.savings_id = s.savings_id");
                $stmt4->bindParam(1, $users_id[0]);
                $stmt4->execute();
                $Balance = $stmt4->fetch();

                $stmt5=$this->dbh->prepare("UPDATE savings SET balance = ? WHERE savings_id = ?");
                $stmt5->bindParam(1, $Balance[0]);
                $stmt5->bindParam(2, $savings_id);
                $stmt5->execute();

                $stmt6=$this->dbh->prepare("SELECT b.balance_id FROM users AS u, users_to_balance AS utb, balance AS b WHERE utb.users_id = u.users_id AND u.users_id = ? AND utb.balance_id = b.balance_id ");
                $stmt6->bindParam(1, $users_id[0]);
                $stmt6->execute();
                $balance_id=$stmt6->fetch();

                $stmt7=$this->dbh->prepare("UPDATE balance SET balance = ? WHERE balance_id = ?");
                $stmt7->bindParam(1, $Balance[0]);
                $stmt7->bindParam(2, $balance_id[0]);
                $stmt7->execute();

            }else {
                echo "<script> alert('opps!');</script>";
                echo "<script id='error'> alert('Sorry, Your balance is ".$remainBal[0]." peso/s only!')</script>";
                echo "<script> alert('THANK YOU :)');</script>";
            }
            echo $userName." withdraw Php ".$withdraw_amount." from his/her savings account";
        }else{
            echo $userName." didn't exist!";
        }

        $this->closeConn();
    }


    function addCustomer($firstName, $lastName, $gender, $address, $contact, $userName, $password, $confirm_password, $position, $status){
        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT userName FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Username already exist!";
        }else{
            $stmt=$this->dbh->prepare("INSERT INTO users(lastName, firstName, gender, address, contact, userName, password, confirm_password, position, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $lastName);
            $stmt->bindParam(2, $firstName);
            $stmt->bindParam(3, $gender);
            $stmt->bindParam(4, $address);
            $stmt->bindParam(5, $contact);
            $stmt->bindParam(6, $userName);
            $stmt->bindParam(7, $password);
            $stmt->bindParam(8, $confirm_password);
            $stmt->bindParam(9, $position);
            $stmt->bindParam(10, $status);
            $stmt->execute();
        }

        $this->closeConn();
    }


//---------------------------------   ADMIN -----------------------------------------

    function viewTellers(){
        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT * FROM users WHERE position = 'Teller' ORDER BY lastName");
        $stmt->execute();

        $this->closeConn();
        while($row = $stmt->fetch()){
            echo "<tr user_id=".$row[0].">";
            echo "<td>".$row[1].", ".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "<td>".$row[10]."</td>";
            echo "</tr>";
        }
    }


    function addTeller($firstName, $lastName, $gender, $address, $contact, $userName, $password, $confirm_password, $position, $status){
        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT userName FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        if($stmt->fetch()){
            echo "Username already exist!')";
        }else{
            $stmt=$this->dbh->prepare("INSERT INTO users(lastName, firstName, gender, address, contact, userName, password, confirm_password, position, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $lastName);
            $stmt->bindParam(2, $firstName);
            $stmt->bindParam(3, $gender);
            $stmt->bindParam(4, $address);
            $stmt->bindParam(5, $contact);
            $stmt->bindParam(6, $userName);
            $stmt->bindParam(7, $password);
            $stmt->bindParam(8, $confirm_password);
            $stmt->bindParam(9, $position);
            $stmt->bindParam(10, $status);
            $stmt->execute();
        }

        $this->closeConn();
    }


    function searchTeller($searchTeller){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT users_id, lastName, firstName, gender, address, contact, userName, status FROM users WHERE lastName like '".$searchTeller."%' AND position = 'Teller' ORDER BY lastName");
        $stmt->execute();
        $found = false;
        while ($row =$stmt->fetch()){
            echo "<tr user_id=".$row[0].">";
            echo "<td>".$row[1].", ".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td>".$row[4]."</td>";
            echo "<td>".$row[5]."</td>";
            echo "<td>".$row[6]."</td>";
            echo "<td>".$row[7]."</td>";
            echo "</tr>";
            $found=true;
        }
        if(!$found){
            echo "<tr><td colspan='7'><center><strong>"." ".$searchTeller."</strong>   doesn't exist .."."</center></td></tr>";
        }
    }


//-----------------------------------       BOTH admin and teller   ----------------------------

    function viewCustomer(){

        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT u.users_id, u.lastName, u.firstName, b.balance FROM users_to_balance AS utb, users AS u, balance AS b WHERE u.users_id = utb.users_id AND b.balance_id=utb.balance_id AND u.position = 'Customer' ORDER BY u.lastName");
        $stmt->execute();

        $this->closeConn();
        while($row = $stmt->fetch()){
            echo "<tr id=".$row[0].">";
            echo "<td>".$row[1].", ".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td><button class='btn btn-info' onclick='viewCustomersInfo(".$row[0].")'>Customers' Info</button>";
            echo "<button class='btn btn-primary' onclick='viewSavingsRecords(".$row[0].")'>Savings Records</button></td>";
            echo "</tr>";
        }
    }


    function search($search){
        $this->openConn();
        $stmt = $this->dbh->prepare("SELECT u.users_id, u.lastName, u.firstName, b.balance FROM users_to_balance AS utb, users AS u, balance AS b WHERE u.users_id = utb.users_id AND b.balance_id=utb.balance_id AND u.position = 'Customer' AND u.lastName like '".$search."%'  ORDER BY u.lastName");
        $stmt->execute();
        $found = false;
        while ($row =$stmt->fetch()){
            echo "<tr id=".$row[0].">";
            echo "<td>".$row[1].", ".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "<td><button class='btn btn-info' onclick='viewCustomersInfo(".$row[0].")'>Customers' Info</button>";
            echo "<button class='btn btn-primary' onclick='viewSavingsRecords(".$row[0].")'>Savings Records</button></td>";
            echo "</tr>";
            $found=true;
        }
        if(!$found){
            echo "<tr><td colspan='6'><center><strong>"." ".$search."</strong>   doesn't exist .."."</center></td></tr>";
        }
    }


    function viewCustomersInfo($id){

        $this->openConn();

        $stmt=$this->dbh->prepare("SELECT * FROM users WHERE users_id = ? ");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $this->closeConn();
        while($row = $stmt->fetch()){
            echo "<div id=".$row[0].">";
            echo "<strong>Name :  </strong> ".$row[1].", ".$row[2]." <br/><br/>";
            echo "<strong>Gender : </strong>   ".$row[3]."<br /><br/>";
            echo "<strong>Address : </strong>   ".$row[4]."<br /><br/>";
            echo "<strong>Contact No. </strong>   : ".$row[5]."<br /><br/>";
            echo "<strong>Username :  </strong>  ".$row[6]."<br /><br/>";
            echo "</div>";
        }
    }


    function viewSaving($id){

        $this->openConn();

        $stmt = $this->dbh->prepare("SELECT s.date, s.deposit, s.withdraw, s.balance FROM  users_to_savings AS uts, users AS u, savings AS s WHERE u.users_id = uts.users_id AND u.users_id= ? AND s.savings_id=uts.savings_id");
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $this->closeConn();
        while($row=$stmt->fetch()){
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "<td>".$row[3]."</td>";
            echo "</tr>";
        }
    }


//----------------------------------  Teller and Customer  ----------------------------

    function viewName($userName){
        $this->openConn();
        $stmt=$this->dbh->prepare("SELECT users_id, firstName, lastName, position FROM users WHERE userName = ?");
        $stmt->bindParam(1, $userName);
        $stmt->execute();
        $data = $stmt->fetch();

        $this->closeConn();
        if($data[3] == 'Customer'){
            echo $data[1]." ".$data[2]." !";
        }else{
            echo $data[0]." : ";
            echo $data[1]." ".$data[2];
        }
    }

}
?>