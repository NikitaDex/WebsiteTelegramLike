<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Вход</title>
    <link rel="stylesheet" href="./css/login.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
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

        if(!empty($_POST["login"])&&!empty($_POST["password"]))
        {
            $login=$_POST['login'];
            $password=md5($_POST['password']);
  
            $query = "SELECT *,users.id,statuses.name as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id WHERE login='$login'";
            $result=mysqli_query($link, $query);
            $user=mysqli_fetch_assoc($result);
    
    
            if (!empty($user)){
                $hash = $user['password'];
    
                if( password_verify($_POST['password'], $hash)){
    
                    if($user['banned'] != '1'){
    
                      $_SESSION['auth'] = true;
                      $_SESSION['login'] = $_POST['login'];
                      $_SESSION['id'] = $user['id'];
                      $_SESSION['status'] = $user['status'];
                      header('Location: messages.php');
                    } else { $banned_user = "Вы забанены !"; }
                } else {
                    $incorrect_pass = "Пароль не подошёл !";
                }
            } else {
                // Пользователь не авторизовался
                $no_login = "Пользователя с таким логином нет !";
                  
            }
    
        }
    ?>
    <div class="container">
      <div class="header">
        <div class="header__content">
          <a class="header__enter" href="">Вход</a>
          <a class="header__registration" href="register.php">Регистрация</a>
        </div>
      </div>

      <div class="main">
        <div class="main__content">
          <form class="main__form" action="" method="POST">
            <input
              required
              class="main__login"
              placeholder="Логин"
              type="text"
              name="login"
              id=""
            />
            <input
              required
              class="main__password"
              placeholder="Пароль"
              type="password"
              name="password"
            />
            <input
              class="main__submit"
              type="submit"
              name="submit"
              id=""
              value="Войти"
            />
          </form>
        </div>
        <?php if(isset($banned_user) or isset($incorrect_pass) or isset($no_login))
        echo "<div class='error'>"
        ?>
        <?php
          if(isset($banned_user))
            echo $banned_user;
          if(isset($incorrect_pass))
            echo $incorrect_pass;
          if(isset($no_login))
            echo $no_login ;
          
          ?>
        <?php if(isset($banned_user) or isset($incorrect_pass) or isset($no_login))
        echo "</div>"?>
      </div>
    </div>
  </body>
</html>
