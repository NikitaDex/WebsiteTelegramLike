<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <title>Admin's page</title>
</head>
<body>
    <?php
    error_reporting(0); 
    session_start();


    if (isset($_GET['del'])) {
        $link=mysqli_connect('localhost','root','','messenger');
        $del = $_GET['del'];
        $query = "DELETE FROM users WHERE login='$del'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        }

    if (isset($_GET['updToAdmin'])) {
        $link=mysqli_connect('localhost','root','','messenger');
        $updToAdmin = $_GET['updToAdmin'];
        $query = "UPDATE users SET status_id = '2' WHERE login='$updToAdmin'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        }

    if (isset($_GET['updToUser'])) {
        $link=mysqli_connect('localhost','root','','messenger');
        $updToUser = $_GET['updToUser'];
        $query = "UPDATE users SET status_id = '1' WHERE login='$updToUser'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        }

    if (isset($_GET['ban'])) {
        $link=mysqli_connect('localhost','root','','messenger');
        $ban = $_GET['ban'];
        $query = "UPDATE users SET banned = '1' WHERE login='$ban'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        }

    if (isset($_GET['unban'])) {
        $link=mysqli_connect('localhost','root','','messenger');
        $unban = $_GET['unban'];
        $query = "UPDATE users SET banned = '0' WHERE login='$unban'";
        mysqli_query($link, $query) or die(mysqli_error($link));
        }

    ?>

    <?php
        $host="localhost";
        $login="root";
        $password="";
        $db_name="messenger";
        $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
        mysqli_query($link, "SET NAMES 'utf8'");
    ?>

    <div class="container">
        <div class="header">
            <div class="header__title"><h1>Admin's page</h1></div>
        </div>
        <div class="info-container">
            <div class="user-info">
                <div>Ваш логин : <?php echo $_SESSION['login']; ?></div>
                <div> | </div>
                <div>Ваш статус : <?php echo $_SESSION['status']; ?></div>
            </div>
        </div>
        <div class="container__table">
            <table>
                <tr>
                    <th>Login</th>
                    <th>Status</th>
                    <th>Update Status</th>
                    <th>Ban</th>
                    <th>Ban Status</th>
                    <th>Delete</th>
                </tr>
                <?php
                
                if(!empty($_SESSION['auth'])) {
                    if ($_SESSION['status'] == 'admin'){
                    $query = "SELECT *,statuses.name as status FROM users LEFT JOIN statuses ON users.status_id=statuses.id";
                    $result=mysqli_query($link, $query);
            
                    while($user=mysqli_fetch_assoc($result)){
            
                        if($user['status'] == 'admin') {
                            echo "<table style='background-color: rgba(201, 0, 62, 0.5);' > <tr> <td> $user[login] </td><td> $user[status] </td>"; 
                            echo '<td> <a href="?updToUser=' . $user['login'] .'" >Update to user</a> </td>';
                            
                        }
                        else {
                            echo "<table  style='background-color: rgba(48, 255, 103, 1);' > <tr><td > $user[login] </td><td> $user[status] </td>"; 
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
                    } else $access = "У вас недостаточно прав доступа !";
                } else $autorize = "Авторизуйтесь !";
                
                ?>
            </table>
            <?php if(isset($autorize) or isset($access))
            echo "<div class='error'>"
            ?>
            <?php
            if(isset($autorize))
                echo $autorize;
            if(isset($access))
                echo $access;
      
          ?>
            <?php if(isset($autorize) or isset($access))
            echo "</div>"?>
        </div>
    </div>
</body>
</html>