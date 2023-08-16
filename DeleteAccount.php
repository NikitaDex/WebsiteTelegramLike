<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/DeleteAccount.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <title>Удалить аккаунт</title>
  </head>
  <body>
  <?php
    session_start();
    error_reporting(0);
    $host="localhost";
    $login="root";
    $password="";
    $db_name="messenger";
    $link=mysqli_connect($host,$login,$password,$db_name) or
    die("Connection failed");
    mysqli_query($link, "SET NAMES 'utf8'");
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($link,$query);
    $user = mysqli_fetch_assoc($result);
    $hash = $user['password'];
    if(password_verify($_POST['password'], $hash)) {
    $query = "DELETE FROM users WHERE id='$id'";
    mysqli_query($link,$query);
    header('Location: register.php');
    } else if (isset($_POST['password'])){
    $error_pass = "Пароль введен неверно !";
    }
  ?>
    <div class="header">
      <div class="header__title"><h1><a href="PesonalArea.php" class="material-icons-outlined place">arrow_back_ios_new</a>Удалить аккаунт</h1></div>
    </div>
    <div class="main">
      <div class="main__content">
        <form class="main__form" action="" method="POST">
          <input
            required
            class="password input"
            placeholder="Пароль"
            type="password"
            name="password"
            id=""
          />
          <input
            class="main__submit"
            type="submit"
            name="submit"
            id=""
            value="Удалить аккаунт"
          />
        </form>
      </div>
      <?php if(isset($error_pass))
        echo "<div class='error'>"
        ?>
        <?php
          if(isset($error_pass))
            echo $error_pass;          
          ?>
        <?php if(isset($error_pass))
        echo "</div>"?>
    </div>
  </body>
</html>
