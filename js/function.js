/**
 * loading画面の表示
 */
function showLoader() {
  $('#loadingBg, #loader').show();
}

/**
 * loading画面の非表示
 */
function fadeOutLoader() {
  $('#loadingBg').delay(600).fadeOut(700);
  $('#loader').delay(400).fadeOut(200);
}

/**
 * 次の選択項目を表示する
 * @param {*} $prev 
 * @param {*} $next 
 */
function selectNextGenre($prev, $next) {
  $prev.hide(600);
  $next.show(600);
}


/**
 * お名前チェック
 * @param {*} $node
 */
function validName($node) {
  let successes = [];

  successes.push(validMaxLen($node, 256));
  return isAllSuccess(successes, $node);
}

/**
 * Eメールチェック
 * @param {*} $node
 */
function validEmail($node) {
  if (validRequired($node)) {
    let successes = [];
    successes.push(validMaxLen($node, 256));
    successes.push(validTypeEmail($node));
    return isAllSuccess(successes, $node);
  }
  return false;
}

/**
 * パスワードチェック
 * @param {*} $node
 */
function validPassword($node) {

  if (validRequired($node)) {
    let successes = [];
    successes.push(validMinLen($node, 5));
    successes.push(validMaxLen($node, 256));
    successes.push(validHalf($node));

    return isAllSuccess(successes, $node);
  }
  return false;
}

/**
 * メッセージチェック
 * @param {*} $node
 */
function validMessage($node) {
  validMaxLen($node, 1000);
  messageCount($node);
}

/**
 * メッセージのカウントをする
 * @param {*} $node 
 */
function messageCount($node) {
  let value = $node.val();
  let $targetNode = $node.siblings('.form-area__group__place-holder').children('.count');

  $targetNode.text(value.length);
}

/**
 * 全てのバリデーションが有効かチェックする
 * @param {*} successes
 * @param {*} $node
 */
function isAllSuccess(successes, $node) {
  if (!successes.includes(false)) {
    $node.siblings('.form-area__group__alert').text('');
    $node.removeClass('alert');
    $node.addClass('success');
    return true;
  }
  return false;
}

/**
 * 送信ボタンを押せるようにする
 * @param {*} isValidValues 
 */
function unLockSubmitBtn(isValidValues) {

  if (isValidValues.name && isValidValues.email && isValidValues.password) {
    $('#submitBtn').removeClass('disabled');
  } else {
    $('#submitBtn').addClass('disabled');
  }
}

/**
 * 未入力チェック
 * @param {*} $node
 */
function validRequired($node) {
  let value = $node.val();

  if (value.length === 0) {
    $node.siblings('.form-area__group__alert').text(MSG_REQUIRED);
    $node.removeClass('success');
    $node.addClass('alert');
    return false
  }
  return true
}

/**
 * Eメール形式チェック
 * @param {*} $node
 */
function validTypeEmail($node) {
  let value = $node.val();
  let reg = new RegExp(/^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/, 'g');

  if (!value.match(reg)) {
    $node.siblings('.form-area__group__alert').text(MSG_EMAIL_TYPE);
    $node.removeClass('success');
    $node.addClass('alert');
    return false;
  }
  return true;
}

/**
 * 半角英数字チェック
 * @param {*} $node 
 */
function validHalf($node) {
  let value = $node.val();
  let reg = new RegExp(/^[A-Za-z0-9]*$/, 'g');
  if (!value.match(reg)) {
    $node.siblings('.form-area__group__alert').text(MSG_HALF);
    $node.removeClass('success');
    $node.addClass('alert');
    return false;
  }
  return true;
}

/**
 * 最小文字数チェック
 * @param {*} $node
 * @param {*} min
 */
function validMinLen($node, min) {
  let value = $node.val();
  if (value.length < min) {
    $node.siblings('.form-area__group__alert').text(min + MSG_MIN);
    $node.removeClass('success');
    $node.addClass('alert');
    return false;
  }
  return true;
}

/**
 *　最大文字数チェック
 * @param {*} $node
 * @param {*} maxNum
 */
function validMaxLen($node, maxNum) {
  let value = $node.val();
  if (value.length >= maxNum) {
    $node.siblings('.form-area__group__alert').text(maxNum + MSG_MAX);
    $node.removeClass('success');
    $node.addClass('alert');
    return false
  }
  return true
}

/**
 * フォームの送信チェック, Enter送信時にもバリデーションチェックする
 * @param {*} event
 * @param {*} isValidValues
 */
