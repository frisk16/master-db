<?php

class Database
{
  public static function set_pdo()
  {
    try {
      $pdo = new PDO(
        'mysql:dbname=master_db;host=localhost;charset=utf8mb4',
        'frisk',
        'Nto1160!',
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
        ]
      );

      return $pdo;
      
    } catch (PDOException $e) {
      exit ('接続失敗：'.$e->getMessage());
    }
  }
}