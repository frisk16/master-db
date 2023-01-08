<?php

session_start();

function e($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

spl_autoload_register(function($class) {
  require_once("{$class}.php");
});

Token::create();

define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/public/payment/');
define('SET_PDO', Database::set_pdo());
define('MSG_LIST', [
  1 => '※カテゴリーを追加しました。',
  2 => '※支払いデータを追加しました。',
  3 => '※Eメールアドレスを変更しました。',
  4 => '※パスワードを変更しました。',
  5 => '※ユーザー名を変更しました。',
  6 => '※電話番号を変更しました。',
]);
define('WEEK', [
  0 => '日',
  1 => '月',
  2 => '火',
  3 => '水',
  4 => '木',
  5 => '金',
  6 => '土',
]);

$message = '';
if(isset($_GET['action'])) {
  $message = Select::check_action();
}