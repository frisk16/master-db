<?php
require_once('../../app/config.php');
if(!isset($_SESSION['user'])) {
  header('Location:'.SITE_URL.'login/');
}
if(isset($_GET['message'])) {
  $message = MSG_LIST[$_GET['message']];
}
$categories = Category::show_data(SET_PDO, 'payment');
$payments = Payment::show_data(SET_PDO);
$css_link = '../css/style.css';
$page_title = '支払い料金表';
include('../_parts/_header.php');

foreach($categories as $category) {
  if(isset($_GET['id'])) {
    if($_GET['id'] == $category['id']) {
      $category_title = $category['title'];
    }
  } else {
    $category_title = 'カテゴリーを選択してください。';
  }
}

if(isset($_GET['year']) && isset($_GET['month'])) {
  $year = $_GET['year'];
  $month = $_GET['month'];
} else {
  $year = date('Y');
  $month = date('m');
}
?>
<main>
  <div class="container">
    <h1 class="page-title">請求料金一覧</h1>
    <div class="message">
      <p><?= !empty($message) ? e($message) : '' ?></p>
    </div>
    <div class="area">
      <aside>
        <h2>カテゴリー別<img src="../img/add.png" alt="カテゴリー追加" id="add-category-btn"></h2>
        <p style="padding-left: 16px; font-weight: bold;">&raquo; <?= e($year) ?>年 <?= e($month) ?>月</p>
        <h3 class="total">
          合計：<span><?= e(Payment::total_price()) ?></span> 円
        </h3>
        <ul class="categories">
          <?php if(empty($categories)): ?>
            <li><a href="#">--カテゴリーがありません--</a></li>
            <?php else: ?>
            <?php foreach($categories as $category): ?>
              <li class="<?= $_GET['id'] == $category['id'] ? 'active' : '' ?>">
                <a href="?year=<?= e($year) ?>&month=<?= e($month) ?>&id=<?= e($category['id']) ?>">
                  &raquo; <?= e($category['title']) ?>
                </a>
              </li>
            <?php endforeach ?>
          <?php endif ?>
        </ul>
      </aside>
      <div>
        <section class="search-section">
          <h2>支払名検索（カテゴリー別）</h2>
          <form action="" method="get">
            <input type="text" name="keyword"
            value="<?= isset($_GET['keyword']) ? e($_GET['keyword']) : '' ?>"
            autocomplete="off">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <input type="submit" value="検索" class="btn">
            <div class="error">
              <p></p>
            </div>
          </form>
          <div class="about">
            <span>
              日付：
              <a href="?id=<?= e($_GET['id']) ?>&keyword=<?= e($_GET['keyword']) ?>&order=new">最近</a>
              <a href="?id=<?= e($_GET['id']) ?>&keyword=<?= e($_GET['keyword']) ?>&order=old">過去</a>
            </span>
          </div>
        </section>
        <section class="date-section">
          <span>
            <img src="../img/about.png" alt="カテゴリー詳細" id="about-btn">
            <img src="../img/add2.png" alt="カテゴリー追加" id="add-category-btn2">
            <h2>支払い履歴</h2>
            <img src="../img/edit2.png" alt="追加" id="add-payment-btn">
          </span>
          <form action="" method="get">
            日付：
            <label>
              <select name="year">
                <?php for($i = 2022; $i <= 2025; $i++): ?>
                  <?php
                    if(isset($_GET['year'])) {
                      $select = $_GET['year'] == $i ? 'selected' : '';
                    } else {
                      $select = date('Y') == $i ? 'selected' : '';
                    }
                  ?>
                  <option value="<?= $i ?>" <?= $select ?>>
                    <?= $i ?>
                  </option>
                  <?php endfor ?>
                </select>
                年
              </label>
            <label>
              <select name="month">
                <?php for($i = 1; $i <= 12; $i++): ?>
                  <?php
                    if(isset($_GET['month'])) {
                      $select = $_GET['month'] == $i ? 'selected' : '';
                    } else {
                      $select = date('m') == $i ? 'selected' : '';
                    }
                    ?>
                  <option value="<?= e($i) ?>" <?= $select ?>>
                    <?= e($i) ?>
                  </option>
                  <?php endfor ?>
              </select>
              月
            </label>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <input type="submit" value="表示" class="btn">
          </form>
          <div class="about">
            <span>
              支払額：
              <a href="?id=<?= e($_GET['id']) ?>&year=<?= e($year) ?>&month=<?= e($month) ?>&order=high">高い順</a>
              <a href="?id=<?= e($_GET['id']) ?>&year=<?= e($year) ?>&month=<?= e($month) ?>&order=cheap">安い順</a>
            </span>
            <span>
              日付：
              <a href="?id=<?= e($_GET['id']) ?>&year=<?= e($year) ?>&month=<?= e($month) ?>&order=new">最近</a>
              <a href="?id=<?= e($_GET['id']) ?>&year=<?= e($year) ?>&month=<?= e($month) ?>&order=old">過去</a>
            </span>
          </div>
          <?php
            $total = 0;
            foreach($payments as $payment) {
              $total += $payment['price'];
            }
          ?>
          <h3 class="total">
            <?= e($category_title) ?>合計：<span><?= e($total) ?></span> 円
          </h3>
        </section>
        <section class="lists-section">
          <ul class="categories">
            <?php if(!empty($payments)): ?>
              <?php foreach($payments as $payment): ?>
                <li class="lists-data">
                  <span id="lists-name"><?= e($payment['name']) ?></span>
                  <span id="lists-price"><?= e($payment['price']) ?>円</span>
                  <span id="lists-date">
                    <?php
                      $sub_year = substr($payment['updated_at'], 0, 4);
                      $week = date('w', mktime(0, 0, 0, $payment['month'], $payment['day'], $sub_year));
                    ?>
                    <?= e($payment['month']) ?>月
                    <?= e($payment['day']) ?>日
                    (<?= e(WEEK[$week]) ?>)
                  </span>
                  <a href="?action=delete_payment&id=<?= e($_GET['id']) ?>&payment_id=<?= e($payment['id']) ?>" onclick="return deletePayment()">
                    <img src="../img/delete.png" alt="リスト削除" id="delete-btn">
                  </a>
                </li>
              <?php endforeach ?>
            <?php else: ?>
              <li class="lists-data">-支払いデータがありません。-</li>
            <?php endif ?>
          </ul>
        </section>
      </div>
    </div>
  </div>

  <!-- Hidden Contents -->
  <div class="back"></div>
  <div class="add-category-form">
    <h2>カテゴリー新規追加</h2>
    <form action="?action=add_category" method="post" name="add_category_form" onsubmit="return addCategory();">
      <div class="form-area">
        <input type="text" name="title" placeholder="タイトルを入力" autocomplete="off">
        <input type="hidden" name="kind" value="payment">
      </div>
      <div class="form-area">
        <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
        <input type="submit" value="作成" class="btn">
      </div>
    </form>
    <div class="error"><p></p></div>
  </div>

  <div class="add-payment-form">
    <h2>支払いデータ追加</h2>
    <form action="?action=add_payment&id=<?= e($_GET['id']) ?>" method="post" name="add_payment_form" onsubmit="return addPayment()">
      <div class="form-area">
        <p>支払名</p>
        <?php $oldName = isset($_POST['name']) ? $_POST['name'] : ''; ?>
        <input type="text" name="name" placeholder="20文字以内" value="<?= e($oldName) ?>"
        autocomplete="off">
      </div>
      <div class="form-area">
        <p>支払額</p>
        <input type="number" name="price" placeholder="半角数字のみ">
      </div>
      <div class="form-area">
        <label>
          支払月：
          <select name="month">
            <?php for($i = 1; $i <= 12; $i++): ?>
              <option value="<?= e($i) ?>"
              <?= date('m') == $i ? 'selected' : '' ?>>
                <?= e($i) ?>
              </option>
            <?php endfor ?>
          </select>
        </label>
        <label>
          支払日：
          <select name="day">
            <?php for($i = 1; $i <= 31; $i++): ?>
              <option value="<?= e($i) ?>"
              <?= date('d') == $i ? 'selected' : '' ?>>
                <?= e($i) ?>
              </option>
            <?php endfor ?>
          </select>
        </label>
      </div>
      <div class="form-area">
        <input type="hidden" name="token" value="<?= e($_SESSION['token']) ?>">
        <input type="submit" value="追加" class="btn">
      </div>
    </form>
    <div class="error"><p></p></div>
  </div>
</main>

<?php
$js_link = '../js/payment.js';
include('../_parts/_footer.php');
