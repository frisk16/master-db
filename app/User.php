<?php

class User
{
  public static function login($pdo)
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $message = '※ユーザー名、又はパスワードが間違っています。';

      // ユーザー名からデータが存在するか確認
      $stmt = $pdo->prepare(
        'SELECT * FROM users WHERE name = :user_name'
      );
      $stmt->bindValue('user_name', $_POST['user_name'], PDO::PARAM_STR);
      $stmt->execute();
      $user_data = $stmt->fetch();

      // データが存在し、かつパスワードが一致すればセッション付与
      if(!empty($user_data)) {
        if(password_verify($_POST['user_pass'], $user_data['pass'])) {
          $pass_length = strlen($_POST['user_pass']);
          $_SESSION['user'] = [
            'id' => $user_data['id'],
            'name' => $user_data['name'],
            'pass_length' => $pass_length,
            'email' => $user_data['email'],
            'phone' => $user_data['phone'],
          ];
  
          header('Location:'.SITE_URL.'payment/?id=1');
  
        } else {
          return $message;
        }
      } else {
        return $message;
      }
    }
  }

  public static function logout()
  {
    unset($_SESSION['user']);

    header('Location:'.SITE_URL.'login/');
  }
  
  public static function edit_data($pdo)
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      if(isset($_GET['e'])) {

        // ユーザーデータを取得
        $stmt = $pdo->prepare(
          'SELECT * FROM users WHERE id = :id'
        );
        $stmt->bindValue('id', $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();
        $user_data = $stmt->fetch();

        // Eメールアドレス変更
        if($_GET['e'] === 'email') {
          if($_POST['current_email'] === $user_data['email']) {
            if(self::validate_data() === FALSE) {
              $stmt = $pdo->prepare(
                'UPDATE users SET email = :email WHERE id = :id'
              );
              $stmt->bindValue('email', $_POST['new_email'], PDO::PARAM_STR);
              $stmt->bindValue('id', $_SESSION['user']['id'], PDO::PARAM_INT);
              $stmt->execute();
              $_SESSION['user']['email'] = $_POST['new_email'];

              header('Location:'.SITE_URL.'user/?message=3');
            } else {
              $message = 'そのEメールアドレスは既に使用されています。';
              return $message;
            }
          } else {
            $message = '現在のEメールアドレスが一致しません。';
            return $message;
          }
        }
        
        // パスワード変更
        if($_GET['e'] === 'pass') {
          if(password_verify($_POST['current_pass'], $user_data['pass'])) {
            $hash_pass = password_hash($_POST['new_pass'], PASSWORD_BCRYPT);
            $stmt = $pdo->prepare(
              'UPDATE users SET pass = :pass WHERE id = :id'
            );
            $stmt->bindValue('pass', $hash_pass, PDO::PARAM_STR);
            $stmt->bindValue('id', $_SESSION['user']['id'], PDO::PARAM_INT);
            $stmt->execute();
            $pass_length = strlen($_POST['new_pass']);
            $_SESSION['user']['pass_length'] = $pass_length;

            header('Location:'.SITE_URL.'user/?message=4');
          } else {
            $message = '現在のパスワードが一致しません。';
            return $message;
          }
        }

        // ユーザー名、電話番号変更
        if($_GET['e'] === 'name' || $_GET['e'] === 'phone') {
          if($_GET['e'] === 'name') {
            if(self::validate_data() === FALSE) {
              $get_msg = 5;
              $kind = 'name';
              $data = $_POST['name'];
            } else {
              $message = 'そのユーザー名は既に使用されています。';
              return $message;
            }
          }
          if($_GET['e'] === 'phone') {
            if(self::validate_data() === FALSE) {
              $get_msg = 6;
              $kind = 'phone';
              $data = $_POST['phone'];
            } else {
              $message = 'その電話番号は既に使用されています。';
              return $message;
            }
          }

          $sql = "UPDATE users SET {$kind} = :{$kind} WHERE id = :id";
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue($kind, $data, PDO::PARAM_STR);
          $stmt->bindValue('id', $_SESSION['user']['id'], PDO::PARAM_INT);
          $stmt->execute();
          $_SESSION['user'][$kind] = $data;

          header('Location:'.SITE_URL.'user/edit1/?message='.$get_msg);
        }
      }
    }
  }

  private static function validate_data()
  {
    // 同じEメールアドレス、ユーザー名、電話番号が既に存在しているかチェック
    if($_GET['e'] === 'email') {
      $data = $_POST['new_email'];
      $kind = 'email';
    }
    if($_GET['e'] === 'name') {
      $data = $_POST['name'];
      $kind = 'name';
    }
    if($_GET['e'] === 'phone') {
      $data = $_POST['phone'];
      $kind = 'phone';
    }
    $sql = "SELECT * FROM users WHERE {$kind} = :{$kind}";
    $stmt = SET_PDO->prepare($sql);
    $stmt->bindValue($kind, $data, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch();
  }
}
