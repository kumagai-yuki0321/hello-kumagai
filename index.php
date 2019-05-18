?php

function h($s){
  return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['name']) &&
    isset($_POST['comment'])) {

$dataFile = 'data.csv';

 $name = $_POST['name'];
 $comment = $_POST['comment'];

if($comment !==''){

  $name = ($name === '') ? '名無しさん': $name;

  $postedAt = date('Y-m-d H:i:s');

  $newData = $name . "\t" . $comment . "\t" . $postedAt. "\n";

  $fp = fopen($dataFile, 'a');
     fwrite($fp, $newData);
     fclose($fp);
  }
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

$posts = array_reverse($posts);

 ?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="keijiban.css" rel="stylesheet" type="text/css">
<title>増税について</title>
</head>
<body>

<h1>令和時代の増税について</h1>
<p>～日本と他国との消費税に対してあなたの意見をお聞かせください～</p>
<section>
    <h2 class="iken">あなたの意見をお聞かせ下さい</h2>
    <form action="" method="post">
        <div class="name"><span class="label">お名前:</span>
          <input type="text" name="name" value="" placeholder="例:プログラマー　太郎">
        </div>
        <br>
        <div class="honbun"><span class="label">メッセージを書き込む:</span>
          <textarea name="comment" cols="35" rows="3" maxlength="80" wrap="hard"
               placeholder="80字以内で入力してください。">
          </textarea>
        </div><br>
        <input class="box" type="submit" value="投稿">
    </form>
</section>
<section class="toukou">
    <h2>※令和時代を生き抜く皆さんの意見は (<?php echo count($posts); ?>件)</h2>
     <ul>
       <?php if (count($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
            <?php list($name, $comment, $postedAt) = explode("\t", $post); ?>
                <li><?php echo h($name); ?> (<?php echo h($comment); ?>) - <?php echo h($postedAt); ?></li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>まだ投稿はありません。</li>
        <?php endif; ?>
     </ul>
</section>
</body>
</html>
