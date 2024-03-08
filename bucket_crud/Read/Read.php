<?php
require_once '../../db_config.php';
$db = database_connection(); 
function get_buckets($db)
{$query = "SELECT * FROM buckets";
  $results = $db->query($query);
 $buckets = [];
    if ($results) {
     while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $buckets[] = $row;
        }
    } else {
        echo "Query Error: " . $db->lastErrorMsg();  } return $buckets;}

    ?>
