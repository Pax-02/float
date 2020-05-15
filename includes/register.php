<?php

require_once 'dbConn.php';

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "bathan@02";
$dbname = "nancy";


function signup($username, $password_1, $password_2) {
    $conn = DBConnect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
    
    


    
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords entered are not the same");
    }

    else{
        $hashedpassword = HashWithMD5($password_1);
        $query = "INSERT INTO users(username, password) "
        ."VALUES('$username', '$hashedpassword')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            header('location: index.html');
        } else {
            echo "Could not insert record! " . mysqli_error($conn);
        }
    

    }


    
}

function CheckUser($username,$password){
    
    $conn = DBConnect($GLOBALS['dbhost'], $GLOBALS['dbuser'], $GLOBALS['dbpass'], $GLOBALS['dbname']);
    $hashedpassword = HashWithMD5($password);
    $query="SELECT * FROM users Where username='$username' AND password='$hashedpassword'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if ($count==1){
        session_start();
        $_SESSION['user']= $username;
        $_SESSION['sucess']="Loged in successfully";
        header('location: index.php');
    }
    else{
        echo("wrong credentials".mysqli_error($conn));
        header('location: login.php');

    }

}
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// when a button named logout is pressed
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.html");
}

function HashWithMD5($text) {
    $hashedpassword = MD5($text);
    return $hashedpassword;
}



?>
