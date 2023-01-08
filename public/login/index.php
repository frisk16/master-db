<?php
require_once('../../app/config.php');
if(isset($_SESSION['user'])) {
  header('Location:'.SITE_URL.'payment/?id=1');
}
$css_link = '../css/style.css';
$page_title = 'ログイン';
include('../_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title">ログイン</h1>
    <div class="login-form">
      <form action="?action=login" method="post" name="login_form" onsubmit="return loginAction()">
        <div class="form-area">
          <p>ユーザー名</p>
          <input type="text" name="user_name"
          value="<?= isset($_POST['user_name']) ? e($_POST['user_name']) : '' ?>">
        </div>
        <div class="form-area">
          <p>パスワード</p>
          <input type="password" name="user_pass">
        </div>
        <div class="form-area">
          <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
          <input type="submit" value="ログイン" class="btn">
        </div>
      </form>
      <div class="error" id="login_error">
        <p><?= e($message) ?></p>
      </div>
    </div>
  </div>
</main>

<?php
$js_link = '../js/login.js';
include('../_parts/_footer.php');