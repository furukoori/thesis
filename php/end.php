<?php
session_start();
//セッション受け取り
$usernum=$_SESSION[ses_usernum];
$gender=$_SESSION[ses_gender];
$kaihou=$_SESSION[ses_kaihou];
$seizitu=$_SESSION[ses_seizitu];
$gaikou=$_SESSION[ses_gaikou];
$tyouwa=$_SESSION[ses_tyouwa];
$seisinn=$_SESSION[ses_seisinn];
//簡易診断テスト用
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
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=420">
    <title>あなたにぴったり環境ボランティアサークル紹介！</title>
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
      }
      .ques{
        background-color: #dcdcdc;
        margin: 5px;
        padding:10px;
      }
      .under{
        font-size: 120%;
        border-bottom:solid 1px #000000;
      }
      input[type=radio] {
        width: 25px;
        height: 25px;
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
  <p class=bread>準備アンケート ＞ <strong>おわり</strong></p>
  <p>
    <<アンケート送信完了しました。(^-^)>></br></br>
  <div class="ques">
    <strong><?php echo $usernum;?></strong> さん</br></br>
    あなたは <strong><?php echo $result;?>人</strong>ですね。長所を活かして勉強にサークルに頑張ってください！</br></br>
    アンケートへのご協力ありがとうございました。このページを閉じて構いません。
  </div>
  </p>
  <p class="margin"><small>
    ※先ほどのアンケートから計算し、以下の中からあなたに一番近いものが表示されます。
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


</body>
<footer>
  <p><small>&copy; 2019 Kazuki Furukori</small></p>
</footer>
</html>
