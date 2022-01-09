<?php
include 'connect.php';
session_start();
$user_id=$_POST['user_from'];
$notif_team_id=$_POST['team_id'];
$notif_id=1;
if(array_key_exists('user_to',$_POST)){
  $notif_user_to=$_POST['user_to'];
}
else {
  $notif_user_to=array();
}
$notif_datetime=date('Y-m-d H:m:s', time());
//echo $notif_datetime;
$result=array();
$arrlen=count($notif_user_to);
$okinsert=0;
$okhappened=0;
for($i=0;$i<$arrlen;$i++){
    $sql='INSERT INTO `notifications`(`notif_id`, `notif_user_to`,`notif_user_from`,`notif_team_id`,`notif_datetime`) VALUES ('.$notif_id.','.$notif_user_to[$i].','.$user_id.','.$notif_team_id.',"'.$notif_datetime.'")';
    $query=mysqli_query($conn,$sql);
        //echo $sql;
    if ($query) {
      $result[$i]='';
      $okhappened=1;
    }
    else
    {
      $result[$i]="Could not insert result";
      $okinsert=1;
    }
    }
    if($okinsert==1)
    {
      $result['error']='One of the inserts failed';
    }
    if($okhappened==0)
    {
      $result['error2']='Inserts not happened';
    }
//header("Location: ../index.php");
echo json_encode($result);
die();
 ?>
