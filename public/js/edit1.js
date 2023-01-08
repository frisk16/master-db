const userName = document.forms.user_name_edit_form.name;
const phone = document.forms.user_phone_edit_form.phone;
const errMesg = document.querySelector('.error > p');
let regexUserName = new RegExp(/^[a-zA-Z0-9]*$/);
let regexUserPhone1 = new RegExp(/^[0-9\-]*$/);
let regexUserPhone2 = new RegExp(/^\d{2,4}-\d{3,4}-\d{3,4}$/);

const editUserName = () => {
  if(userName.value === '') {
    errMesg.textContent = 'ユーザー名を入力してください。';
    return false;
  } else if (userName.value.length < 5) {
    errMesg.textContent = '5文字以上で入力してください。';
    return false;
  } else if(userName.value.length > 15) {
    errMesg.textContent = '15文字以内で入力してください。';
    return false;
  } else if(!regexUserName.test(userName.value)) {
    errMesg.textContent = '半角英数字で入力してください。';
    return false;
  } else {
    return true;
  }
};

const editUserPhone = () => {
  if(phone.value === '') {
    errMesg.textContent = '電話番号を入力してください。';
    return false;
  } else if(!regexUserPhone1.test(phone.value)) {
    errMesg.textContent = '半角数字（ハイフン有り）で入力してください。';
    return false;
  } else if(!regexUserPhone2.test(phone.value)) {
    errMesg.textContent = '入力した電話番号に誤りがあります。';
    return false;
  } else {
    return true;
  }
};