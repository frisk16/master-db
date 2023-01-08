<?php

class Select
{
  public static function check_action()
  {
    $message = '';
    switch($_GET['action']) {
      case 'login':
        Token::validate();
        $message = User::login(SET_PDO);
        return $message;
        break;

      case 'logout':
        User::logout();
        break;

      case 'add_category':
        Token::validate();
        Category::add_data(SET_PDO);
        break;

      case 'add_payment':
        Token::validate();
        Payment::add_data(SET_PDO);
        break;

      case 'delete_payment':
        Payment::delete_data(SET_PDO);
        break;

      case 'edit_user':
        Token::validate();
        $message = User::edit_data(SET_PDO);
        return $message;
        break;
      
      default:
        header('Location:'.SITE_URL.'error/');
    }
  }
}
