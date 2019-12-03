#####「words.pkl」に保存された語幹からtfidf#####
import pickle
import numpy as np
from sklearn.feature_extraction.text import TfidfVectorizer
import gc
from sklearn.decomposition import TruncatedSVD
from sklearn.manifold import TSNE
import pandas as pd
from sklearn.cluster import KMeans
from sklearn.metrics.pairwise import cosine_similarity
from scipy.cluster.hierarchy import dendrogram,linkage,fcluster
import matplotlib.pyplot as plt
from sklearn import linear_model
import japanize_matplotlib

def main():
    with open("new_dic_30_801.pkl","rb") as f:
        #new_dic_9_163.pkl
        #new_dic_9_81.pkl
        #文字列にして読み込み
        #形態素の時に千葉大isoと錦こいは削除している,"ソラワタリ","aRc"
        name_list = ["環境ロドリゲス","em factory","NPO法人とちぎ生涯学習研究会","ふるさと愛好会","生物多様性わかものネットワーク","RCE横浜若者連合","ezorock","Climate Youth Japan","石垣島を元気にするプロジェクト","思惟の森の会","命をつなぐPROJECT","農楽塾","早大こだま","いろり","キャンエコ","静岡大学リアカー","えこまな＠京田辺","オアシス","ECOFF","日本工業大学学生環境推進委員会","環境部エコロ助","つくば学生農業ヘルパー","農村16きっぷ","GECS","ecocon","環境三四郎","東京都市大学ISO学生委員会","やまなび","たまっこ","えこのわぐま","ecoSMILE","REC","Re-Cover","ソラワタリ","aRc"]
        words_list = pickle.load(f)

        #クラスター分析cosine計算を行うために零ベクトルな削除
        #n=40~800の場合
        # del name_list[17]
        # del words_list[17]
        # del words_list[17]
        # del words_list[17]
        # del words_list[18]
        # del words_list[21]

        #n=40~1500
        words_str = map(str, words_list)
    #tfidfの計算#min_dfはtfの値
    vectorizer = TfidfVectorizer(min_df=3,max_df=1.0,use_idf=True, token_pattern=u'(?u)\\b\\w+\\b')
    vecs = vectorizer.fit_transform(words_str).toarray()
    #print(vecs)
    # print([len(v) for v in vecs])
    #print(vectorizer.vocabulary_)#'単語':頻度順の番号
    voc=vectorizer.vocabulary_
    voc_sorted=sorted(voc.items(),key=lambda x:x[1])
    #print(voc_sorted)
    #print(vectorizer.stop_words_)#パラメータによって外された単語
    np.set_printoptions(threshold=np.inf)#省略の無効
    newvoc=vectorizer.idf_
    #print(newvoc)

    #print(voc_sorted[544:4304])




    #省略なしのベクトルを表示5170*16
    # np.set_printoptions(threshold=np.inf)
    # print(np.round(vecs,3))
    # vecs = vectorizer.fit_transform(words_str)
    #print(type(vecs))
    #print(vecs)
    #print(vecs.shape)
    #print(vecs.toarray())
    index = vecs.argsort(axis=1)[:,::-1]
    feature_names = np.array(vectorizer.get_feature_names())
    feature_words = feature_names[index]
    del vectorizer
    del index
    gc.collect()
    #
    # #クラスタリング
    clusters = KMeans(n_clusters=6,random_state=0).fit_predict(vecs)
    for cls, target in zip(clusters, name_list):
        print (cls, target)

    #計算結果の表示方法
    n = 5  # top何単語取るか
    m = 100  # 何記事サンプルとして抽出するか
    for fwords, target in zip(feature_words[:m,:n], name_list):
        # 各文書ごとにtarget（ラベル）とtop nの重要語を表示
        print(target)
        print(fwords)
    # #次元圧縮可視化t-SNE
    # tsne= TSNE(n_components=2, verbose=1, n_iter=500)
    # tsne_tfidf = tsne.fit_transform(vecs)
    # #DataFrameに格納
    # df_tsne = pd.DataFrame(tsne.embedding_[:, 0],columns = ["x"])
    # df_tsne["y"] = pd.DataFrame(tsne.embedding_[:, 1])
    # df_tsne["name"]= name_list
    # print(df_tsne)
    # with open("dataframe_1118.pkl","wb") as f1:
    #     pickle.dump(df_tsne,f1)
    #
    # #lasso regressor
    # clf_lasso=linear_model.Lasso(alpha=0.0001)
    # clf_lasso.fit(vecs,vecs)
    # print("--ここからlassoでの係数")
    # print(clf_lasso.intercept_)
    # #print(clf_lasso.coef_)
    # print("--ここまでlassoでの係数")
    # #非ゼロ要素の抽出(np２次元行列から)
    #

    #cosによる類似度調査1
    #cs=cosine_similarity(vecs,vecs)
    #print(cs)
    #ウォード法、ユークリッド距離によるクラスター分析
    #z=linkage(vecs,method="ward",metric="enclidean")
    #ウォード法、コサインによるクラスター分析#無限小数だと計算できないので四捨五入
    vecs_int=np.round(vecs,decimals=6)
    #print(vecs_int)
    z=linkage(vecs_int,metric="cosine")
    print(z)

    # # クラスタ分けするしきい値を決める
    threshold = 1.0 * np.max(z[:, 2])
    # #ラベルの設定
    # # 階層型クラスタリングの可視化
    plt.figure(num=None, figsize=(6, 4), dpi=200, facecolor='w', edgecolor='k')
    plt.xticks(rotation=90,size='small')
    dendrogram(z,leaf_font_size=4,leaf_rotation=90,labels=name_list)
    # #, color_threshold=threshold labels=name_list
    plt.title("[30~800]")
    plt.show()
    #
    # # クラスタリング結果の値を取得
    # clustered = fcluster(z, threshold, criterion='distance')
    #
    # # クラスタリング結果を比較
    # print(clustered)
    # print(name_list)


if __name__=='__main__':
    main()