function checkFormSending(event, isValidValues) {
  if (!(isValidValues.name && isValidValues.email && isValidValues.password)) {
    //バリデーションが不完全なら送信しない
    event.preventDefault();
  }
}

/**
 * 食べ物を検索の開始の準備
 * @param {*} firstSelect
 * @param {*} secondSelect
 */
function getReadyToStartYourSearch(firstSelect, secondSelect) {
  //ローディング表示
  showLoader();

  //現在位置を取得する
  navigator.geolocation.getCurrentPosition(
    ((position) => {
      //取得成功時の処理
      const lat = position.coords.latitude; //緯度
      const lng = position.coords.longitude; //経度
      //検索を開始
      startSearchFoods(lat, lng, firstSelect, secondSelect);
    }),
    geoError
  );
}

//取得失敗
function geoError() {
  //ローディング非表示、通信失敗
  alert('現在位置が取得できませんでした。');
  fadeOutLoader();
}

/**
 * 飲食店を検索する
 * @param {*} lat
 * @param {*} lng
 * @param {*} firstSelect
 * @param {*} secondSelect
 */
function startSearchFoods(lat, lng, firstSelect, secondSelect) {

  if (firstSelect.length != 0 && secondSelect.length != 0) {
    //mapを作成
    createMap(lat, lng);
    searchFoodInfo(lat, lng, firstSelect, secondSelect);
  } else {
    alert('ジャンルが選択されませんでした。');
  }
}

/**
 * 現在地を基にマップを生成
 * @param {*} lat
 * @param {*} lng
 */
var map, service;

function createMap(lat, lng) {
  var mapDiv = document.getElementById("map");
  //地図オプション
  var mapOptions = {
    center: new google.maps.LatLng(lat, lng), //位置座標
    zoom: 16, //ズーム値
    mapTypeControl: false, //地図・衛星写真の表示
    scrollwheel: false //スクロールホイールによる拡大・縮小無効化
  }

  map = new google.maps.Map(mapDiv, mapOptions);
  service = new google.maps.places.PlacesService(map);
}

/**
 * 緯度経度を基にマップを動かす
 * @param {*} lat
 * @param {*} lng
 */
function moveToMealMap(lat, lng) {
  map.panTo(new google.maps.LatLng(lat, lng));
}

/**
 * 現在位置から半径500m以内の飲食店を検索する
 * @param {*} lat
 * @param {*} lng
 * @param {*} firstSelect
 * @param {*} secondSelect
 */
function searchFoodInfo(lat, lng, firstSelect, secondSelect) {

  //現在地から半径500m以内の検索キーワードに応じた結果を取得する。
  var requests = {
    location: new google.maps.LatLng(lat, lng),
    radius: "500",
    query: firstSelect + ' ' + secondSelect
  }
  service.textSearch(requests, setSearchFoodResult);
}

/**
 * キーワードに応じた飲食店の検索結果をセット
 * @param {*} results
 * @param {*} status
 */

function setSearchFoodResult(results, status) {

  var $resultMessage = $('#mealSearchResultCount');

  //取得内容表示用のHTMLを表示
  selectNextGenre($('#secondSelect'), $('#mealSearchResult'));

  if (results.length !== 0) {

    // 検索結果を取得していれば
    $resultMessage.text(`候補のお店が${results.length}件見つかりました。`);

    for (var i = 0; i < results.length; i++) {

      var food = results[i];
      getFoodDetails(food, i);
    }
    //ローディング非表示
    fadeOutLoader();
  } else {

    //取得していない場合
    $resultMessage.text("候補のお店が見つかりませんでした。");
    //ローディング非表示
    fadeOutLoader();
  }
}

/**
 * 食べ物に関する詳細を取得する
 * @param {*} food
 */
function getFoodDetails(food, i) {
  var requests = {
    placeId: food.place_id
  }
  //一度に大量にリクエストするとOVER_QUERY_LIMITになり、一部データが取得できなくなるので間隔を空けて取得する
  setTimeout(function () {
    service.getDetails(requests, function (results, status) {
      if (status === 'OK') {
        //取得成功なら
        appendMealSearchResultList(results);
      }
    });
  }, i * 300)
}

/**
 * 取得結果をhtml上に表示する
 * @param {*} results
 */
