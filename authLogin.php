<?php 
//recevived user input
$username = $_POST["username"];
$password = $_POST["password"];

session_start();


if($_SERVER["REQUEST_METHOD"] == "POST"){
  //connect db
        
        $host = "localhost";
        $database = "ecommerce";
        $dbusername = "root";
        $dbpassword = "";
        $dsn = "mysql: host=$host;dbname=$database;";

        try {
        $conn = new PDO($dsn, $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT * from users WHERE username = :p_username");
        $stmt -> bindParam(':p_username', $username);
        $stmt -> execute();
        $users = $stmt->fetchAll();

        if($users){
           if(password_verify($password, $users[0]["password"])){
               echo "login successful";
               $_SESSION["fullname"] = $users[0]["fullname"];
               
           } else{
               echo "password did not match";
           }
        } else{
            echo "user not exist";
        }
        
    
        } catch (Exception $e){
            echo "Connection Failed: " . $e->getMessage();
        }

       
        
            

    }

?>