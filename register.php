<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация</title>
    <link rel="stylesheet" href="./css/register.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
  </head>
  <body>
    <?php 

    class User{
      public $login, $password, $first_name, $last_name, $patronymic, $date;
      public function __construct($login, $password, $first_name, $last_name, $patronymic, $date)
      {
          $this->login = $login;
          $this->password = $password;
          $this->first_name = $first_name;
          $this->last_name = $last_name;
          $this->patronymic = $patronymic;
          $this->date = $date;
      }

      public function makeQueryToInsert()
      {
        return "INSERT INTO users SET login='$this->login', password = '$this->password',
        date='$this->date', first_name='$this->first_name', 
        last_name='$this->last_name', mid_name = '$this->patronymic', status_id = '1', banned = '0'";
      }

      public function makeQueryToInsertImage($image = 'no.png')
      {
        return "INSERT INTO images SET login='$this->login' , image=$image ";
      }
    }
    session_start();
    error_reporting(0); 

    $host="localhost";
    $login="root";
    $password="";
    $db_name="messenger";
    $link=mysqli_connect($host,$login,$password,$db_name) or
    die("Connection failed");
    mysqli_query($link, "SET NAMES 'utf8'");


    if ($_POST['password'] == $_POST['confirm']) { // Совпадают ли пароли
      $user = new User($_POST['login'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['first_name'],
      $_POST['last_name'], $_POST['mid_name'], $_POST['date']);

      if( ($_POST['kapcha'] == $_SESSION['rand_code'])){
        if(preg_match('/^[a-zA-Z0-9]+$/',$login) && isset($_POST['login'])){ // Проверяем логин на латинские буквы и цифры
            if (strlen($login) > 3 and strlen($login) < 11){ // Проверяем Логин на кол-во символов
                if (strlen($_POST['password']) > 5 and strlen($_POST['password']) < 13){ // Проверяем Пароль на кол-во символов
             
      mysqli_query($link,$user->makeQueryToInsert());
      mysqli_query($link,$user->makeQueryToInsertImage());

      $_SESSION['login'] = $_POST['login'];
      $_SESSION['auth'] = true;
      header('Location: login.php');
      
      $id = mysqli_insert_id($link);
      $_SESSION['id'] = $id;


      
                } else { $above_pass = "Пароль должен быть от  6 до 12 символов !";}
              } else { $above_log = "Логин должен быть от 4 до 10 символов !";  }
        }  else {  $above_log = "Логин дожен содержать только латинские буквы и цифры !"; }
      } else {$above_kap = "Капча введена неверно  !";}
    } else { $above_pass = "Пароли не совпали, попробуйте ещё раз";  }
    ?>
    <div class="container">
      <div class="header">
        <div class="header__content">
          <a class="header__enter" href="login.php">Вход</a>
          <a class="header__registration" href="">Регистрация</a>
        </div>
      </div>

      <div class="main">
        <div class="main__content">
          <form class="main__form" action="" method="POST">
          <?php if (isset($above_log)) echo "<p>".$above_log."</p>"; ?>
            <input
              required
              class="main__login input"
              placeholder="Логин"
              type="text"
              name="login"
              id=""
            />
            <?php if (isset($above_pass)) echo "<p>".$above_pass."</p>"; ?>
            <input
              required
              class="main__password input"
              placeholder="Пароль"
              type="password"
              name="password"
              value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>"
            />
            <input
              required
              class="main__verify-password input"
              placeholder="Подтвердите пароль"
              type="password"
              name="confirm"
              value="<?php if(isset($_POST['confirm'])) echo $_POST['confirm']; ?>"
            />
            <input
              required
              class="main__first-name input"
              placeholder="Имя"
              type="text"
              name="first_name"
              id=""
              value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"
            />
            <input
              required
              class="main__last-name input"
              placeholder="Фамилия"
              type="text"
              name="last_name"
              id=""
              value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>"
            />
            <input
              required
              class="main__mid-name input"
              placeholder="Отчество"
              type="text"
              name="mid_name"
              id=""
              value="<?php if(isset($_POST['mid_name'])) echo $_POST['mid_name']; ?>"
            />
            <input
              required
              class="main__year input"
              placeholder="Дата рождения (год)"
              type="date"
              name="date"
            />
            <?php if (isset($above_kap) && isset($_POST['kapcha'])) echo "<p>".$above_kap."</p>"; ?>
            <img src ="captcha.php"/>
            <input required class="capch input" placeholder="Капча" type="text" name="kapcha" />
            <input
              class="main__submit"
              type="submit"
              name="submit"
              id=""
              value="Регистрация"
            />
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
