const currentEmail = document.forms.user_edit_form.current_email;
const newEmail = document.forms.user_edit_form.new_email;
const confirmEmail = document.forms.user_edit_form.confirm_email;
const currentPass = document.forms.user_edit_form.current_pass;
const newPass = document.forms.user_edit_form.new_pass;
const confirmPass = document.forms.user_edit_form.confirm_pass;
const errMesg = document.querySelector('.error > p');
var params = (new URL(document.location)).searchParams;

const editUser = () => {
  if(params.get('e') === 'email') {
    if(currentEmail.value === '') {
      errMesg.textContent = '現在のEメールアドレスを入力してください。';
      return false;
    } else if(newEmail.value === '') {
      errMesg.textContent = '新しいEメールアドレスを入力してください。';
      return false;
    } else if(newEmail.value !== confirmEmail.value) {
      errMesg.textContent = '確認用Eメールアドレスが一致しません。';
      return false;
    } else {
      return true;
    }
  }
  if(params.get('e') === 'pass') {
    if(currentPass.value === '') {
      errMesg.textContent = '現在のパスワードを入力してください。';
      return false;
    } else if(newPass.value === '') {
      errMesg.textContent = '新しいパスワードを入力してください。';
      return false;
    } else if(newPass.value !== confirmPass.value) {
      errMesg.textContent = '確認用パスワードが一致しません。';
      return false;
    } else {
      return true;
    }
  }
};