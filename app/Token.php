<?php

class Token
{
  public static function create()
  {
    if(!isset($_SESSION['token']) || $_SESSION['token'] === '') {
      $_SESSION['token'] = bin2hex(random_bytes(32));
    }
  }

  public static function validate()
  {
    if($_SESSION['token'] !== $_POST['token'] || !isset($_POST['token'])) {
      exit(header('Location:'.SITE_URL.'error/'));
    }
  }
}