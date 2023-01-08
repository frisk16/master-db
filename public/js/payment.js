const errMesg2 = document.querySelector('.add-category-form .error > p');
const title = document.forms.add_category_form.title;
const backFilter = document.querySelector('.back');
const addCategoryForm = document.querySelector('.add-category-form');
const addCategoryButton = document.getElementById('add-category-btn');
const addCategoryButton2 = document.getElementById('add-category-btn2');
const errMesg3 = document.querySelector('.add-payment-form > .error > p');
const paymentName = document.forms.add_payment_form.name;
const price = document.forms.add_payment_form.price;
const aboutButton = document.getElementById('about-btn');
const aside = document.querySelector('aside');
const addPaymentButton = document.getElementById('add-payment-btn');
const addPaymentForm = document.querySelector('.add-payment-form');
const params = (new URL(location.href)).searchParams;

// カテゴリー追加フォームのエラーチェック機能
const addCategory = () => {
  if(title.value === '') {
    errMesg2.textContent = '※タイトルを入力してください。';
    return false;
  } else if(title.value.length > 10) {
    errMesg2.textContent = '※10文字以内で入力してください。';
    return false;
  } else {
    return true;
  }
};


// カテゴリー追加フォーム表示
addCategoryButton.addEventListener('click', () => {
  backFilter.style.display = 'block';
  addCategoryForm.style.display = 'block';
});
// （スマホ版）
addCategoryButton2.addEventListener('click', () => {
  backFilter.style.display = 'block';
  addCategoryForm.style.display = 'block';
});


// 支払いデータ追加フォームのエラーチェック機能
const addPayment = () => {
  if(!params.has('id')) {
    errMesg3.textContent = '※カテゴリーが選択されていません。';
    return false;
  } else {
    if(paymentName.value === '') {
      errMesg3.textContent = '※支払名を入力してください。';
      return false;
    } else if(paymentName.value.length > 20) {
      errMesg3.textContent = '※支払名は20文字以内で入力してください。';
      return false;
    } else if(price.value === '') {
      errMesg3.textContent = '※支払額を入力してください。';
      return false;
    } else {
      return true;
    }
  }
};


// 支払いデータ削除の確認メッセージ表示
const deletePayment = () => {
  if(!confirm('選択した支払いデータを削除しますか？')) {
    return false;
  } else {
    return true;
  }
};

addPaymentButton.addEventListener('click', () => {
  backFilter.style.display = 'block';
  addPaymentForm.style.display = 'block';
});


// （スマホ版）カテゴリーリスト表示
aboutButton.addEventListener('click', () => {
  aside.style.left = '0';
  backFilter.style.display = 'block';
});


// カテゴリーリスト、追加フォーム非表示
backFilter.addEventListener('click', e => {
  e.target.style.display = 'none';
  addCategoryForm.style.display = 'none';
  addPaymentForm.style.display = 'none';
  aside.style.left = '-300px';
});