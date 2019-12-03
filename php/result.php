<?php
session_start();
//セッション受け取り
$gender=$_SESSION[ses_gender];
$kaihou=$_SESSION[ses_kaihou];
$seizitu=$_SESSION[ses_seizitu];
$gaikou=$_SESSION[ses_gaikou];
$tyouwa=$_SESSION[ses_tyouwa];
$seisinn=$_SESSION[ses_seisinn];
$user=[$gender,$kaihou,$seizitu,$gaikou,$tyouwa,$seisinn];
$match_kikaku='';
// defineの値はサーバー環境によって変えてください。
define('HOSTNAME', 'mysql1.php.xdomain.ne.jp');
define('DATABASE', 'furukori_product');
define('USERNAME', 'furukori_kori');
define('PASSWORD', 'KoriGori114');

//簡易診断テスト用アルゴリズム
if($gender=="m"){//男性
  //kaihou,seizitu,gaikou,tyouwa,seisinn
  $ave=[10.7, 10.4, 8.5, 10.1, 5.7];
}elseif($gender=="w"){//女性
  $ave=[10.8, 11.0, 9.1, 10.6, 6.7];
}elseif($gender=="x"){//どちらでもない
  $ave=[10.75, 10.7, 8.8, 10.35, 6.2];
}
//平均との差。+なら平均より高い。-なら低い。
$a=($kaihou-$ave[0]);$aa=$a**2;
$b=($seizitu-$ave[1]);$bb=$b**2;
$c=($gaikou-$ave[2]);$cc=$c**2;
$d=($tyouwa-$ave[3]);$dd=$d**2;
$e=($seisinn-$ave[4]);$ee=$e**2;
//ソート//二次元配列
$sort=[
  ['Name'=>'kaihou','wScore'=>$aa,'Score'=>$a],
  ['Name'=>'seizitu','wScore'=>$bb,'Score'=>$b],
  ['Name'=>'gaikou','wScore'=>$cc,'Score'=>$c],
  ['Name'=>'tyouwa','wScore'=>$dd,'Score'=>$d],
  ['Name'=>'seisinn','wScore'=>$ee,'Score'=>$e]
];
//比較する要素を指定
foreach ($sort as $key => $value) {
  $sort_keys[$key]=$value['wScore'];
}
//２乗の値で降順//平均との差が一番大きいのを取得
array_multisort($sort_keys,SORT_DESC,$sort);
//一番高い要素とその値
$big_name=$sort[0]['Name'];
$big_score=$sort[0]['Score'];
//どの値が特徴的？
switch($big_name){
  case 'kaihou':
    $type=0;
    break;
  case 'seizitu':
    $type=1;
    break;
  case 'gaikou':
    $type=2;
    break;
  case 'tyouwa':
    $type=3;
    break;
  case 'seisinn':
    $type=4;
    break;
}
//値が+-どっち？
if($big_score>=0){
  $sign=0;
}elseif($big_score<0){
  $sign=1;
}
$text=[//['高い,低い']
  ['創造性が高い','規律をしっかり守る'],
  ['コツコツ仕事をする','リスクを取れる'],
  ['人間関係構築が得意な','集中力が高い'],
  ['チームワークが得意な','リーダー・アーティスト気質な'],
  ['繊細な','メンタルが強い']
];
$result=$text[$type][$sign];

//データベースから参照(テーブルはquestion2)
try {
  //$pdoはDBに対するインスタンス
  $pdo = new PDO('mysql:host='.HOSTNAME.';dbname='.DATABASE.';charset=utf8', USERNAME, PASSWORD);
  //実行するクエリの作成(question2テーブルの全データを取得)
  $query = "SELECT * FROM question2";
  //クエリ実行
  $query_res = $pdo->query($query);
  //取得データを全てフェッチ
  $data=$query_res->fetchAll();
  //確認
  //var_dump($data);
  //配列の確認表示
  // foreach($data as $value){
  //   echo $value["usernum"];
  //   echo $value["gender"];
  //   echo $value["grade"];
  //   echo $value["seisinn"];
  // }
  //question2テーブルのデータとどれが近いか
  // echo "あなたのbig5は ";
  // for($i=0;$i<=6;$i++){
  //   echo $user[$i]," ";
  // }
  $min=1000;
  //$match_kikaku='';//静的保存したいのでtryの外にかく
  foreach($data as $value){
    $ax=($kaihou-$value["kaihou"])**2;
    $bx=($seizitu-$value["seizitu"])**2;
    $cx=($gaikou-$value["gaikou"])**2;
    $dx=($tyouwa-$value["tyouwa"])**2;
    $ex=($seisinn-$value["seisinn"])**2;
    $sum=$ax+$bx+$cx+$dx+$ex;
    if($sum<$min){
      if($value["kikaku"]!=="other"){//その他は協調に含めない
        //ax~exのうち一番距離の近い人の値とその企画を保存
        $min=$sum;
        $match_kikaku=$value["kikaku"];
      }
    }
  }
  //echo "あなたにオススメの団体は",$match_kikaku;

  //参照の接続を閉じる
  $pdo=null;
} catch(PDOException $e) {
  var_dump($e);
  die();
}
//テスト用
//$match_kikaku="ekosuma";
//csvに書いたサークルとのマッチングアルゴリズム
//サークル情報を書き込んだcsvの読み込み
//csvが長すぎるとエラーになる
$csv=[];
if(($handle=fopen("circle.csv","r"))!==FALSE){
  while(($cir_dt=fgetcsv($handle,1000,","))!==FALSE){
    $csv[]=$cir_dt;
  }
  fclose($handle);
}
if($match_kikaku=="yamanabi"){
  //１か２
  $index=mt_rand(1,2);
}elseif ($match_kikaku=="aaku"||$match_kikaku=="waguma") {
  //３か４
  $index=mt_rand(3,4);
}elseif ($match_kikaku=="ekosuma") {
  //5か6
  $index=mt_rand(5,6);
}

