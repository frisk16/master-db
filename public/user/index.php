<?php
require_once('../../app/config.php');
if(!isset($_SESSION['user'])) {
  header('Location:'.SITE_URL.'login/');
}
if(isset($_GET['message'])) {
  $message = MSG_LIST[$_GET['message']];
}
$css_link = '../css/style.css';
$page_title = 'ユーザー管理画面';
include('../_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title">ユーザー管理</h1>
    <a href="../payment/?id=1" class="back-link">&laquo BACK</a>
    <section class="user-section">
      <div class="message">
        <p><?= e($message) ?></p>
      </div>
      <div class="about-area">
        <div>
          <?php
            $dummy_phone = substr($_SESSION['user']['phone'], 0, 5).'●●●...';
            ?>
          <p>ユーザーID：<span><?= e($_SESSION['user']['id']) ?></span></p>
          <p>ユーザー名：<span><?= e($_SESSION['user']['name']) ?></span></p>
          <p>電話番号：<span><?= $dummy_phone ?></span></p>
        </div>
        <div>
          <a href="edit1/"><img src="../img/edit.png" alt="編集" id="user-edit-btn"></a>
        </div>
      </div>
      <div class="about-area">
        <div>
          <?php
            $dummy_email = substr($_SESSION['user']['email'], 0, 5).'●●●...';
          ?>
          <p>Eメールアドレス：<span><?= e($dummy_email) ?></span></p>
        </div>
        <div>
          <a href="edit2/?e=email"><img src="../img/edit.png" alt="編集" id="user-edit-btn"></a>
        </div>
      </div>
      <div class="about-area">
        <div>
          <p>パスワード：<span><?= e($_SESSION['user']['pass_length']) ?>ケタ</span></p>
        </div>
        <div>
          <a href="edit2/?e=pass"><img src="../img/edit.png" alt="編集" id="user-edit-btn"></a>
        </div>
      </div>
    </section>
  </div>
</main>

<?php
$js_link = '';
include('../_parts/_footer.php');