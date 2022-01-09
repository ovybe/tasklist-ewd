<?php
require_once('connect.php');
$order = $_POST['order'];
$length = count($order);
for ($i = 0; $i < $length; $i++) {
   $sql = 'UPDATE `tasks` SET `task_order` = '.$i.', task_status = '.$_POST['status'].' WHERE `task_id` = '.$order[$i];
   $result[$i]['sql'] = $sql;
   if ($conn->query($sql) === TRUE) {
      $result[$i]['message'] = "Record updated successfully";

    } else {
      $result[$i]['message'] = "Error updating record: " . $conn->error;
    }
}
//$result = $_POST;
echo json_encode($result);
?>
