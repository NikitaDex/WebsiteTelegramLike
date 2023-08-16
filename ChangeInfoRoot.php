<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/ChangeInfo.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <title>Личный кабинет</title>
  </head>
  <!-- 6 -->
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
      // echo "<form action ='' method = 'POST'>";
      if($_SESSION['login'] == 'root'){
          $id = $_SESSION['choosen'];
          $query = "SELECT * FROM users WHERE login = '$id'";

          $result = mysqli_query($link,$query);
          $row = mysqli_fetch_array($result);
        
        if(!empty($_POST['first_name'])) $first_name = $_POST['first_name']; else $first_name = $row['first_name'];
        if(!empty($_POST['mid_name'])) $mid_name = $_POST['mid_name']; else $mid_name = $row['mid_name'];
        if(!empty($_POST['last_name'])) $last_name = $_POST['last_name']; else $last_name = $row['last_name'];
        if(!empty($_POST['date'])) $date = $_POST['date']; else $date = $row['date'];
        if(!empty($_POST['login'])) $login = $_POST['login']; else $login = $row['login'];

        $query = "UPDATE users SET first_name = '$first_name', last_name ='$last_name',
        mid_name ='$mid_name', date = '$date', login = '$login' WHERE login='$id'";
        mysqli_query($link,$query);
    
  

      } else $autorize = "Авторизуйтесь, чтобы увидеть содержимое страницы !";




      ?>
    <div class="container">
      <div class="header">
        <div class="header__title"><h1><a href="PesonalArea_select_user.php" class="material-icons-outlined place">arrow_back_ios_new</a>Личный кабинет</h1></div>
      </div>
      <form action="" method="POST">
        <div class="info-container">
          <div class="name">Логин</div>
          <div class="name">Имя</div>
          <div class="name">Фамлия</div>
          <div class="name">Отчество</div>
          <div class="name">Дата рождения</div>
          <div class="info"><input class="input" placeholder="Логин" type="text" name="login" id=""></div>        
          <div class="info"><input class="input" placeholder="Имя" type="text" name="first_name" id=""></div>
          <div class="info"><input class="input" placeholder="Фамилия" type="text" name="last_name" id=""></div>
          <div class="info"><input class="input" placeholder="Отчество" type="text" name="mid_name" id=""></div>
          <div class="info"><input class="input" placeholder="Дата рождения" type="date" name="date" id=""></div>


        </div>
        <div class="buttons">
          <div class="change-info">
            <input type="submit" name="submit" value="Изменить данные" class="btn">
          </div>

        </div>
      </form>
      <?php if(isset($autorize))
        echo "<div class='error'>"
        ?>
        <?php
          if(isset($autorize))
            echo $autorize;          
          ?>
        <?php if(isset($autorize))
        echo "</div>"?>
    </div>
  </body>
</html>
