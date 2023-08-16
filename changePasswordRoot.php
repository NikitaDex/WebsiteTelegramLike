<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/ChangePassword.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Изменить пароль</title>
  </head>
  <body>
  <?php
      session_start();
      error_reporting(0);
      $host="localhost";
      $login="root";
      $password="";
      $db_name="messenger";
      $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
      mysqli_query($link, "SET NAMES 'utf8'");

      if($_SESSION['login'] == 'root'){
          
          $id = $_SESSION['choosen'];
           // this
          $query = "SELECT * FROM users WHERE login = '$id'";
         
          
          $confirm = $_POST['cofirm'];
          $new_password = $_POST['new_password'];
          
          $result = mysqli_query($link,$query);
          $user = mysqli_fetch_assoc($result);

  

          
            if( $_POST['new_password'] == $_POST['confirm']) {

              $newPasswordHash= password_hash($_POST['new_password'],PASSWORD_DEFAULT);

              $query = "UPDATE users SET password = '$newPasswordHash' WHERE login='$id'";
              mysqli_query($link,$query);
          } else { $new_pass_dont_eq = "Пароли не совпадают !"; }
          
          } 
      

  ?>
    <div class="header">
      <div class="header__title"><h1><a href="PesonalArea_select_user.php" class="material-icons-outlined place">arrow_back_ios_new</a>Изменить пароль</h1></div>
    </div>
    <div class="main">
      <div class="main__content">
        <form class="main__form" action="" method="POST">
          <input
            required
            class="new-password input"
            placeholder="Новый пароль"
            type="password"
            name="new_password"
          />
          <input
            required
            class="repeat-new-password input"
            placeholder="Подтвердить новый пароль"
            type="password"
            name="confirm"
          />
          <input
            class="main__submit"
            type="submit"
            name="submit"
            id=""
            value="Изменить пароль"
          />
        </form>
      </div>
      <?php if(isset($new_pass_dont_eq) or isset($old_pass_uncorrect) )
        echo "<div class='error'>"
        ?>
        <?php
          if(isset($new_pass_dont_eq))
            echo $new_pass_dont_eq;        
          ?>
        <?php if(isset($new_pass_dont_eq) or isset($old_pass_uncorrect) )
        echo "</div>"?>
    </div>
  </body>
</html>
