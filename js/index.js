$(function () {

  //loading表示のため最初はコンテンツを非表示にする
  $('.contents').hide();
  showLoader();

  var $footer = $('#globalFooter');
  /**footerを下に固定する */
  if (window.innerHeight > $footer.offset().top + $footer.outerHeight()) {
    $footer.attr({
      'style': 'position:fixed; top:' + (window.innerHeight - $footer.outerHeight()) + 'px;'
    });
  }

  var firstSelect = "";
  $('#firstSelect .eat-select__list').on('click', function () {
    selectNextGenre($('#firstSelect'), $('#secondSelect'));
    firstSelect = this.innerText;
  });

  //選択後、飲食店を検索する
  var secondSelect = "";
  $('#secondSelect .eat-select__list').on('click', function () {

    secondSelect = this.innerText;
    startSearchFoods(firstSelect, secondSelect);
  });

  //検索した飲食店をクリックした時
  //ajaxで追加したhtmlはonメソッドの第二引数に指定することでイベントが発火されるようになる。
  $('#mealSearchResultLists').on('click', '.meal-search-result__list', function () {
    var lat = $(this).data('lat');
    var lng = $(this).data('lng');
    moveToMealMap(lat, lng);
  });

  //検索した飲食点のお気に入りアイコンをクリックした時
  $('#mealSearchResultLists').on('click', '.meal-search-result__list__favorite', function () {
    var place_id = $(this).parent().data('place-id');
    postMealFavorite(place_id, $(this));
  });

  //プロフィール編集ページへ
  $('#toEditProfileBtn').on('click', function () {
    window.location.href = './edit_my_page.php';
  });

  //パスワード編集ページへ
  $('#toEditPassBtn').on('click', function() {
    window.location.href = './edit_pass.php';
  });

  //フォーム入力フラグ
  var isValidValues = {
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

  //Eメール(パスワード再発行)
  $('#remindEmail').on('change', function() {
    isValidValues.email = validEmail($(this));
    //再発行時はパスワードのバリデーションはしない
    isValidValues.password = true;
    unLockSubmitBtn(isValidValues);
  })

  //パスワード
  $('#password').on('change', function () {
    isValidValues.password = validPassword($(this));
    unLockSubmitBtn(isValidValues);
  });

  //認証に使用するフォームのバリデーション無効時のEnter送信防止
  $('#authForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  })

  //ユーザーのメッセージ
  $('#myMessage').on('input', function () {
    validMessage($(this));
  })
});

$(window).on('load', function () {
  //全ての読み込みが完了したら
  fadeOutLoader();
  $('.contents').show();
});

//20秒経ったら強制的にロード画面を非表示
$(function () {
  setTimeout('fadeOutLoader()', 20000);
})