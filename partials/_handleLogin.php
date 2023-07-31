<?php
$showError="false";
if($_SERVER['REQUEST_METHOD']=='POST'){
    require '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row=mysqli_fetch_assoc($result);
        if(password_verify($pass,$row['user_pass'])){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['useremail']=$email;
            $_SESSION['sno']=$row['sno'];
            header("Location: /forum/index.php");
            exit();
        } 
        else{
            $showError = "Wrong Password";
            header("Location: /forum/index.php?loginerror=$showError");
        }
    }
    else{
        $showError = "Wrong email address";
        header("Location: /forum/index.php?loginerror=$showError");
    }
}
?>