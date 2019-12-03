#####「first_url.json」ファイルに書かれた団体名をローカルに保存#####
import json
import requests

def main():

    #書き込んだ「first_url.json」ファイルを開く
    with open("first_url.json", "r", encoding="utf-8") as file:
        json_data = json.load(file)

    #forループをする都合上、団体名を書き出す
    #稀に文字コードの関係で文字化けするので注意
    name_list = ["環境ロドリゲス","em factory","NPO法人とちぎ生涯学習研究会","ふるさと愛好会","生物多様性わかものネットワーク","RCE横浜若者連合","ezorock","Climate Youth Japan","石垣島を元気にするプロジェクト","思惟の森の会","命をつなぐPROJECT","農楽塾","早大こだま","いろり","キャンエコ","静岡大学リアカー","えこまな＠京田辺","千葉大ISO学生委員","オアシス","ECOFF","日本工業大学学生環境推進委員会","環境部エコロ助","つくば学生農業ヘルパー","農村16きっぷ"]
    #全部で7p*31=217
    #ぱれっと(https://teratail.com/questions/143365)
    #手動
    #"GECS","ecocon","環境三四郎","東京都市大学ISO学生委員会",
    #手動で文字化け削除
    #錦鯉
    #削除(1Pしかないので)
    #"KITeco","ウミガメ研究会","アカシアの木","いそべや","東農大ボラ部","首都大nature"

    #団体名を元にjsonのURLからHTMLをfname名義で保存
    for name in name_list:
        #forループしたかったが動的な変数が実現できず無事死亡
        #とりま１団体につき10Pまで保存可能
        res1 = requests.get("{}".format(json_data[name]["URL1"]))
        with open("circle/{}_1.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
            file.write(res1.text)

        #URL2がある時
        try:
            res2 = requests.get("{}".format(json_data[name]["URL2"]))
            with open("circle/{}_2.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res2.text)
        except:
            pass
        #URL3がある時
        try:
            res3 = requests.get("{}".format(json_data[name]["URL3"]))
            with open("circle/{}_3.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res3.text)
        except:
            pass
        #URL4がある時
        try:
            res4 = requests.get("{}".format(json_data[name]["URL4"]))
            with open("circle/{}_4.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res4.text)
        except:
            pass
        #URL5がある時
        try:
            res5 = requests.get("{}".format(json_data[name]["URL5"]))
            with open("circle/{}_5.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res5.text)
        except:
            pass
        #URL6がある時
        try:
            res6 = requests.get("{}".format(json_data[name]["URL6"]))
            with open("circle/{}_6.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res6.text)
        except:
            pass
        #URL7がある時
        try:
            res7 = requests.get("{}".format(json_data[name]["URL7"]))
            with open("circle/{}_7.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res7.text)
        except:
            pass
        #URL8がある時
        try:
            res8 = requests.get("{}".format(json_data[name]["URL8"]))
            with open("circle/{}_8.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res8.text)
        except:
            pass
        #URL9がある時
        try:
            res9 = requests.get("{}".format(json_data[name]["URL9"]))
            with open("circle/{}_9.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res9.text)
        except:
            pass
        #URL10がある時
        try:
            res10 = requests.get("{}".format(json_data[name]["URL10"]))
            with open("circle/{}_10.html".format(json_data[name]["fname"]),"w",encoding="utf-8") as file:
                file.write(res10.text)
        except:
            pass

if __name__=='__main__':
    main()
