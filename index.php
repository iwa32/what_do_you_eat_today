<?php

require('function.php');
debug('「「「「「「「「「「「「');
debug('ジャンル選択(index)');
debugLogStart();

try {
  //カテゴリーを取得する
  $mainCategories = getMainCategories();

  if (!empty($mainCategories)) {

    //サブカテゴリーを取得する
    $subCategories = getSubCategories();
  }
} catch (Exception $e) {
  error_log('エラー発生:' . $e->getMessage());
  $err_msg['common'] = MSG_SYS_ERROR;
}

?>
<?php
$siteTitle = 'ジャンルを選んでね。';
require("head.php");
?>

<body>
  <?php require("header.php"); ?>

  <main class="contents">
    <div class="main-container container">
      <div class="eat-selects">
        <h2 class="eat-selects__title">ジャンルを選んでね</h2>

        <div class="eat-selects__alert"><?php if (!empty($err_msg['common'])) echo $err_msg['common']; ?></div>

        <div class="first-select eat-select" id="firstSelect">
          <ul class="eat-select__lists">
            <?php if (!empty($mainCategories)) : ?>
              <?php foreach ($mainCategories as $mainCategory) : ?>
                <li class="eat-select__list 
                <?php if (!empty($mainCategory['id'])) echo 'eat-select__list--main-' . $mainCategory['id']; ?>">
                  <?php if (!empty($mainCategory['name'])) echo $mainCategory['name']; ?>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>

        <div class="second-select eat-select" id="secondSelect">
          <ul class="eat-select__lists">
            <?php if (!empty($subCategories)) : ?>
              <?php foreach ($subCategories as $subCategory) : ?>
                <li class="eat-select__list
                <?php if (!empty($subCategory['id'])) echo 'eat-select__list--sub-' . $subCategory['id']; ?>">
                  <?php if (!empty($subCategory['name'])) echo $subCategory['name']; ?>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>
        </div>

        <div class="meal-search-result" id="mealSearchResult">
          <p class="meal-search-result__found" id="mealSearchResultCount">候補のお店が○件見つかりました</p>

          <div class="meal-search-result__contents">
            <ul class="meal-search-result__lists" id="mealSearchResultLists">
            </ul>
            <!-- ※3件以上あったらスクロールできることを示唆するアイコンを表示する -->

            <div class="meal-search-result__g-map" id="map">
            </div>
          </div>



          <p class="meal-search-result__to-top">
            <a href="./">トップへ戻る</a>
          </p>
        </div>

      </div>
    </div>
  </main>

  <?php require("footer.php") ?>