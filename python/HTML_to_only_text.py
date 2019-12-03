#####ローカルに保存されたHTMLを読み込み、不要なタグを削除して「only_text.json」に保存#####
import json
from lxml import html
import requests

def main():

    #書き込んだ「first_url.json」ファイルを開く
    with open("first_url.json", "r", encoding="utf-8") as file:
        json_data = json.load(file)

    #forループをする都合上、団体名を書き出す
    #稀に文字コードの関係で文字化けするので注意ex)GECSいそべや三四郎
    name_list = ["環境ロドリゲス","em factory","NPO法人とちぎ生涯学習研究会","ふるさと愛好会","生物多様性わかものネットワーク","RCE横浜若者連合","ezorock","Climate Youth Japan","石垣島を元気にするプロジェクト","思惟の森の会","命をつなぐPROJECT","農楽塾","早大こだま","いろり","キャンエコ","静岡大学リアカー","えこまな＠京田辺","千葉大ISO学生委員","オアシス","ECOFF","日本工業大学学生環境推進委員会","環境部エコロ助","つくば学生農業ヘルパー","にしき恋","農村16きっぷ","GECS","ecocon","環境三四郎","東京都市大学ISO学生委員会"]
    #,"やまなび","たまっこ","えこのわぐま","ecoSMILE","REC","Re-Cover","ソラワタリ","aRc"
    #"KITeco","アカシアの木","首都大nature","東京農大ボランティア部"
    #HTMLから抽出した本文の追加用
    text_list = []

    #団体名を元にjsonのURLからHTMLをfname名義で保存
    for name in name_list:
        text_list_pre = []

        #保存したhtmlファイルを再び読み込み
        for j in range(1,11):
            try:
                html_file = r"circle/{}_{}.html".format(json_data[name]["fname"],j)

                #HTML読み込みf.read #解析　html.fromstring()
                with open(html_file,mode='rb') as f:
                    t = html.fromstring(f.read())

                # 不要なタグを削除する例
                remove_tags = ('.//style', './/script', './/noscript')
                for remove_tag in remove_tags:
                    for tag in t.findall(remove_tag):
                        tag.drop_tree()
                        # ここでの削除は元の変数tに反映されます。

                #テキスト抽出　#スペース改行除去 strip()
                text = t.text_content().replace(" ","").replace("\n","").replace("\t","").replace("\r","").strip()
                text_list_pre.append(text)
            except:
                pass
        text_list.append(' '.join(text_list_pre))
    #二つのリストを辞書で保存
    circle_dict = dict(zip(text_list,name_list))
    with open("only_text.json","w") as f:
        json.dump(circle_dict,f,ensure_ascii=False,indent=4)

if __name__=='__main__':
    main()
