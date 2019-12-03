# !sudo apt-get clean
# !sudo apt-get update
#
# !apt install aptitude
# !aptitude install mecab libmecab-dev mecab-ipadic-utf8 git make curl xz-utils file -y
# !pip install mecab-python3==0.7
#
# !git clone --depth 1 https://github.com/neologd/mecab-ipadic-neologd.git
# !echo yes | mecab-ipadic-neologd/bin/install-mecab-ipadic-neologd -n

#####Googleコラボ用「only_text.json」からresult表示#####
import json #json使う
import pickle
import MeCab
import re
import urllib.request
from sklearn.feature_extraction.text import TfidfVectorizer
import numpy as np
from google.colab import files
import gc

def main():
    #json形式を読み込む
    f = open("only_text.json","r")
    json_data = json.load(f)

    #メモリ解放
    del f
    gc.collect()

    #ライブラリ「utils」を使って名詞形容詞のみ語幹抽出
    wd = WordDividor()
    docs = [wd.extract_words(row) for row in json_data]
    del json_data
    gc.collect()
    #print("{}".format(json.dumps(docs,ensure_ascii=False)))
    print(docs)
    with open("example.pkl","wb") as f1:
        pickle.dump(docs,f1)
    files.download('example.pkl')

    #with open("words.pkl","wb") as f1:
        #pickle.dump(docs,f1)

class WordDividor:
    INDEX_CATEGORY = 0
    TARGET_CATEGORY = ['名詞','形容詞','連体詞','副詞','助動詞','接続詞','指示詞','感動詞','名詞','動詞','助詞','接頭辞','接尾辞']
    INDEX_CATEGORY_CLASS = 1
    TARGET_CLASS = ['サ変接続','ナイ形容詞語幹','一般','形容動詞語幹','自立','固有名詞','数','接続詞的','接尾']#自立は形容詞
    NG_WORDS=['\u200b']
    #NG_WORDS = ['環境','活動','特定','一覧','詳細','ソラワタリ','ぐま','ロドリゲス','し','する','ぱれっと','年月日','とちぎ','生涯学習','愛好','ふるさと','わ','若者','大阪大学','徳島大学','ハマ','年月','年度','公益情報','具合','兼ね','芝浦工業大学','選抜','講義','駒場祭','思惟','メールアドレス','施設','幹事長','期','たまっこ','まなび','ホーム','ブログ','イベント','団体','全国大学生環境活動コンテスト','佐那河内','わか','月日','フェリス女学院大学','弾','インタビュー','ポロクル','魅力','問題','分け','内容','内装','就職','テーマ','早稲田','連絡','代','周','入会','ガクサー','掲載','参加','ページ','新規','問い合せ','-','再入学','入学','駒場','フェア','御礼','リンク','ブログ記事','検索','歴代','横浜市立大学','コン','コラム','再生氏','冨塚','シケプリ','ソラ','長','申請','機能','代表','処理','再配達','再開','写真','歩き','会員登録','メッセージ','市立','凸凹','冥界','新歓','コメント','パズル','出し','凝らし','処分','乾燥','ログイン','どんぐり','昌治','連載','出て','凧','ファンケル','ボラ','出','出さ']
    #TARGET_CATEGORY = ['形容詞','連体詞','副詞','助動詞','接続詞','指示詞','感動詞','名詞','動詞','助詞','接頭辞','接尾辞']
    #TARGET_CLASS = ['サ変接続','ナイ形容詞語幹','一般','引用文字列','形容動詞語幹','固有名詞','数','接続詞的','接尾']

    def __init__(self, dictionary="-Owakati"):#mecabrc
        self.dictionary = dictionary
        self.tagger = MeCab.Tagger(self.dictionary)

    def extract_words(self,text):
        if not text:
            return []

        # テキストの余分なデータの削除(ex : httpなど)
        text = re.sub(r'https?://[\w/:%#\$&\?\(\)~\.=\+\-…]+', "", text)
        text = re.sub(r'[!-~]', "", text)  # 半角記号,数字,英字
        text = re.sub(r'[︰-＠]', "", text)  # 全角記号
        text = re.sub('\n', " ", text)  # 改行文字

        words = []
        # 文字列がGCされるのを防ぐ
        self.tagger.parse('')
        node = self.tagger.parseToNode(text)
        # ストップワードの判定を行う(stopwordsに引っかかってない名詞を入れる)
        slothlib_path = 'http://svn.sourceforge.jp/svnroot/slothlib/CSharp/Version1/SlothLib/NLP/Filter/StopWord/word/Japanese.txt'
        slothlib_file = urllib.request.urlopen(slothlib_path)
        slothlib_stopwords = [line.decode("utf-8").strip() for line in slothlib_file]
        slothlib_stopwords = [ss for ss in slothlib_stopwords if not ss==u'']
        del slothlib_path
        del slothlib_file
        gc.collect()

        while node:
            # "，"で文字列の分割を行い, ターゲットになる品詞と比較を行う.
            if node.feature.split(',')[self.INDEX_CATEGORY] in self.TARGET_CATEGORY:
                if node.feature.split(',')[self.INDEX_CATEGORY_CLASS] in self.TARGET_CLASS:
                    if node.surface not in slothlib_stopwords:
                        if node.surface not in self.NG_WORDS:
                            words.append(node.surface)
            node = node.next

        return words

if __name__=='__main__':
    main()
