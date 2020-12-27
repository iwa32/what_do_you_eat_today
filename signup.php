<?php require("head.php") ?>

<body>
  <?php require("header.php") ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area">
        <h2 class="form-area__title">ユーザー登録</h2>

        <form action="" method="POST">
          <div class="form-area__group">
            <div class="form-area__group__alert">エラーテキスト(DB接続エラー)</div>
          </div>
          <div class="form-area__group">
            <label for="name">
              <div class="form-area__group__name">お名前<span class="form-area__group__badge form-area__group__badge--any">[任意]</span></div>
              <input class="form-area__group__input" type="text" name="name" id="name">
              <div class="form-area__group__alert">エラーテキスト</div>
              <div class="form-area__group__place-holder">山田太郎</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="email">
              <div class="form-area__group__name">Eメール<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
              <input class="form-area__group__input" type="text" name="email" id="email">
              <div class="form-area__group__alert"></div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="password">
              <div class="form-area__group__name">パスワード<span class="form-area__group__badge form-area__group__badge--required">[必須]</span></div>
              <div class="form-area__group__help">5文字以上で半角英数字で入力してください</div>
              <input class="form-area__group__input" type="password" name="password" id="password">
              <div class="form-area__group__alert"></div>
            </label>
          </div>

          <div class="form-area__btn-group">
            <div class="form-area__btn--wrapp">
              <button class="form-area__btn form-area__btn--normal disabled" id="submitBtn">登録する</button>
            </div>

            <div class="form-area__btn--wrapp">
              <button class="form-area__btn form-area__btn--twitter">Sign in with Twitter</button>
            </div>


          </div>
        </form>

      </div>
    </div>
  </main>

  <?php require("footer.php") ?>