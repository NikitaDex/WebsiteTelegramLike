<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/messages.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/favicon.png" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <title>Messenger</title>
</head>
<body>
    <?php
    session_start();
    error_reporting(0); 
    if(empty($_SESSION['auth'])){
        echo "<style> .container {display:none;} </style>";
        echo "<h1>Авторизуйтесь!</h1>";
    } 
    ?>
    <div class="container">
        <div class="grid">
                <div class="main">
                    <div class="users-list">
                        <div class="flex-container">
                            <?php 
                                
                        
                                $host="localhost";
                                $login="root";
                                $password="";
                                $db_name="messenger";
                                $link=mysqli_connect($host,$login,$password,$db_name) or die("Connection failed");
                                mysqli_query($link, "SET NAMES 'utf8'");

                                $login = $_SESSION['login'];


                                $query = "SELECT login FROM users WHERE login != '$login' and login != 'root'";
                                $result = mysqli_query($link,$query);

                                $query_image = "SELECT login,image FROM images WHERE login != '$login' ";

                                $result_image = mysqli_query($link, $query_image);

                                // insert image
                                echo "<form action='' method='POST'>";
                                if(!isset($_POST['find'])){
                                while($row = mysqli_fetch_assoc($result) and $row_image = mysqli_fetch_assoc($result_image) ){
                                    if(in_array($row['login'], $row_image)){
                                        $display_image = './img/' . $row_image['image'];
                                    } else { $display_image =  './img/no.png'; }
                                    echo 
                                    "<div class='flex-item'>
                                        <button class='btn $row[login] img-cont' name='onClickBtn-$row[login]'>
                                            <image class=img src=$display_image alt=No>  
                                            <div class='show-user-login text-in-btn'>$row[login]</div>
                                        </button>
                                    </div>";
                                    if(isset($_POST["onClickBtn-$row[login]"])){
                                        // $_SESSION['choosen_image'] = $row_image['image'];
                                        $_SESSION['choosen_image'] = $display_image;
                                        $_SESSION['choosen'] = $row['login'];
                                        echo "<style>";
                                        echo " .$_SESSION[choosen] { background-color: rgba(64, 135, 230, 1); color: white;  }";
                                        echo "</style>";
                                    }
                                }
                                echo "</form>";
                                
                                echo "<style>";
                                echo " .$_SESSION[choosen] { background-color: rgba(64, 135, 230, 1); color: white;  }";
                                echo "</style>";
                            }
                            // else isset findBtn
                            else{
                                $findString = $_POST['findUser'];

                                $deleteTable = "DROP TABLE temp_table";
                                mysqli_query($link,$deleteTable);

                                $createTable = "CREATE TABLE temp_table AS SELECT users.login, users.first_name, 
                                users.last_name, users.mid_name, users.date, images.image 
                                FROM users JOIN images ON users.login = images.login";
                                mysqli_query($link,$createTable);
            
                                $queryFind = "SELECT login,image FROM temp_table WHERE (login='$findString' or 
                                first_name='$findString' or last_name='$findString' or date LIKE '%$findString%') and login != 'root' ";
                               
                                
                                $result = mysqli_query($link,$queryFind);

                                // CHANGE THIS
                                while($row = mysqli_fetch_assoc($result) ){
                                    // if(in_array($row['login'], $row_image)){
                                    if(true){
                                        $display_image = './img/' . $row['image'];
                                    } 
                                    else { continue; }
                                    echo 
                                    "<div class='flex-item'>
                                        <button class='btn $row[login] img-cont' name='onClickBtn-$row[login]'>
                                            <image class=img src=$display_image alt=No>  
                                            <div class='show-user-login text-in-btn'>$row[login]</div>
                                        </button>
                                    </div>";

                                    if(isset($_POST["onClickBtn-$row[login]"])){
                                        $_SESSION['choosen_image'] = $display_image; 
                                        $_SESSION['choosen'] = $row['login'];        
                                        echo "<style>";
                                        echo " .$_SESSION[choosen] { background-color: rgba(64, 135, 230, 1); color: white;  }";
                                        echo "</style>";
                                        
                                    }
                                
                                } //
                                echo "</form>";
                                
                                echo "<style>";
                                echo " .$_SESSION[choosen] { background-color: rgba(64, 135, 230, 1); color: white;  }";
                                echo "</style>";
                            }

                                


                            ?>
                        </div>
                    </div>
                    <div class="messenging">
                        <div class="write-container">
                            <form class="form" action="" method="POST">
                                <div class="container-text-area">
                                    <textarea required minlength='1' maxlength='200'  placeholder="Сообщение" class="text-area" name="text" id="" ></textarea>
                                </div>
                                <div class="send">
                                    <input accesskey="s" class="send-hide" type="submit" id="send" name="send">
                                    <label for="send"><span class="material-icons">send</span></label>
                                </div>
                            </form>
                            <div class="show-messages">
                            <?php 
                                if(!isset($_SESSION['choosen'])){
                                    echo "<div class='select-a-chat'>";
                                        echo "Выберите собеседника";
                                    echo "</div>";
                                }
                             ?>
                                <?php 
                                    $query5 = "INSERT INTO messages SET message='$_POST[text]', _from='$_SESSION[login]', _to='$_SESSION[choosen]' ";
                                    
                                    if(   !empty($_POST['text'])  ){
                                        mysqli_query($link,$query5);
                                        header('Location:messages.php');
                                    }

                                    $mes_show = "SELECT * FROM messages WHERE _to='$_SESSION[choosen]' or _from='$_SESSION[choosen]' ";
                                    $mes_result = mysqli_query($link,$mes_show);
                                    echo "<div class='flex-messages'>";
                                        while($mes_row = mysqli_fetch_assoc($mes_result)){
                                            if($mes_row['_from'] == $_SESSION['login']){
                                                echo "<div class='flex-messages__from'>";
                                                    echo $mes_row['message'];
                                                echo "</div>";
                                                echo "<br>";
                                            } 
                                            if($mes_row['_to'] == $_SESSION['login']){
                                                echo "<div class='flex-messages__to'>";
                                                    echo $mes_row['message'];
                                                echo "</div>";
                                                echo "<br>";
                                            }
                                            
                                        }
                                    echo "</div>";

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header">
                    <div class="with-who">
                        <div class="flex-container-top">
                            <?php 
                            
                            if(isset($_SESSION['choosen'])){
                                echo "<a id='with-who-id-href' href='PesonalArea_select_user.php'>";
                                echo "<div> <img class=img-top src=$_SESSION[choosen_image] alt='no' > </div>";   
                                echo "<div class='show-user-login top-name'> $_SESSION[choosen] </div>";
                                echo "</a>";
                            } 
                            ?>
                        </div> 
                    </div>
                    <div class="personal-area"> 
                        <div class="personal-area__link">
                            <a class="show-user-login" href="PesonalArea.php">
                                <span class="material-icons-outlined">account_circle</span>    
                                <!-- <span id="pers-ar">Личный кабинет</span> -->
                            </a>
                            <!-- here -->

                            <!-- <input accesskey="s" class="send-hide" type="submit" id="send" name="send">
                            <label for="send"><span class="material-icons">send</span></label> -->
                            <form class="formFind" action="" method="post">
                                <input class='findUser' type="text" name='findUser'>
                                <input type="submit"  value="" class='findBtn' name='find' id='find'>
                            </form>
                            <?php 
                            
                            // $findString = $_POST['findUser'];

                            // $queryFind = "SELECT * FROM users WHERE login='$findString' or 
                            // first_name='$findString' or last_name='$findString' or date='$findString' ";
                            // mysqli_query($link,$queryFind);

                            ?>
                            <!-- <label for="find"><img class='classFor' src="./img/icons/find.ico" alt=""></label> -->
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
</body>
</html>