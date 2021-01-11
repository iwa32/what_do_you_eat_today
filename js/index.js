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

  $('#name').on('change', function () {
    isValidValues.name = validName($(this));
    unLockSubmitBtn(isValidValues);
  });

  $('#email').on('change', function () {
    isValidValues.email = validEmail($(this));
    unLockSubmitBtn(isValidValues);
  });

  $('#password').on('change', function () {
    isValidValues.password = validPassword($(this));
    unLockSubmitBtn(isValidValues);
  });

  $('#signUpForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  })

  $('#loginForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  })

})