<?php
session_start();

error_reporting(0);

$host="localhost";
$login="root";
$password="";
$db_name="lab34";
$link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
mysqli_query($link, "SET NAMES 'utf8'");
echo "<form action ='' method = 'POST'>";
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $query = "SELECT * FROM users WHERE id = '$id'";

    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);

    if($row)
    {
        printf("<p><b>Личный кабинет</b></p>");
	    printf("<p>Фамилия: " .$row['last_name']." "."<input name='last_name' placeholder='фамилия' >" ."</p>
        <p>Имя: " .$row['first_name']. " "."<input name='first_name' placeholder='имя' >" ."</p>
        <p>Отчество: " .$row['patronymic']. " "."<input name='patronymic' placeholder='отчество' >" ."</p> 
        <p>Дата рождения: " .$row['date'] . " "."<input name='date' placeholder='дата рождения' >" ."</p><br/>"
	    );  
    }


    // if(isset($_POST['first_name'])) $first_name = $_POST['first_name']; else $first_name = '';
    $query = "UPDATE users SET first_name = '$_POST[first_name]', last_name ='$_POST[last_name]'
    , patronymic = '$_POST[patronymic]', date = '$_POST[date]' WHERE id='$id'";
    mysqli_query($link,$query);
    
   
    echo "<input name = 'submit' type = 'submit' value= 'Изменить данные'>";

    echo "</form>";

} else echo "Авторизуйтесь, чтобы увидеть содержимое страницы !";




?>