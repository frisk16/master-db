<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $css_link ?>">
  <title><?= $page_title ?></title>
</head>
<body>
  <script>
    const logoutAction = () => {
      if(!confirm('ログアウトしますか？')) {
        return false;
      } else {
        return true;
      }
    };
  </script>
  <header>
    <div class="container">
      <h1><a href="<?= SITE_URL.'payment/?id=1' ?>">DATA BANK</a></h1>
      <nav>
        <?php if(isset($_SESSION['user'])): ?>
          <a href="<?= SITE_URL.'user/' ?>">ユーザー管理</a>
          <a href="?action=logout" onclick="return logoutAction()">ログアウト</a>
        <?php else: ?>
     
        <?php endif ?>
      </nav>
    </div>
  </header>