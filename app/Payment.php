<?php

class Payment
{
  // 支払いデータ表示
  public static function show_data($pdo)
  {
    // 支払い額、日付の並び替え（指定がなければ最近の日付から）
    if(isset($_GET['order'])) {
      if($_GET['order'] === 'high') {
        $order = 'ORDER BY price DESC';
      } elseif($_GET['order'] === 'cheap') {
        $order = 'ORDER BY price';
      } elseif($_GET['order'] === 'new') {
        $order = 'ORDER BY updated_at DESC';
      } elseif($_GET['order'] === 'old') {
        $order = 'ORDER BY updated_at';
      } else {
        $order = 'ORDER BY updated_at DESC';
      }
    } else {
      $order = 'ORDER BY day DESC';
    }

    if(isset($_GET['keyword'])) {
      // カテゴリー毎の全期間検索
      $keyword = $_GET['keyword'];
      $sql = "SELECT * FROM payments WHERE category_id = :category_id
      AND name LIKE :keyword {$order}";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('keyword', "%{$keyword}%", PDO::PARAM_STR);
    } else {
      // カテゴリー毎の日付検索
      if(isset($_GET['year']) && isset($_GET['month'])) {
        // 日付の指定が無ければ現在の年と月を取得
        $year = $_GET['year'];
        $month = $_GET['month'];
      } else {
        $year = date('Y');
        $month = date('m');
      }
      $sql = "SELECT * FROM payments WHERE category_id = :category_id
        AND updated_at LIKE :year
        AND month = :month {$order}";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue('year', "{$year}%", PDO::PARAM_STR);
      $stmt->bindValue('month', $month, PDO::PARAM_INT);
    }

    $stmt->bindValue('category_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
  }


  // 支払いデータ追加
  public static function add_data($pdo)
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $stmt = $pdo->prepare(
        'INSERT INTO payments(category_id, name, price, month, day)
        VALUES(:category_id, :name, :price, :month, :day)'
      );
      $stmt->bindValue('category_id', $_GET['id'], PDO::PARAM_INT);
      $stmt->bindValue('name', $_POST['name'], PDO::PARAM_STR);
      $stmt->bindValue('price', $_POST['price'], PDO::PARAM_INT);
      $stmt->bindValue('month', $_POST['month'], PDO::PARAM_INT);
      $stmt->bindValue('day', $_POST['day'], PDO::PARAM_INT);
      $stmt->execute();
      
      header('Location:'.SITE_URL.'payment/?id='.$_GET['id'].'&message=2');
    }
  }

  // 支払いデータ削除
  public static function delete_data($pdo)
  {
    if(isset($_GET['payment_id'])) {
      $stmt = $pdo->prepare(
        'DELETE FROM payments WHERE id = :payment_id'
      );
      $stmt->bindValue('payment_id', $_GET['payment_id'], PDO::PARAM_INT);
      $stmt->execute();
      
      header('Location:'.SITE_URL.'payment/?id='.$_GET['id']);
    }
  }

  // 今月分の支払額合計（全カテゴリー）
  public static function total_price()
  {
    $total = 0;
    if(isset($_GET['year']) && isset($_GET['month'])) {
      $year = $_GET['year'];
      $month = $_GET['month'];
    } else {
      $year = date('Y');
      $month = date('m');
    }
    $stmt = SET_PDO->prepare(
      'SELECT * FROM payments
      WHERE month = :month AND updated_at LIKE :year'
    );
    $stmt->bindValue('month', $month, PDO::PARAM_INT);
    $stmt->bindValue('year', "{$year}%");
    $stmt->execute();
    $payments = $stmt->fetchAll();

    foreach($payments as $payment) {
      $total += $payment['price'];
    }

    return $total;
  }
}