<?php
require_once('../../../app/config.php');
if(!isset($_SESSION['user'])) {
  header('Location:'.SITE_URL.'login/');
}
if(isset($_GET['message'])) {
  $accept_msg = MSG_LIST[$_GET['message']];
}
$css_link = '../../css/style.css';
$page_title = 'ユーザー情報変更';
include('../../_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title">ユーザー登録情報変更</h1>
    <a href="../" class="back-link">&laquo BACK</a>
    <section class="user-edit-section">
      <form action="?action=edit_user&e=name" method="post" name="user_name_edit_form" onsubmit="return editUserName()">
        <div class="form-area">
          <p>ユーザー名（5文字以上15文字以内）</p>
          <input type="text" name="name" value="<?= e($_SESSION['user']['name']) ?>"
          placeholder="半角英数字のみ">
          <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
          <input type="submit" value="変更" class="btn">
        </div>
      </form>
      <form action="?action=edit_user&e=phone" method="post" name="user_phone_edit_form" onsubmit="return editUserPhone()">
        <div class="form-area">
          <p>電話番号（半角数字ハイフン有り）</p>
          <input type="text" name="phone" value="<?= e($_SESSION['user']['phone']) ?>"
          placeholder="例）〇〇-〇〇〇〇-〇〇〇〇">
          <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
          <input type="submit" value="変更" class="btn">
        </div>
      </form>
    </section>
    <div class="error">
      <p><?= e($message) ?></p>
    </div>
    <div class="message">
      <p><?= e($accept_msg) ?></p>
    </div>
  </div>
</main>

<?php
$js_link = '../../js/edit1.js';
include('../../_parts/_footer.php');