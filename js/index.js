$(function () {

  var $footer = $('#globalFooter');

  /**footerを下に固定する */
  if (window.innerHeight > $footer.offset().top + $footer.outerHeight()) {
    $footer.attr({
      'style': 'position:fixed; top:' + (window.innerHeight - $footer.outerHeight()) + 'px;'
    });
  }

  $('#firstSelect .eat-select__list').on('click', function () {
    selectNextGenre($('#firstSelect'), $('#secondSelect'));
  });

  $('#secondSelect .eat-select__list').on('click', function () {
    selectNextGenre($('#secondSelect'), $('#mealSearchResult'));
  });

  $('#toEditProfileBtn').on('click', function () {
    window.location.href = './edit_my_page.php';
  });

  let isValidValues = {
    name: true,
    email: false,
    password: false
  };

  //お名前
  $('#name').on('change', function () {
    isValidValues.name = validName($(this));
    unLockSubmitBtn(isValidValues);
  });

  //Eメール
  $('#email').on('change', function () {
    isValidValues.email = validEmail($(this));
    unLockSubmitBtn(isValidValues);
  });

  //パスワード
  $('#password').on('change', function () {
    isValidValues.password = validPassword($(this));
    unLockSubmitBtn(isValidValues);
  });

  //会員登録
  $('#signUpForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  })

  //ログイン
  $('#loginForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  })

  //ユーザーのメッセージ
  $('#myMessage').on('input', function() {
    validMessage($(this));
  })
})