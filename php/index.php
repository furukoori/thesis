<?php
session_start();
#表示するやつ
$gender='';
$q1='';$q2='';$q3='';$q4='';$q5='';$q6='';$q7='';$q8='';$q9='';$q10='';
$kaihou='';$seizitu='';$gaikou='';$tyouwa='';$seisinn='';
#何かが投稿された時に使われる
if($_SERVER['REQUEST_METHOD']==='POST'){
  $gender=$_POST['gender'];
  $q1=$_POST['q1'];
  $q2=$_POST['q2'];
  $q3=$_POST['q3'];
  $q4=$_POST['q4'];
  $q5=$_POST['q5'];
  $q6=$_POST['q6'];
  $q7=$_POST['q7'];
  $q8=$_POST['q8'];
  $q9=$_POST['q9'];
  $q10=$_POST['q10'];
  $kaihou= 8 - $q10 + $q5;//解放性
  $seizitu= 8 - $q8 + $q3;//誠実性
  $gaikou= 8 - $q6 + $q1;//外向性
  $tyouwa= 8 - $q2 + $q7;//調和性
  $seisinn= 8 - $q9 + $q4;//精神症的傾向
  //セッション保存
  $_SESSION[ses_gender]=$gender;
  $_SESSION[ses_kaihou]=$kaihou;
  $_SESSION[ses_seizitu]=$seizitu;
  $_SESSION[ses_gaikou]=$gaikou;
  $_SESSION[ses_tyouwa]=$tyouwa;
  $_SESSION[ses_seisinn]=$seisinn;

  header("Location: result.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=420">
    <title>環境ボランティアサークル紹介</title>
    <style>
      body{
        padding:5px;
      }
      h2{
        background-color: #dcdcdc;
        padding: 10px;
        border: solid 3px #000000;
      }
      .bread{
        color: #dcdcdc;
      }
      strong{
        color: #000000;
      }
      .margin{
        margin-top:40px;
        line-height: 180%;
      }
      .ques{
        background-color: #dcdcdc;
        margin: 10px;
      }
      .under{
        font-size: 120%;
        border-bottom:solid 1px #000000;
      }
      .num{
        font-size: 120%;
      }
      input[type=radio] {
        width: 25px;
        height: 25px;
      }
      input[type=text] {
        height: 40px;
      }
      input#submit{
        width: 50px;
        height: 40px;
        color: #ffffff;
        font-size: 120%;
        border-radius: 10px;
        background-color: #0000ff;
      }
      input#submit:hover{
        background-color: #1e90ff;
      }

      footer{
        margin-top:20px;
      }
    </style>

