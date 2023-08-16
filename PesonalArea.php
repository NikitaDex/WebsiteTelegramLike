<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/PesonalArea.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
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
      if(isset($_SESSION['id'])){
          $id = $_SESSION['id'];
          $query = "SELECT * FROM users WHERE id = '$id'";

          $result = mysqli_query($link,$query);
          $row = mysqli_fetch_array($result);

      } else $autorize =  "Авторизуйтесь, чтобы увидеть содержимое страницы !";




      ?>
    <div class="container">
      <div class="header">
        <div class="header__title"><h1><a href="messages.php" class="material-icons-outlined place">arrow_back_ios_new</a>Личный кабинет</h1></div>
      </div>
      <?php

          $host="localhost";
          $login="root";
          $password="";
          $db_name="messenger";
          $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
          mysqli_query($link, "SET NAMES 'utf8'");

          $login = $_SESSION['login'];

          $query = "SELECT image FROM images WHERE login='$login' ";

          $result = mysqli_query($link, $query);
          $row2 = mysqli_fetch_array($result);

          if( !isset($row2['image']) ){
            $display_image =  './img/no.png';
          }
          else{
            $display_image = './img/' . $row2['image'];
          }

        ?>       

      <div class="info-container">
        <?php  
          echo "<div class='block-image'>";
          echo "<img  src='$display_image' alt='Изображение не найдено'>";      
          echo "</div>";
        ?>
        <div class="name">Логин</div>
        <div class="name">Имя</div>
        <div class="name">Фамлия</div>
        <div class="name">Отчество</div>
        <div class="name">Дата рождения</div>
        <div class="info"><?php echo $row['login']; ?></div>
        <div class="info"><?php echo $row['first_name']; ?></div>
        <div class="info"><?php echo $row['last_name']; ?></div>
        <div class="info"><?php echo $row['mid_name']; ?></div>
        <div class="info"><?php echo $row['date']; ?></div>
        </div>
      <div class="buttons">
        <!-- this -->
        <div class="change-password">
          <a class="btn" href="ChangePassword.php">Изменить пароль</a>
        </div>
        <!-- this -->
        <div class="change-info"> 
          <a class="btn" href="ChangeInfo.php">Изменить данные</a>
        </div>
        <div class="delete-account">
          <a class="btn" href="DeleteAccount.php">Удалить аккаунт</a>
        </div>
        <div class="logut-account">
          <a class="btn" href="logout.php">Выйти из аккаунт</a>
        </div>
      
      </div>
      <?php  
      $host="localhost";
      $login="root";
      $password="";
      $db_name="messenger";
      $link = mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");

      if(isset($_POST['upload'])){
        $login = $_SESSION['login'];

        $file = $_FILES['image']['name'];
    
        $query = "UPDATE images SET image='$file' WHERE login='$login' ";
        $result = mysqli_query($link,$query);
        $ext = explode(".",$file);
        $target_dir = "./img/";
        $target_file = $target_dir . $file;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        header('Location: PesonalArea.php');
      }
      
      ?>
      <div class="buttons">
          <form action="" method="post" enctype="multipart/form-data" class="upl-form">
            <input type="file" name="image" id="file" accept="image/*">
            <label class="btn color-btn " for="file">
              <span class="material-icons">
                  add_photo_alternate
                  </span> &nbsp;
                Выбрать фотографию

            </label>
            <input type="submit" name="upload" value="Загрузить" class="btn color-btn upl">
          </form>
        </div>
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
