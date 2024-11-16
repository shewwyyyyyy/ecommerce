<?php

if(!isset($_SESSION)){
    session_start();
}

require_once(__DIR__."/../config/Directories.php"); //to handle folder specific path
include("..\config\DatabaseConnect.php"); //to access database connection

if(!isset($_SESSION["user_id"])){
    header("location:".BASE_URL. "login.php");
    exit;
}

$db = new DatabaseConnect(); //make a new database instance

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $productId      = htmlspecialchars($_POST["id"]);
    $quantity       = htmlspecialchars($_POST["quantity"]);
    $userId         = $_SESSION["user_id"];

    if(trim($productId) == "" || empty($productId)){
        $_SESSION["error"] = "Product ID field is empty";

        header("location: ".BASE_URL."views/product/product.php?id=".$productId);
        exit;
    }

    if(trim($quantity) == "" || empty($quantity) || $quantity < 1){
        $_SESSION["error"] = "Quantity field is empty";
            
        header("location: ".BASE_URL."views/product/product.php?id=".$productId);
        exit;
     }
     
    if(trim($userId) == "" || empty($userId)){
        $_SESSION["error"] = "userId field is empty";

        header("location: ".BASE_URL."views/product/product.php?id=".$productId);
        exit;
    }

    
  
    try {
    $conn = $db->connectDB();
    
    $_SESSION["success"] = "Added to cart successfully";
        header("location: ".BASE_URL."views/product/product.php?id=".$productId);
        exit;
    } catch (PDOException $e) {
        echo "Connection Failed: " . $e->getMessage();
        $db = null;
    }


}