</head>
<body>
  <h2>環境ボランティアサークル推薦システム！</h2>
  <p class=bread><strong>性格診断アンケート</strong> ＞ オススメ団体紹介 </p>
  <!-- actionを空欄にするとこのページのphpに飛んでくる -->
  <form action="" method="POST">

    <p class="margin">
      本サイトではあなたの性格にマッチした環境ボランティアサークルを紹介します！</br>
      あなたの性格を調べるため「性別」「全１０問の性格診断アンケート」の回答をお願いします！</br>
    </p>
    <p class="margin">まず、性別をお伺いします。</br></p>
    <div class="ques">
    <p>性別を選んでください。</p>
    <input type="radio" name="gender" value="m" checked="checked">男
    <input type="radio" name="gender" value="w">女
    <input type="radio" name="gender" value="x">その他</div>

    <p class="margin">
      以下より性格診断アンケート開始です。</br></br>
      <strong>あなたの性格は、各設問にどれくらい当てはまりますか？</strong>
    </p>

    <div class="ques">
    <p class="under">Q1. 外交的・情熱的</p>
    <input type="radio" name="q1" value=7>完全に当てはまる</br>
    <input type="radio" name="q1" value=6>だいたい当てはまる</br>
    <input type="radio" name="q1" value=5>少し当てはまる</br>
    <input type="radio" name="q1" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q1" value=3>あまり当てはまらない</br>
    <input type="radio" name="q1" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q1" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q2. 批判的・口喧嘩しやすい</p>
    <input type="radio" name="q2" value=7>完全に当てはまる</br>
    <input type="radio" name="q2" value=6>だいたい当てはまる</br>
    <input type="radio" name="q2" value=5>少し当てはまる</br>
    <input type="radio" name="q2" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q2" value=3>あまり当てはまらない</br>
    <input type="radio" name="q2" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q2" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q3. 自己コントロール能力が高い・頼り甲斐がある</p>
    <input type="radio" name="q3" value=7>完全に当てはまる</br>
    <input type="radio" name="q3" value=6>だいたい当てはまる</br>
    <input type="radio" name="q3" value=5>少し当てはまる</br>
    <input type="radio" name="q3" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q3" value=3>あまり当てはまらない</br>
    <input type="radio" name="q3" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q3" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q4. 心配性・動揺しやすい</p>
    <input type="radio" name="q4" value=7>完全に当てはまる</br>
    <input type="radio" name="q4" value=6>だいたい当てはまる</br>
    <input type="radio" name="q4" value=5>少し当てはまる</br>
    <input type="radio" name="q4" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q4" value=3>あまり当てはまらない</br>
    <input type="radio" name="q4" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q4" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q5. 新しい経験や複雑な物事に対してオープンである</p>
    <input type="radio" name="q5" value=7>完全に当てはまる</br>
    <input type="radio" name="q5" value=6>だいたい当てはまる</br>
    <input type="radio" name="q5" value=5>少し当てはまる</br>
    <input type="radio" name="q5" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q5" value=3>あまり当てはまらない</br>
    <input type="radio" name="q5" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q5" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q6. あまり自分の主張をしない・無口である</p>
    <input type="radio" name="q6" value=7>完全に当てはまる</br>
    <input type="radio" name="q6" value=6>だいたい当てはまる</br>
    <input type="radio" name="q6" value=5>少し当てはまる</br>
    <input type="radio" name="q6" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q6" value=3>あまり当てはまらない</br>
    <input type="radio" name="q6" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q6" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q7. 共感能力が高い・優しい</p>
    <input type="radio" name="q7" value=7>完全に当てはまる</br>
    <input type="radio" name="q7" value=6>だいたい当てはまる</br>
    <input type="radio" name="q7" value=5>少し当てはまる</br>
    <input type="radio" name="q7" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q7" value=3>あまり当てはまらない</br>
    <input type="radio" name="q7" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q7" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q8. 物事にこだわらない・ぶっきらぼうである</p>
    <input type="radio" name="q8" value=7>完全に当てはまる</br>
    <input type="radio" name="q8" value=6>だいたい当てはまる</br>
    <input type="radio" name="q8" value=5>少し当てはまる</br>
    <input type="radio" name="q8" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q8" value=3>あまり当てはまらない</br>
    <input type="radio" name="q8" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q8" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q9. 温厚・感情が安定している</p>
    <input type="radio" name="q9" value=7>完全に当てはまる</br>
    <input type="radio" name="q9" value=6>だいたい当てはまる</br>
    <input type="radio" name="q9" value=5>少し当てはまる</br>
    <input type="radio" name="q9" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q9" value=3>あまり当てはまらない</br>
    <input type="radio" name="q9" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q9" value=1>全く当てはまらない</br>
    </br></div>

    <div class="ques">
    <p class="under">Q10.形式にこだわる・創造性が低い</p>
    <input type="radio" name="q10" value=7>完全に当てはまる</br>
    <input type="radio" name="q10" value=6>だいたい当てはまる</br>
    <input type="radio" name="q10" value=5>少し当てはまる</br>
    <input type="radio" name="q10" value=4 checked="checked">どちらともいえない</br>
    <input type="radio" name="q10" value=3>あまり当てはまらない</br>
    <input type="radio" name="q10" value=2>ほとんど当てはまらない</br>
    <input type="radio" name="q10" value=1>全く当てはまらない</br>
    </br></div>

    <input id="submit" type="submit" value="次へ">

    </form>

</body>
<footer>
  <p><small>本サイトは早稲田大学人間科学部４年、古郡(ふるこおり)の研究「協調フィルタリングによる環境ボランティアサークル推薦」の成果物です。</small></p>
  <p><small>&copy; 2019 Kazuki Furukori</small></p>
</footer>
</html>
