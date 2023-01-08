<?php
require_once('../../app/config.php');
$css_link = '../css/style.css';
$page_title = 'ページが見つかりません';
include('../_parts/_header.php');
?>

<main>
  <div class="container">
    <h1 class="page-title">お探しのページは見つかりませんでした。</h1>
    <p>URLが間違っているか、ページのトークンが無効です。</p>
  </div>
</main>

<?php
$js_link = '';
include('../_parts/_footer.php');