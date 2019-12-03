# 卒論用   
## python
### webサイトの文章を機械学習で特徴語抽出、サークル間の類似度判定　　
「first_url.json」：「saveHTML.py」にてHTMLコードを取得したいサイトのURLを書く  
「saveHTML.py」：URLからそのページのHTMLをローカルに保存  
「HTML_to_only_text.py」：ローカルに保存されたHTMLを読み込みタグを外し、日本語文章だけにして「only_text.json」に保存  
「only_text.json」：単語へ分かち書きされていな状態で文章が保存される  
「only_text_to_words.py」：メモリの関係でGoogleColaboratory上で実行する。文章が単語へ分かち書きされる。  
「cou_freq.py」：分かち書きされた単語を出現頻度順に並べた棒グラフを作成。頻度が多すぎたり少なすぎる単語を削除し、辞書を作る。  
「words_to_tfidf.py」：作られた辞書をもとにTf-Idfで文書(団体のwebサイト本文)の特徴語を抽出。クラスター分析を行い、文書が似ている団体を探し出す。  
「30〜800.png」：頻度が多すぎたり少なすぎる単語を削除し、30〜800番目の単語まで採用し、クラスター分析を行なったもの。下で結合しているほど類似している。  
# php  
## 協調フィルタリングによる推薦システム開発(多数のユーザの行動履歴をもとに、新たなユーザに推薦を行う)  
成果物は以下の二つ  
[http://furukori.php.xdomain.jp/ques.php](http://furukori.php.xdomain.jp/ques.php)  
[http://furukori.php.xdomain.jp](http://furukori.php.xdomain.jp)  
「ques.php」：多数ユーザの行動履歴取得用。Big５という心理テストの結果がDBへ保存される。  
「end.php」：心理テストの結果を表示(おまけみたいなもの)  
「index.php」：推薦システム本体。「ques.php」で取得されたデータをDBから参照し、新ユーザと比較する。　　
「result.php」：心理テストの結果と、協調フィルタリング推薦の結果を表示。推薦するのは「circle.csv」に書いてあるボランティア団体。  
「circle.csv」；機械学習で得られた類似度をもとに、似ているボランティア団体ごとに分けて記入した。　　
