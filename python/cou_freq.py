import collections
import pickle
import matplotlib.pyplot as plt
import japanize_matplotlib

def plot_words(words, counts):
    from matplotlib.font_manager import FontProperties
    plt.figure(figsize=(10,5),dpi=200)
    barlist=plt.bar(range(800), counts, align='center')
    for i in range(16):
        ii=((i+1)*50)-1 #i=1,2,..,20 ii=50,100,..,800
        barlist[ii].set_color('r')
    plt.xticks(range(0, 800+1, 50))
    plt.xlabel("単語のindex(n番目)")
    plt.ylabel("出現数(回)")
    plt.show()

#NGワード設定してない辞書
with open("example.pkl","rb") as f:
    #文字列にして読み込み
    #name_list = ["いそべや"]
    name_list = ["環境ロドリゲス","em factory","NPO法人とちぎ生涯学習研究会","ふるさと愛好会","生物多様性わかものネットワーク","RCE横浜若者連合","ezorock","Climate Youth Japan","石垣島を元気にするプロジェクト","思惟の森の会","命をつなぐPROJECT","農楽塾","早大こだま","いろり","キャンエコ","静岡大学リアカー","えこまな＠京田辺","千葉大ISO学生委員","オアシス","ECOFF","日本工業大学学生環境推進委員会","環境部エコロ助","つくば学生農業ヘルパー","にしき恋","農村16きっぷ","GECS","ecocon","環境三四郎","東京都市大学ISO学生委員会","やまなび","たまっこ","えこのわぐま","ecoSMILE","REC","Re-Cover","ソラワタリ","aRc"]
    #多次元リスト
    words_list2 = pickle.load(f)
    #一次元リスト(多次元だとmost_commonが正常にできないため)
    words_list1 = sum(words_list2, [])

cnt = collections.Counter(words_list1)
lst_commons = cnt.most_common()

#800単語だと20回以上#lst_commons[:400:]
#print(lst_commons[8:81])#range(i,e)の時[i-1:e]
#20ごとの単語とその出現数
list20=[]
for i in range(75):
    ii=((i+1)*20)-1
    list20.append(lst_commons[ii])
print(list20)

#出現頻度のグラフ化
words = []
counts = []
for word, count in lst_commons[:800:]:#400#
    #print(word, count)
    words.append(word)
    counts.append(count)
plot_words(words, counts)

#厳選した単語で辞書を再構築
dic400=lst_commons[:800:]
ok_list=[]
chk_list=[]
new_list=[]
for i in range(30,801):#9以上163未満
    ok_list.append(dic400[i-1][0])
#print(ok_list)#[9:163]#一次元残したいやつ
dif=list(set(words_list1)-set(ok_list))
#print(dif)#[:9,163:]#一次元消したいやつ
for i in range(len(words_list2)):
    chk_list=list(filter(lambda x:x not in dif, words_list2[i]))
    #print(new_list)#多次元の一行だけ取り出して消したい単語の削除
    new_list.append(chk_list)
#print(new_list)#多次元に戻す
with open("new_dic_30_801.pkl","wb") as ff:
    pickle.dump(new_list,ff)
