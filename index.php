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
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);




  if(isset($_GET['add'])) {

    $sql = 'INSERT INTO list(item) VALUES(?)';
    $stmt = $dbh->prepare($sql);
    $data[] = $_GET['name'];
    $stmt-> execute($data);

  } else if(isset($_GET['delete'])) {
    $sql = 'DELETE FROM list WHERE id=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $_GET['id'];
    $stmt->execute($data);

  }
  $sql = 'SELECT id, item FROM list';
  $stmt = $dbh->prepare($sql);
  $stmt-> execute();

  ?>
<form method = "get" action = "index.php">
<input type="text" name = "name" style="width:200px">
<input type="submit" name = "add" value="add"><br />
</form>

<?php
while(true) {
  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
  if($rec==false){
    $dbh = null;
    break;
  }
  ?>
  <form method = "get" action = "index.php">
  <?php print $rec['item']; ?>
  <input type ="hidden" name="id" value="<?php print $rec['id'] ?>" >
  <input type="submit"  name="delete"  value="delete">
  <?php print '</br>'; ?>
</form>

<?php }
} catch(Exception $e) {
 print'エラー';
 exit();
} ?>
</body>

</html>
