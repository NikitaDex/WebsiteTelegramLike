<?php
    session_start();    

    $host="localhost";
    $login="root";
    $password="";
    $db_name="lab34";
    $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
    mysqli_query($link, "SET NAMES 'utf8'");


    if(!empty($_POST["login"]) and !empty($_POST["password"]) and !empty($_POST['confirm'])) // Заполнены ли основные поля
    {
        if ($_POST['password'] == $_POST['confirm']) { // Совпадают ли пароли
        $login=$_POST['login'];
        $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $patronymic = $_POST['patronymic'];
        
        $date = $_POST['date'];
        $date = preg_replace('/[^0-9\.]/u', '', trim($date));
        $date_arr = explode('.',$date);

        $query = "SELECT * FROM users WHERE login='$login'";
        $user = mysqli_fetch_assoc(mysqli_query($link,$query));

if(preg_match('/^[a-zA-Z0-9]+$/',$login)){ // Проверяем логин на латинские буквы и цифры
    if (empty($user)){ // Проверяем есть ли такой логин
        if (strlen($login) > 3 and strlen($login) < 11){ // Проверяем Логин на кол-во символов
            if (strlen($_POST['password']) > 5 and strlen($_POST['password']) < 13){ // Проверяем Пароль на кол-во символов
                if (checkdate($date_arr[1],$date_arr[0],$date_arr[2])){ // Проверяем дату
        $query = "INSERT INTO users SET login='$login', password = '$password',
        date='$date', first_name='$first_name', 
        last_name='$last_name', patronymic = '$patronymic', status_id = '1', banned = '0'";
        mysqli_query($link,$query);

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['auth'] = true;
        header('Location: login.php');
        
        $id = mysqli_insert_id($link);
        $_SESSION['id'] = $id;
    } else { $above_date = "Дата введена некорректно !"; }
    } else { $above_pass = "Пароль должен быть от  6 до 12 символов !";}
    } else { $above_log = "Логин должен быть от 4 до 10 символов !";  }
    } else { $above_log = "Такой логин уже занят, введите другой"; }
    } else {  $above_log = "Логин дожен содержать только латинские буквы и цифры !"; }
    } else { $above_pass = "Пароли не совпали, попробуйте ещё раз";  }
    } else  if (isset($_POST['submit'])){   $above_log = "Введите Логин и Пароль !"; }
    
?> 

<form action ='' method = 'POST'>
    <p>Регистрация</p>
    <?php if (isset($above_log)) echo "<p>".$above_log."</p>"; ?>
    <input name='login' placeholder='логин' value="<?php if(isset($_POST['login'])) echo $_POST['login']; ?>"><br>
    <?php if (isset($above_pass)) echo "<p>".$above_pass."</p>"; ?>
    <input name='password' type='password' placeholder='пароль' value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>"><br>
    <input name='confirm' type='password' placeholder='подтвердить пароль' value="<?php if(isset($_POST['confirm'])) echo $_POST['confirm']; ?>"><br>
    
    <input name='first_name' placeholder='имя' value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"><br>
    <input name='last_name' placeholder='фамилия' value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>"><br>    
    <input name='patronymic' placeholder='отчество' value="<?php if(isset($_POST['patronymic'])) echo $_POST['patronymic']; ?>"><br>

    <?php if (isset($above_date)) echo "<p>".$above_date."</p>";  ?>
    <input name='date' placeholder='ДР (день.месяц.год)' value="<?php if(isset($_POST['date'])) echo $_POST['date']; ?>"><br>
   

<br><input name = 'submit' type = 'submit' value= 'Зарегистрироваться'><br>
    
</form> 