<?php
 session_start();
    $host="localhost";
    $login="root";
    $password="";
    $db_name="lab34";
    $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
    mysqli_query($link, "SET NAMES 'utf8'");

    if(!empty($_POST["login"])&&!empty($_POST["password"]))
    {
        $login=$_POST['login'];
        $password=md5($_POST['password']);

        // $query="SELECT * FROM users WHERE login='$login'";
        $query = "SELECT *,statuses.name as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id WHERE login='$login'";
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
                } else {echo "Вы забанены !"; }
            } else {
                echo "Пароль не подошёл !";
            }
        } else {
            // Пользователь не авторизовался
            echo "Пользователя с таким логином нет !"."<br />";
            
            echo "<a href='login.php'>Попробовать снова</a>";

        }

    }

    if(empty($_SESSION['auth'])){
        echo 
        "<form action ='' method = 'POST'>
            <input name='login'><br>
            <input name='password' type='password'><br>
            <input type = 'submit' value= 'Send'><br>
            <a href='index.php'>index.php</a>
        </form>";
    } else {
        echo "Куда вы хотите попасть ?"."<br />";
        echo "<a href='1.php'>1.php</a>"."<br />";
        echo "<a href='2.php'>2.php</a>"."<br />";
        echo "<a href='3.php'>3.php</a>"."<br />";
        echo "<a href='index.php'>index.php</a>.<br />";
        echo "<a href='logout.php'>Logout</a>";
    }

?>


