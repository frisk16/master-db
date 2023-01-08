<?php

class Category
{
  // カテゴリー表示
  public static function show_data($pdo, $kind)
  {
    $stmt = $pdo->prepare(
      'SELECT * FROM categories WHERE user_id = :user_id AND kind = :kind'
    );
    $stmt->bindValue('user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
    $stmt->bindValue('kind', $kind, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
  }

  // カテゴリー追加
  public static function add_data($pdo)
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $stmt = $pdo->prepare(
        'INSERT INTO categories(user_id, kind, title)
        VALUES(:user_id, :kind, :title)'
      );
      $stmt->bindValue('user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
      $stmt->bindValue('kind', $_POST['kind'], PDO::PARAM_STR);
      $stmt->bindValue('title', $_POST['title'], PDO::PARAM_STR);
      $stmt->execute();

      header('Location:'.SITE_URL.'payment/?message=1');
    }
  }
}