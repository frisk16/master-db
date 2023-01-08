<?php
require_once('../../../app/config.php');
$css_link = '../../css/style.css';
if(isset($_SESSION['user'])) {
  if(isset($_GET['e'])) {
    if($_GET['e'] === 'pass') {
      $title = 'パスワード';
      $input_name = 'pass';
      $input_type = 'password';
    } elseif($_GET['e'] === 'email') {
      $title = 'Eメールアドレス';
      $input_name = 'email';
      $input_type = 'email';
    } else {
      header('Location:'.SITE_URL.'error/');
    }
  } else {
    header('Location:'.SITE_URL.'error/');
  }
} else {
  header('Location:'.SITE_URL.'login/');
}
$page_title = "{$title}変更";
include('../../_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title"><?= $page_title ?></h1>
    <a href="../" class="back-link">&laquo BACK</a>
    <section class="user-edit-section">
      <form action="?action=edit_user&e=<?= e($_GET['e']) ?>" method="post" name="user_edit_form" onsubmit="return editUser()">
        <div class="form-area">
          <p>現在の<?= e($title) ?>を入力してください。</p>
          <?php $current_input = "current_{$input_name}"; ?>
          <input type="<?= e($input_type) ?>" name="<?= e($current_input) ?>"
          value="<?= isset($_POST[$current_input]) ? e($_POST[$current_input]) : '' ?>">
        </div>
        <div class="form-area">
          <p>新しい<?= e($title) ?>を入力してください。</p>
          <?php $new_input = "new_{$input_name}"; ?>
          <input type="<?= e($input_type) ?>" name="<?= e($new_input) ?>"
          value="<?= isset($_POST[$new_input]) ? e($_POST[$new_input]) : '' ?>">
        </div>
        <div class="form-area">
          <p>確認のため、もう一度入力してください。</p>
          <?php $confirm_input = "confirm_{$input_name}"; ?>
          <input type="<?= e($input_type) ?>" name="<?= e($confirm_input) ?>">
        </div>
        <div class="form-area">
          <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
          <input type="submit" value="変更" class="btn">
        </div>
      </form>
    </section>
    <div class="error">
      <p><?= e($message) ?></p>
    </div>
  </div>
</main>

<?php
$js_link = '../../js/edit2.js';
include('../../_parts/_footer.php');