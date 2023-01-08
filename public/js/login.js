
// ログインフォームのエラーチェック機能
const errMesg1 = document.querySelector('#login_error > p');
const userName = document.forms.login_form.user_name;
const userPass = document.forms.login_form.user_pass;

const loginAction = () => {
  if(userName.value === '') {
    errMesg1.textContent = 'ユーザー名を入力してください。';
    return false;
  } else if(userPass.value === '') {
    errMesg1.textContent = 'パスワードを入力してください。';
    return false;
  } else {
    return true;
  }
};
