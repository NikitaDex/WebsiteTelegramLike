<?php
session_start();


if (isset($_GET['del'])) {
    $link=mysqli_connect('localhost','root','','lab34');
    $del = $_GET['del'];
    $query = "DELETE FROM users WHERE login='$del'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    }

if (isset($_GET['updToAdmin'])) {
    $link=mysqli_connect('localhost','root','','lab34');
    $updToAdmin = $_GET['updToAdmin'];
    $query = "UPDATE users SET status_id = '2' WHERE login='$updToAdmin'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    }

if (isset($_GET['updToUser'])) {
    $link=mysqli_connect('localhost','root','','lab34');
    $updToUser = $_GET['updToUser'];
    $query = "UPDATE users SET status_id = '1' WHERE login='$updToUser'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    }

if (isset($_GET['ban'])) {
    $link=mysqli_connect('localhost','root','','lab34');
    $ban = $_GET['ban'];
    $query = "UPDATE users SET banned = '1' WHERE login='$ban'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    }

if (isset($_GET['unban'])) {
    $link=mysqli_connect('localhost','root','','lab34');
    $unban = $_GET['unban'];
    $query = "UPDATE users SET banned = '0' WHERE login='$unban'";
    mysqli_query($link, $query) or die(mysqli_error($link));
    }

?>

<!DOCTYPE html>
<html>
    <body>
        <header>
        <?php  echo "Ваш логин:  $_SESSION[login]"."<br/>";
        echo  "Ваш статус:  $_SESSION[status]"."<br/>"; 
        if($_SESSION['status']=='admin') {
            echo "<a href=admin.php>Go to admin page</a>";
        }
        ?>
        </header>
        <table border='1' >
        <caption>Таблица пользователей</caption>
        <tr>
    <th>Login</th>
    <th>Status</th>
    <th>Update status</th>
    <th>Ban</th>
    <th>Ban status</th>
    <th>Delete</th>
        </tr>
<?php
    $host="localhost";
    $login="root";
    $password="";
    $db_name="lab34";
    $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
    mysqli_query($link, "SET NAMES 'utf8'");

    if(!empty($_SESSION['auth']) and $_SESSION['status'] == 'admin'){
        $query = "SELECT *,statuses.name as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id";
        $result=mysqli_query($link, $query);

        while($user=mysqli_fetch_assoc($result)){

            if($user['status'] == 'admin') {
                echo "<table bordercolor='red' border='1'> <tr> <td> $user[login] </td><td> $user[status] </td>"; 
                echo '<td> <a href="?updToUser=' . $user['login'] .'" >Update to user</a> </td>';
                
            }
            else {
                echo "<table bordercolor='green' border='1'> <tr> <td> $user[login] </td><td> $user[status] </td>"; 
                echo '<td> <a href="?updToAdmin=' . $user['login'] .'" >Update to admin</a> </td>';
            }
            
            if($user['banned'] == false){
                echo '<td> <a href="?ban=' . $user['login'] .'" >Ban</a> </td>';
                echo "<td>Не забанен</td>";
            } else {
                echo '<td> <a href="?unban=' . $user['login'] .'" >Unban</a> </td>';
                echo "<td>Забанен</td>";
            }

            echo '<td> <a href="?del=' . $user['login'] .'" >delete</a> </td> </tr> </table>';

        }
    }
        

?>

        </table>
    </body>
</html>