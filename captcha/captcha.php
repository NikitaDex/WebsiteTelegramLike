<?php
  session_start();
  $letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZ';
  $caplen = 6;
  $captcha = '';

  for ($i = 0; $i < $caplen; $i++)
  {
    $captcha .= $letters[ rand(0, strlen($letters)-1) ]; 
  }

  $result = '';
  for ($i=0; $i < $caplen; $i++) { 
    $rotate = rand(-75, 75);
    $result .= '
    <div class="photo_cap_item photo_captcha-'.$i.'" style="transform: rotate('.$rotate.'deg); margin-left: 5px; margin-right: 5px;">
      '.$captcha[$i].'
    </div>
    ';
  }
  $_SESSION['captcha_confirm'] = $captcha;
  $_SESSION['result_captcha'] = $result;

  header('Location: /php_usue/registration/index_auth.php');
?>