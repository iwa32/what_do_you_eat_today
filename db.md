#### ユーザテーブル(users)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | ユーザid   |  id  |  integer  |  ×  |    |    | 
|  2  |  ユーザ名  |  name  |  varchar  |  ○  |    |    | 
|  3  |  メールアドレス  |  email  |  varchar  |  ×  |    |    | 
|  4  |  パスワード  |  password  |  varchar  |  ×  |   |    | 
|  5  |  プロフィール画像  |  my_icon  |  varchar  |  ○  |  |    | 
|  6  |  メッセージ  |  message  |  text  |  ○  |   |    | 
|  7  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  8  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  9  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### フードカテゴリテーブル(food_categories)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | フードカテゴリid   |  id  |  integer  |  ×  |    |    | 
|  2  |  カテゴリ名  |  name  |  varchar  |  ×  |    |    | 
|  3  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  4  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  5  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### フードサブカテゴリテーブル(food_sub_categories)
|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | フードサブカテゴリid   |  id  |  integer  |  ×  |    |    | 
|  2  |  カテゴリ名  |  name  |  varchar  |  ×  |    |    | 
|  3  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  4  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  5  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### 飲食店レビューテーブル(food_reviews)
|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | レビューid   |  id  |  integer  |  ×  |    |    | 
|  2  | ユーザid  |  user_id  |  integer  |  ×  |    |    | 
|  3  | フードid   |  food_id  |  varchar  |  ×  |    |    | 
|  4  | コメント  |  comment  |  text  |  ×  |    |    | 
|  5  | スコア   |  score  |  integer  |  ×  |    |    | 
|  6  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  7  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  8  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### 飲食店お気に入りテーブル(favorite_foods)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | お気に入りid   |  id  |  integer  |  ×  |    |    | 
|  2  | ユーザid  |  user_id  |  integer  |  ×  |    |    | 
|  3  | フードid   |  food_id  |  varchar  |  ×  |    |    | 
|  4  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  5  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  6  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### ユーザー飲食店検索履歴テーブル(food_search_histories)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | 履歴id   |  id  |  integer  |  ×  |    |    | 
|  2  | ユーザid  |  user_id  |  integer  |  ×  |    |    | 
|  3  | フードid   |  food_id  |  varchar  |  ×  |    |    | 
|  4  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  5  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  6  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 


<br>

#### 飲食店テーブル(foods)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | 飲食店id   |  id  |  integer  |  ×  |    |    | 
|  2  | 緯度  |  latitude  |  double  |  ×  |    |    | 
|  3  | 経度   |  longitude  |  double  |  ×  |    |    | 
|  4  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  5  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  6  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 


<br>

#### 選択したカテゴリーカウントテーブル(count_selected_categories)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | カウントid   |  id  |  integer  |  ×  |    |    | 
|  2  | カテゴリid  |  category_id  |  integer  |  ×  |    |    | 
|  3  | サブカテゴリid   |  sub_category_id  |  integer  |  ×  |    |    | 
|  4  | ユーザid   |  user_id  |  integer  |  ×  |    |    | 
|  5  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  6  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  7  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 
