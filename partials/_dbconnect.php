<?php
$servername = "localhost";
$username = "root";
$password ="";
$database = "idiscuss";

$conn =  mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("Sorry,we are unable to connect to the server because of this error:" . mysqli_connect_errno());
}
?>