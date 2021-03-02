<?php
$dsn = "mysql:dbname=***;host=localhost";
$password = '****';
$user = "******";
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tbtest"
  ." ("
  . "id INT AUTO_INCREMENT PRIMARY KEY,"
  . "name char(32),"
  . "comment TEXT"
  .");";
  $stmt = $pdo->query($sql);
$sql ='SHOW TABLES';
  $result = $pdo -> query($sql);
  foreach ($result as $row){
    echo $row[0];
    echo '<br>';
  }
  echo "<hr>";

$sql ='SHOW CREATE TABLE tbtest';
  $result = $pdo -> query($sql);
  foreach ($result as $row){
    echo $row[1];
  }
  echo "<hr>";
if(isset($_POST["normal"])){
$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
  $sql -> bindParam(':name', $name, PDO::PARAM_STR);
  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
  $name = $_POST["name"];
  $comment = $_POST["comment"] ;
  $sql -> execute();
}
//編集
if(isset($_POST["edit"])){
  $id=$_POST["editid"];
    $name=$_POST["editname"];
  $comment = $_POST["editcom"];
  $sql = 'UPDATE tbtest SET comment=:comment WHERE id=:id';
  $stmt = $pdo->prepare($sql);
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}
//削除
if(isset($_POST["del"])){
  $id=$_POST["delid"];
  $sql = 'delete from tbtest where id=:id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}
//表示
  $sql = 'SELECT * FROM tbtest';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';
  echo "<hr>";
  }
  
?>
<!DOCTYPE html>
<html lang = "ja">
  <head>
    <meta charset="UTF-8">

    <title>掲示板</title>
  </head>
    <body>
      <h1>掲示板</h1>
        <form method = "POST" action = "">
          <input type="hidden" name="post">
          名前: <input type = "text" name = "name" placeholder="yout name"><br />
          メッセージ: <input type = "text" name = "comment" placeholder="comment"><br />
          <input type = "submit" name = "normal" value = "send"><br />
        </form>
        <hr>

        <form action="" method="post">
            <input type="hidden" name="post">
          編集したい番号:<input type="text" name="editid" placeholder="edit"><br/>
          名前:<input type="text" name="editname" placeholder="name"><br/>
          メッセージ;<input name="editcom" type="text" placeholder="comment"><br/>
          <input type="submit" name="edit" value="send">
        </form>
        <hr>

        <form method = "POST" action = "">
          <input type="hidden" name="post">
          消去したい番号: <input type = "text" name = "delid" required placeholder="delete"><br />
          <input type = "submit" name = "del" value = "delete"><br />
        </form>
        <hr>
    </body>
    </html>