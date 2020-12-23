<?php require("head.php") ?>

<body>
  <?php require("header.php") ?>

  <main class="contents">
    <div class="main-container container">
      <div class="form-area edit-my-page">
        <h2 class="form-area__title">プロフィール編集</h2>

        <form action="./my_page.php" method="POST">
          <!-- プレビュー -->
          <div class="form-area__group">
            <p class="edit-my-page__thum-img">
              <img src="http://placehold.jp/180x180.png">
            </p>
            <label for="thum"><input type="file" name="" id="thum"></label>
          </div>

          <div class="form-area__group">
            <label for="name">
              <div class="form-area__group__name">お名前<span class="form-area__group__badge form-area__group__badge--normal">[任意]</span></div>
              <div class="form-area__group__help">Eメール形式で入力してください</div>
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
              <div class="form-area__group__alert">エラーテキスト</div>
              <div class="form-area__group__place-holder">you@example.com</div>
            </label>
          </div>

          <div class="form-area__group">
            <label for="message">
              <div class="form-area__group__name">メッセージ<span class="form-area__group__badge form-area__group__badge--normal">[任意]</span></div>
              <div class="form-area__group__help">670文字まで入力可能です。</div>
              <textarea class="form-area__group__input edit-my-page__message" type="text" name="message" id="message"></textarea>
              <div class="form-area__group__alert">エラーテキスト</div>
              <div class="form-area__group__place-holder">0/670</div>
            </label>
          </div>

          <div class="edit-my-page__btns"><button class="edit-btn btn">編集する</button></div>
        </form>
      </div>
    </div>
  </main>

  <?php require("footer.php") ?>