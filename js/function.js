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

