<?php

//FooGantt
//
//Simple app to track food best before dates
//
//Developer: James Cook
class MyDB extends SQLite3 {
  function __construct() {
     $this->open('data/data.db');
  }
}

$db = new MyDB();
if(!$db) {
      die($db->lastErrorMsg());
   } else {
      echo "<!-- Opened database successfully -->";
   }



// $sql =<<<EOF
//       CREATE TABLE items
//       (ID INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
//       ITEM_NAME TEXT  NOT NULL,
//       BUY_DATE DATE NOT NULL,
//       EXP_DATE DATE NOT NULL);
// EOF;
//
//    $ret = $db->exec($sql);
//    if(!$ret){
//       echo $db->lastErrorMsg();
//    } else {
//       echo "Table created successfully\n";
//    }
//    $db->close();

// $sql =<<<EOF
//       INSERT INTO items (ID,ITEM_NAME,BUY_DATE,EXP_DATE)
//       VALUES (NULL, 'Milk', '2020-02-01', '2020-02-10');
// EOF;
//
//    $ret = $db->exec($sql);
//    if(!$ret) {
//       echo $db->lastErrorMsg();
//    } else {
//       echo "Records created successfully\n";
//    }
//    $db->close();

// $sql = "ALTER TABLE items ADD 'CATEGORY' TEXT;";
// if($db->query($sql) ){
//   echo"Column added.";
// }else{
//   echo"Error!";
// }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

if ($_POST["form-id"] == "addform"){
  $itemname = test_input($_POST["item-name"]);
  $date = $_POST['date'];
  $now = date('Y-m-d',strtotime("now"));
  $category = test_input($_POST['category']);
  $q = "INSERT INTO items (ID,ITEM_NAME,BUY_DATE,EXP_DATE,CATEGORY) VALUES (NULL, '$itemname', '$now', '$date','$category');";
  if($db->query($q) ){
    echo"Added.";
  }else{
    echo"Error!";
  }
}

if ($_POST["form-id"] == "deleteform"){
  $id = intval($_POST['item-number']);
  $q = "DELETE FROM items WHERE ID = '$id'";
  if($db->query($q) ){
    echo"Deleted.";
  }else{
    echo"Error!";
  }
}

}



?>
