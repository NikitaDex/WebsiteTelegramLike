<?php
    session_start();
    $captcha = $_POST['captcha'];
    if(!empty($_POST['reload'])){
        header('Location: /php_usue/registration/captcha/captcha.php');
    }
    else{
        if($_POST['captcha'] != $_SESSION['captcha_confirm']) $_SESSION['captcha_conf'] = 'Код введен неверно!';
        else $_SESSION['captcha_conf'] = 'Код введен верно!';
        header('Location: /php_usue/registration/index_auth.php');
    }
?>