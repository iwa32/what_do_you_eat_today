<?php require("head.php") ?>

<body>
  <?php require("header.php") ?>

  <main class="contents">
    <div class="main-container container">
      <div class="eat-selects">
        <h2 class="eat-selects__title">ジャンルを選んでね</h2>

        <div class="first-select eat-select" id="firstSelect">
          <ul class="eat-select__lists">
            <li class="eat-select__list eat-select__list--lunch">ランチ</li>
            <li class="eat-select__list eat-select__list--dinner">ディナー</li>
          </ul>
        </div>

        <div class="second-select eat-select" id="secondSelect">
          <ul class="eat-select__lists">
            <li class="eat-select__list eat-select__list--meat">肉</li>
            <!-- <li class="eat-select__list test">肉
              <p><img src="./img/niku01_b_02.png" alt="お肉"></p>
            </li> -->

            <li class="eat-select__list eat-select__list--fish">魚</li>
            <li class="eat-select__list eat-select__list--noodles">麺</li>
            <li class="eat-select__list eat-select__list--bread">パン</li>
            <li class="eat-select__list eat-select__list--rice">米</li>
            <li class="eat-select__list eat-select__list--dessert">デザート</li>
          </ul>
        </div>


        <div class="meal-search-result" id="mealSearchResult">
          <p class="meal-search-result__found">候補のお店が○件見つかりました</p>

          <div class="meal-search-result__contents">
            <ul class="meal-search-result__lists">
              <li class="meal-search-result__list">
                <div class="meal-search-result__details">
                  <h3 class="meal-search-result__details__title">夢庵〇〇店</h3>

                  <dl class="meal-search-result__details__info">
                    <dt>住所</dt>
                    <dd>fadfjasklf</dd>
                    <dt>営業中</dt>
                    <!--動的に変更-->
                    <dd>07:00-19:00</dd>
                    <dt>TEL</dt>
                    <dd>01-2345-0789</dd>
                  </dl>
                </div>

                <p class="meal-search-result__list__img"><img src="http://placehold.jp/120x120.png"></p>
              </li>

              <li class="meal-search-result__list">
                <div class="meal-search-result__details">
                  <h3 class="meal-search-result__details__title">夢庵〇〇店</h3>

                  <dl class="meal-search-result__details__info">
                    <dt>住所</dt>
                    <dd>fadfjasklf</dd>
                    <dt>営業中</dt>
                    <!--動的に変更-->
                    <dd>07:00-19:00</dd>
                    <dt>TEL</dt>
                    <dd>01-2345-0789</dd>
                  </dl>
                </div>

                <p class="meal-search-result__list__img"><img src="http://placehold.jp/120x120.png"></p>
              </li>

              <li class="meal-search-result__list">
                <div class="meal-search-result__details">
                  <h3 class="meal-search-result__details__title">夢庵〇〇店</h3>

                  <dl class="meal-search-result__details__info">
                    <dt>住所</dt>
                    <dd>fadfjasklf</dd>
                    <dt>営業中</dt>
                    <!--動的に変更-->
                    <dd>07:00-19:00</dd>
                    <dt>TEL</dt>
                    <dd>01-2345-0789</dd>
                  </dl>
                </div>

                <p class="meal-search-result__list__img"><img src="http://placehold.jp/120x120.png"></p>
              </li>

              <li class="meal-search-result__list">
                <div class="meal-search-result__details">
                  <h3 class="meal-search-result__details__title">夢庵〇〇店</h3>

                  <dl class="meal-search-result__details__info">
                    <dt>住所</dt>
                    <dd>fadfjasklf</dd>
                    <dt>営業中</dt>
                    <!--動的に変更-->
                    <dd>07:00-19:00</dd>
                    <dt>TEL</dt>
                    <dd>01-2345-0789</dd>
                  </dl>
                </div>

                <p class="meal-search-result__list__img"><img src="http://placehold.jp/120x120.png"></p>
              </li>
            </ul>
            <!-- ※3件以上あったらスクロールできることを示唆するアイコンを表示する -->

            <div class="meal-search-result__g-map">
              g-map
              候補をホバーするとピンが移動する?
            </div>
            <!-- ↑googlemapになる -->
          </div>



          <p class="meal-search-result__to-top">
            <a href="./">トップへ戻る</a>
          </p>
        </div>

      </div>
    </div>
  </main>

  <?php require("footer.php") ?>