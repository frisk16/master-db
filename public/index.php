<?php
require_once('../app/config.php');
if(!isset($_SESSION['user'])) {
  header('Location:'.SITE_URL.'login/');
} else {
  header('Location:'.SITE_URL.'payment/');
}
$css_link = 'css/style.css';
$page_title = 'ホーム';
include('_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title">準備中</h1>
    <a href="payment/" class="btn">支払い履歴閲覧ページへ</a>
  </div>
</main>

<?php
$js_link = '';
include('_parts/_footer.php');