function appendMealSearchResultList(results) {

  //住所
  var address = "";
  address = results.formatted_address.replace("日本、", "");

  //営業状況
  var openNow = "";
  if (results.opening_hours) {
    //バグあり
    if (results.opening_hours.isOpen()) {
      //営業中なら
      openNow = "営業中"
    } else {

      openNow = "営業時間外"
    }
  }

  //写真情報(サムネイル)を取得
  var topThum = "";
  $.each(results.photos, function (picKey, pic) {
    if (picKey === 0) {
      //最初に取得した画像urlをトップのサムネにする。
      topThum = pic.getUrl({
        "maxWidth": 120,
        "maxHeight": 120
      })
    }
  });

  //営業時間
  var tmp = [];
  var todaysDay = getTodaysDay();

  tmp = getArrayOpeningHours(results.opening_hours);
  //今日の営業時間
  var currentOpeningHours = getFormatOpeningHourForWeek(tmp[todaysDay]);
  var $mealSearchResultLists = $('#mealSearchResultLists');
  var appendData = `<li class="meal-search-result__list" data-lat="${results.geometry.location.lat()}" data-lng="${results.geometry.location.lng()}" data-place-id="${results.place_id}">
  <div class="meal-search-result__details">
    <h3 class="meal-search-result__details__title">${results.name}</h3>
    <dl class="meal-search-result__details__info">
      <dt>住所:</dt>
      <dd>${address}</dd>
      <dt>${openNow}:</dt>
      <dd>${currentOpeningHours}</dd>
      <dt>TEL:</dt>
      <dd>${results.formatted_phone_number}</dd>
    </dl>
  </div>
  <p class="meal-search-result__list__img"><img src="${topThum}"></p>`;

  if (!userId) {
    //ユーザー登録していない場合
    appendData += '</li>';
  } else {
    //登録していたらお気に入りアイコンを表示
    appendData += '<i class="fa fa-heart meal-search-result__list__favorite" aria-hidden="true"></i></li>';
  }

  //todo お気に入りに登録済みならアイコンをアクティブにする?

  $mealSearchResultLists.append(appendData);

  var details = {
    address,
    openNow
  }
  createMarker(results, details);
}

/**
 * 今日の曜日を取得
 */
function getTodaysDay() {
  var date = new Date();
  return date.getDay();
}

/**
 * keyに対応した曜日を取得
 */
function getWeekByKey(key) {
  var week = {
    "0": "日曜日",
    "1": "月曜日",
    "2": "火曜日",
    "3": "水曜日",
    "4": "木曜日",
    "5": "金曜日",
    "6": "土曜日",
  };

  if (week[key]) {
    return week[key];
  }
  return "";
}

/**
 * 曜日に変換
 * @param {*} epochSec
 */
function changeWeek(epochSec) {
  var date = new Date();
  date.setTime(epochSec);
  return date.getDay();
}

/**
 * 営業時間を取得する
 * @param {*} openingHours
 */
function getArrayOpeningHours(openingHours) {
  var result = [];
  if (openingHours) {
    $.each(openingHours.periods, function (periodKey, period) {
      //営業開始時間
      var open;
      if (period.open && period.open.time) {
        open = period.open.time;
      } else {
        open = "";
      }

      //営業終了時間
      var close;
      if (period.close && period.close.time) {
        close = period.close.time;
      } else {
        close = "";
      }

      if (!result[changeWeek(period.open.nextDate)]) {
        //次の営業開始日が違う日時の場合
        result[changeWeek(period.open.nextDate)] = [];
      }
      result[changeWeek(period.open.nextDate)].push([open, close]);

    });
  }

  return result;
}

/**
 * 営業時間を表示用に変換
 * 24時間営業, ○時○分 ~ ○時○分
 * @param {*} arrayOpeningHour
 */
function getFormatOpeningHourForWeek(arrayOpeningHour) {
  var openingHour = "";

  if (arrayOpeningHour) {
    for (var j in arrayOpeningHour) {
      if (arrayOpeningHour[j]) {

        if (arrayOpeningHour[j][0] == "0000" && !arrayOpeningHour[j][1]) {
          // nextDateが0000の場合24時間営業
          openingHour = "24時間営業";
        } else {

          if (arrayOpeningHour[j][0]) {
            //○時○分
            openingHour += arrayOpeningHour[j][0].substring(0, 2) + ":" + arrayOpeningHour[j][0].substring(2, 4)
          }

          if (arrayOpeningHour[j][1]) {
            //○時○分 ~ ○時○分
            if (arrayOpeningHour[j][0]) {
              openingHour += "~";
              openingHour += arrayOpeningHour[j][1].substring(0, 2) + ":" + arrayOpeningHour[j][1].substring(2, 4) + " ";
            }
          }
        }
      }
    }
  } else {
    openingHour = "定休日";
  }

  return openingHour;
}

