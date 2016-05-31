<DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8">
 <title>todolist</title>
</head>

<body>
  <?php
 try{
  $dsn = 'mysql:dbname=todolist;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $dbh = new PDO($dsn, $user);
  $dbh->query('SET NAMES utf8');
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false)
  if(isset($_GET['add'])) {
    $item = $_GET['item'];
    $item = htmlspecialchars($item, ENT_QUOTES);
    $error = "";
    if($item === "") {
      $error = "メモが入力されていません。";
    } else{
      $sql = 'INSERT INTO　list (item) VALUES (:item)';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':item', $item);
      $stmt->execute();
    }
    unset($item);
  } else if(isset($_GET['delete'])) {
    $sql = 'DELETE FROM list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $_GET['name'];
    $stmt->execute($data);

    $dbh = null;
  }
  $sql = 'SELECT item FROM list';
  $stmt = $dbh->prepare($sql);
  $stmt-> execute();

  $dbh = null;
  ?>
<form method = "get" action = "index.php">
<input type="text" name = "name" style="width:200px">
<input type="submit" value="add"><br />
</form>

<form method = "get" action = "project_delete">
<?php
while(true) {
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if($rec==false){
    break;
  }
  print $rec['item'];
  ?>
  <input type="submit" value="delete" name="$rec['id']" style="background:url('submit_delete.jpg')" />
  <?php
  print '</br>';
}
} catch(Exception $e) {
 print'エラー';
 exit();
}
  ?>
</body>

</html>
