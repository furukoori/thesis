<?php
session_start();
#表示するやつ
$usernum=''; $gender=''; $grade=''; $major='';
$q1='';$q2='';$q3='';$q4='';$q5='';$q6='';$q7='';$q8='';$q9='';$q10='';
$kaihou='';$seizitu='';$gaikou='';$tyouwa='';$seisinn='';
// defineの値はサーバー環境によって変えてください。
define('HOSTNAME', 'mysql1.php.xdomain.ne.jp');
define('DATABASE', 'furukori_product');
define('USERNAME', 'furukori_kori');
define('PASSWORD', 'KoriGori114');
#何かが投稿された時に使われる
if($_SERVER['REQUEST_METHOD']==='POST'){
  $usernum=$_POST['usernum'];
  $gender=$_POST['gender'];
  $grade=$_POST['grade'];
  $major=$_POST['major'];
  $kikaku=$_POST['kikaku'];
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
  $_SESSION[ses_usernum]=$usernum;
  $_SESSION[ses_gender]=$gender;
  $_SESSION[ses_kaihou]=$kaihou;
  $_SESSION[ses_seizitu]=$seizitu;
  $_SESSION[ses_gaikou]=$gaikou;
  $_SESSION[ses_tyouwa]=$tyouwa;
  $_SESSION[ses_seisinn]=$seisinn;
  try {
    //DBにアクセス
    //$ini = parse_ini_file('./db.ini', FALSE);
    //$pdoはDBに対するインスタンス
    $pdo = new PDO('mysql:host='.HOSTNAME.';dbname='.DATABASE.';charset=utf8', USERNAME, PASSWORD);
    // echo "接続成功\n";
    //DBに書き込み
    $stmt = $pdo->prepare('INSERT INTO question2 (usernum,gender,grade,major,kikaku,kaihou,seizitu,gaikou,tyouwa,seisinn) VALUES(:usernum,:gender,:grade,:major,:kikaku,:kaihou,:seizitu,:gaikou,:tyouwa,:seisinn)');
    $stmt->bindParam(':usernum',$usernum,PDO::PARAM_STR);
    $stmt->bindParam(':gender',$gender,PDO::PARAM_STR);
    $stmt->bindParam(':grade',$grade,PDO::PARAM_INT);
    $stmt->bindParam(':major',$major,PDO::PARAM_STR);
    $stmt->bindParam(':kikaku',$kikaku,PDO::PARAM_STR);
    $stmt->bindParam(':kaihou',$kaihou,PDO::PARAM_INT);
    $stmt->bindParam(':seizitu',$seizitu,PDO::PARAM_INT);
    $stmt->bindParam(':gaikou',$gaikou,PDO::PARAM_INT);
    $stmt->bindParam(':tyouwa',$tyouwa,PDO::PARAM_INT);
    $stmt->bindParam(':seisinn',$seisinn,PDO::PARAM_INT);
    //反映
    $stmt->execute();
    //接続を閉じる
    $pdo=null;
  } catch(PDOException $e) {
    // echo $e->getMessage();
    die();
  }
  header("Location: end.php");
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
  <h2>推薦システム構築用準備アンケート！</h2>
  <p class=bread><strong>準備アンケート</strong> ＞ おわり  </p>
  <!-- actionを空欄にするとこのページのphpに飛んでくる -->
  <form onsubmit="return confirm('次のページに進みますか？');" action="" method="POST">

    <p class="margin">私は早稲田大学人間科学部４年の古郡(ふるこおり)と申します。</br>
    環境ボランティアサークルの推薦システムの開発研究を進めるにあたりアンケートを集めております。</br>
    つきましてはお手数ですが、「全１０問の性格診断アンケート」にご協力いただけますと幸いです。</br>
    なお、今回ご回答いただきました内容については卒業論文でのみ利用し、それ以外の目的で利用することは一切ございませんのでご安心ください。</br></br>
    性格診断の前に、少しだけ個人情報をお伺いします。
    </p>
    <div class="ques">
    <p>性別を選んでください。</p>
    <input type="radio" name="gender" value="m" checked="checked">男
    <input type="radio" name="gender" value="w">女
    <input type="radio" name="gender" value="x">その他</div>
    <div class="ques">
    <p>学年を選んでください。</p>
    <input type="radio" name="grade" value=1 checked="checked">1年
    <input type="radio" name="grade" value=2>2年
    <input type="radio" name="grade" value=3>3年
    <input type="radio" name="grade" value=4>4年
    <input type="radio" name="grade" value=0>その他
    </div>
    <div class="ques">
    <p>大学での専攻を選んでください</p>
    <ul>
    <li>文理融合学部の方は高校時代の専攻を選んでください。</li>
    </ul>
    <input type="radio" name="major" value=rikei checked="checked">理系
    <input type="radio" name="major" value=bunnkei>文系</div>
    <div class="ques">
    <p>所属企画を選んでください</p>
    <ul>
    <li>複数入っている場合は、より上の企画を選んでください。</li>
    <li>例)わぐまとやまなびに入ってる時はやまなびを選択</li>
    <li>例)ecoSMILEとRECに入ってる時はecoSMILEを選択</li>
    </ul>
    <input type="radio" name="kikaku" value=yamanabi checked="checked">やまなび</br>
    <input type="radio" name="kikaku" value=aaku>aRc</br>
    <input type="radio" name="kikaku" value=waguma>えこのわぐま</br>
    <input type="radio" name="kikaku" value=ekosuma>ecoSMILE</br>
    <input type="radio" name="kikaku" value=other>その他</br>
    </div>
    <div class="ques">
    <p>学籍番号を記入してください。例)1j16d194</p>
    <ul>
      <li>重複回答防止のためのみに利用します。</li>
      <li>早大生はCD(ﾁｪｯｸﾃﾞｼﾞｯﾄ)は不要です。</li>
      <li>早大生以外の方はご自身の学校の学籍番号で構いません。</li>
    </ul>
    <input type="text" name="usernum" placeholder="学籍番号" required></br></div>
    <!-- enterキーを押させない -->

    <!-- <input type="text" name="usernum" placeholder="学籍番号" value="<?php echo htmlspecialchars($usernum,ENT_QUOTES,'UTF-8');?>"></br></div> -->
    <!-- ユーザに入力してもらったデータは直書きNGなのでおまじない
    悪意のある行動をエスケープ -->

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
  <p><small>&copy; 2019 Kazuki Furukori</small></p>
</footer>
</html>
