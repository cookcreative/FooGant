<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('data/data.db');
      }
   }

   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
    //  echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from items;
EOF;

  $rows = $db->query("SELECT COUNT(*) as count FROM items");
  $row = $rows->fetchArray();
  $count = $row['count'];

  $ret = $db->query("SELECT * from items ORDER BY 'CATEGORY'");

   echo '[';
   $i = 0;
   while($row = $ret->fetchArray()) {
      $buy_date = strtotime($row['BUY_DATE']);
      $exp_date = strtotime($row['EXP_DATE']);
      echo '{';
      echo '"name": "'. $row['ITEM_NAME'] .'",';
      echo '"desc": " '. $row['ID'] .' ",';
      echo '"values": [{"from": "'. $row['BUY_DATE'] .'",';
      echo '"to": "'. $row['EXP_DATE'] .'",';
      echo '"desc": "'. $row['ID'] .'",';
      echo '"label": "'. $row['ITEM_NAME'] .'",';
      echo '"customClass": "'. $row['CATEGORY'] .'",';
      echo '"dataObj": "'. $row['ID'] .'"';
      echo '}]';
      //echo "i = ".$i;
      $i++;
      if ($count == $i){
        echo '}';
      }else{
      echo '},';
      }

   }
   echo ']';
  // echo "Operation done successfully\n";
   $db->close();

// [{
// "name": "  label on left ",
// "desc": "little label on left",
// "values": [{"from": "/Date(1320192000000)/",
//             "to": "/Date(1321401600000)/",
//             "desc": "html tooltip",
//             "label": "label on actual bar",
//             "customClass": "ganttRed"
//           }]
// }]
?>