//データベースへ保存(テーブルはquestion3)
$osusume=$match_kikaku;
try {
  //$pdoはDBに対するインスタンス
  $pdo = new PDO('mysql:host='.HOSTNAME.';dbname='.DATABASE.';charset=utf8', USERNAME, PASSWORD);

  //DBに書き込み
  $stmt = $pdo->prepare('INSERT INTO question3 (gender,kaihou,seizitu,gaikou,tyouwa,seisinn,osusume) VALUES(:gender,:kaihou,:seizitu,:gaikou,:tyouwa,:seisinn,:osusume)');
  $stmt->bindParam(':gender',$gender,PDO::PARAM_STR);
  $stmt->bindParam(':kaihou',$kaihou,PDO::PARAM_INT);
  $stmt->bindParam(':seizitu',$seizitu,PDO::PARAM_INT);
  $stmt->bindParam(':gaikou',$gaikou,PDO::PARAM_INT);
  $stmt->bindParam(':tyouwa',$tyouwa,PDO::PARAM_INT);
  $stmt->bindParam(':seisinn',$seisinn,PDO::PARAM_INT);
  $stmt->bindParam(':osusume',$osusume,PDO::PARAM_STR);

  //反映
  $stmt->execute();
  //接続を閉じる
  $pdo=null;
} catch(PDOException $e) {
  // echo $e->getMessage();
  die();
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
        margin: 20px 10px;
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
  <p class=bread>性格診断アンケート ＞ <strong>オススメ団体紹介</strong> </p>
  <p class="margin">
    診断完了しました！</br>読み終わりましたら、このページを閉じて構いません。</br>
  </p>
  <div class="ques">
    【あなたの性格】</br>
    あなたは <strong><?php echo $result;?>人</strong>です。</br></br>
    【あなたへのオススメサークル】</br>
    <a>[団体名]　<strong><?php echo $csv[$index][0];?></strong></a></br>
    <a>[所　属]　<?php echo $csv[$index][1];?></a></br>
    <a>[所在地]　<?php echo $csv[$index][2];?></a></br>
    <?php $rink=$csv[$index][3];?>
    <!-- エスケープ\が必要なので注意 -->
    <a>[リンク]　<?php echo "<a href=\"$rink\" target=\"_blank\">".$rink.'</a>';?></a></br>
    <a>[概　要]　</br><?php echo "　".$csv[$index][4];?></a></br>
  </div>
  <p class="margin"><small>
    ※先ほどのアンケートから計算し、【あなたの性格】には以下の中からあなたに一番近いものが表示されます。
    <ul>
      <li>創造性が高い人</li>
      <li>規律をしっかり守る人</li>
      <li>コツコツ仕事をする人</li>
      <li>リスクを取れる人</li>
      <li>人間関係構築が得意な人</li>
      <li>集中力が高い人</li>
      <li>チームワークが得意な人</li>
      <li>リーダー・アーティスト気質な人</li>
      <li>繊細な人</li>
      <li>メンタルが強い人</li>
    </ul></small>
  </p>
  <p class="margin"><small>
    ※先ほどのアンケートから計算し、【あなたへのオススメサークル】には以下の中からあなたに一番近いものが表示されます。
    <ul>
      <li><a href="https://www.rodorigues.com/dream-connection-kikaku" target="_blank">aRC(早稲田大学)</a></li>
      <li><a href="https://envecosmile.wixsite.com/rodoecosmile" target="_blank">ecoSMILE(早稲田大学)</a></li>
      <li><a href="https://www.rodorigues.com/ekonowaguma-kikaku" target="_blank">えこのわぐま(早稲田大学)</a></li>
      <li><a href="http://www.ecomanakyotanabe.com" target="_blank">えこまな＠京田辺(同志社大学)</a></li>
      <li><a href="http://moriwaseda.wixsite.com/morinokai" target="_blank">思惟の森の会(早稲田大学)</a></li>
      <li><a href="https://www.rodorigues.com/yamanabi-kikaku" target="_blank">やまなび(早稲田大学)</a></li>
    </ul></small>
  </p>
</body>
<footer>
  <p><small>本サイトは早稲田大学人間科学部４年、古郡(ふるこおり)の研究「協調フィルタリングによる環境ボランティアサークル推薦」の成果物です。</small></p>
  <p><small>&copy; 2019 Kazuki Furukori</small></p>
</footer>
</html>