/**
 * mapにマーカー作成
 * @param {*} results
 */
function createMarker(results, details) {
  //マーカー作成
  var foodLocation = results.geometry.location;

  var marker = new google.maps.Marker({
    map,
    position: new google.maps.LatLng(foodLocation.lat(), foodLocation.lng())
  });

  //詳細表示用HTML
  var contentString = getFoodContentString(results, details);

  var infoOption = {
    maxWidth: 320,
    maxHeight: 1000,
    content: contentString
  }

  var infoWindow = new google.maps.InfoWindow(infoOption);

  marker.addListener("click", () => {
    infoWindow.open(map, marker);
  })
}

/**
 * 詳細に表示するHTMLを取得
 * @param {*} results 
 * @param {*} details 
 */
function getFoodContentString(results, details) {
  //サムネイル表示用のリストHTML
  var thumLists = "";
  var mealThum = "";
  const maxThumLength = 4;

  for (var i = 0; i < maxThumLength; i++) {
    //サムネイルを4枚まで表示する
    if (results.photos[i]) {
      mealThum = results.photos[i].getUrl();
      thumLists += `<li><img src="${mealThum}"></li>`;
    }
  }

  //営業時間表示用のHTML
  var openingHourLists = "";
  var arrayOpeningHours = [];
  arrayOpeningHours = getArrayOpeningHours(results.opening_hours);

  //key値を曜日に変換したhtmlを作成する
  $.each(arrayOpeningHours, function (week, hours) {

    var week = getWeekByKey(week);
    var openingHour = getFormatOpeningHourForWeek(hours);

    if (openingHour === "24時間営業") {

      //24時間営業の場合は曜日を表示しない
      openingHourLists += `<li>${openingHour}</li>`;
    } else {

      openingHourLists += `<li>${week + " " + openingHour}</li>`;
    }
  });

  //クチコミ表示用のHTML
  var reviewLists = "";

  $.each(results.reviews, function (reviewKey, review) {
    if (review) {
      reviewLists += `<li><p class="author-name">${review.author_name}</p><p class="review-text">${review.text}</p></li>`;
    }
  })


  //詳細のUI
  var contentString =
    `<section class="meal-detail">
      <div>
        <ul class="meal-detail__lists">
          ${thumLists}
        </ul>
        <h3>${results.name}</h3>
        <dl class="meal-detail__show">
          <dt>住所:</dt>
          <dd>${details.address}</dd>
          <dt>TEL:</dt>
          <dd>${results.formatted_phone_number}</dd>
          <dt>営業時間<br><span class="meal-detail__open-now">${details.openNow}<span></dt>
          <dd>
            <ul class="opening-hour-lists">
            ${openingHourLists}
            </ul>
          </dd>
        </dl>
        <h4>クチコミ</h4>
        <ul class="meal-detail__review-lists">
          ${reviewLists}
        </ul>
      </div>
    </section>`;

  return contentString;
}

/**
 * 飲食店のお気に入り登録フラグを更新
 * @param {*} place_id
 * @param {*} $node
 */
function postMealFavorite(place_id, $node) {
  var requests = {
    food_id: place_id
  };

  //リクエスト成功したらハートをアクティブにする
  $.ajax({
      type: "POST",
      url: "/meal_favorite.php",
      data: requests,
      dataType: "json",
    })
    .done(function (response) {

      if ('isFavorite' in response) {
        if (response.isFavorite) {
          //お気に入り登録
          $node.addClass('active');
        } else {
          //お気に入り解除
          $node.removeClass('active');
        }
      } else {
        alert('お気に入り登録は会員登録をする必要があります。');
      }
    })
    .fail(function (error) {
      alert('システムにエラーが発生しました。時間を置いて再度ご登録ください。');
    });
}

/**
 * 画像ファイルのプレビュー表示機能
 * @param {*} $myIconImg 
 * @param {*} event 
 */
function readingImageFile($myIconImg, event) {

  var fileReader = new FileReader;
  fileReader.onload = (function () {
    $myIconImg.attr('src', fileReader.result);
  });
  fileReader.readAsDataURL(event.target.files[0]);
}