<?php
session_start();
error_reporting(0);
$host="localhost";
$login="root";
$password="";
$db_name="lab34";
$link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
mysqli_query($link, "SET NAMES 'utf8'");

if(isset($_SESSION['id'])){
    
    $id = $_SESSION['id'];
    $query = "SELECT * FROM users WHERE id = '$id'";

    $old_password = $_POST['old_password'];
    $confirm = $_POST['cofirm'];
    $new_password = $_POST['new_password'];
    
    $result = mysqli_query($link,$query);
    $user = mysqli_fetch_assoc($result);

    $hash = $user['password'];

    if(password_verify($_POST['old_password'], $hash)) {
        if( $_POST['new_password'] == $_POST['confirm']) {

        $newPasswordHash= password_hash($_POST['new_password'],PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = '$newPasswordHash' WHERE id='$id'";
        mysqli_query($link,$query);
    } else { echo "Новые пароли не совпадают !"; }
    
    } else if (isset($_POST['old_password'])){ 
        echo "Старый пароль введён неверно !"; 
    }
}

?>

<form action ='' method = 'POST'>
    <p><b>Смена пароля</b></p>
    <input name='old_password' placeholder='старый пароль' type='password'><br>
    <input name='new_password' placeholder='новый пароль' type='password'><br>
    <input name='confirm' placeholder='подтвердите новый пароль' type='password'><br>

    <input type = 'submit' value= 'Сменить пароль'><br>
</form>