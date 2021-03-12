$(function () {

  //loading表示のため最初はコンテンツを非表示にする
  $('.contents').hide();
  showLoader();

  var $footer = $('#globalFooter');
  //footerを下に固定する
  if (window.innerHeight > $footer.offset().top + $footer.outerHeight()) {
    $footer.attr({
      'style': 'position:fixed; top:' + (window.innerHeight - $footer.outerHeight()) + 'px;'
    });
  }

  //アラートメッセージを表示する
  var $alertMsg = $('#alertGlobalMessage');
  var $alertMsgTxt = $alertMsg.text();
  if($alertMsgTxt != '' && $alertMsgTxt !== ' ') {
    //0.2秒後に表示し、2秒後フェードアウトする
    fadeAlertMessage($alertMsg);
  }

  //ランチかディナーか選択
  var firstSelect = "";
  $('#firstSelect .eat-select__list').on('click', function () {
    selectNextGenre($('#firstSelect'), $('#secondSelect'));
    firstSelect = this.innerText;
  });

  //選択後、飲食店の検索を開始の準備をする
  var secondSelect = "";
  $('#secondSelect .eat-select__list').on('click', function () {

    secondSelect = this.innerText;
    getReadyToStartYourSearch(firstSelect, secondSelect);
  });

  //検索した飲食店をクリックした時
  //ajaxで追加したhtmlはonメソッドの第二引数に指定することでイベントが発火されるようになる。
  $('#foodSearchResultLists').on('click', '.food-search-result__list', function () {
    var lat = $(this).data('lat');
    var lng = $(this).data('lng');
    moveToFoodMap(lat, lng);
  });

  //検索した飲食点のお気に入りアイコンをクリックした時
  $('#foodSearchResultLists').on('click', '.food-search-result__list__favorite', function (event) {
    var place_id = $(this).parent().data('place-id');
    postFoodFavorite(place_id, $(this));
    //親へのイベントの伝播を停止
    event.stopPropagation();
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
  });

  //パスワード
  $('#password').on('change', function () {
    isValidValues.password = validPassword($(this));
    unLockSubmitBtn(isValidValues);
  });

  //認証に使用するフォームのバリデーション無効時のEnter送信防止
  $('#authForm').on('submit', function (event) {
    checkFormSending(event, isValidValues);
  });

  //ユーザーのメッセージ
  $('#myMessage').on('input', function () {
    validMessage($(this));
  });

  //プロフィール用の画像ファイルの読み込み
  $('#myIcon').on('change', function(event) {
    var $myIconImg = $('#myIconImg');
    readingImageFile($myIconImg, event);
  });

  $('#imageArea').on('dragover', function(event) {
    $(this).addClass('dragover');

    event.stopPropagation();
    event.preventDefault();
  });

  $('#imageArea').on('dragleave', function(event) {
    $(this).removeClass('dragover');

    event.stopPropagation();
    event.preventDefault();
  });
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