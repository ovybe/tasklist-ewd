<?php
include 'connect.php';
session_start();
$user_id=$_POST['user_from'];
$t_name=$_POST['t_name'];
$t_color=$_POST['t_color'];
$notif_id=$_POST['id'];
if(array_key_exists('user_to',$_POST)){
  $notif_user_to=$_POST['user_to'];
}
else $notif_user_to=array();
$notif_datetime=date('Y-m-d H:m:s', time());
//echo $notif_datetime;
$sql='SELECT * FROM `teams` WHERE `t_name`="'.$t_name.'"';
if(mysqli_num_rows($rowf=mysqli_query($conn,$sql))>0)
  {
    //echo "error happened";
    $rescheck['error']="Name already exists";
    $rescheck['result']=mysqli_fetch_assoc($rowf);
    echo json_encode($rescheck);
    die();
  }
$sql='INSERT INTO `teams`(`t_name`,`t_creator_id`,`t_color`) VALUES ("'.$t_name.'","'.$user_id.'","'.$t_color.'")';
//print_r($sql);
$result=array();
$result2=array();
$result3=array();
$result4=array();
//$query=mysqli_query($conn,$sql);
if (mysqli_query($conn,$sql)) {
    $_SESSION['treg']=1;
    $_SESSION['seen']=0;
    $sql='SELECT max(`t_id`) as MAX_ID FROM `teams` WHERE `t_creator_id`='.$user_id;

    // get ID
    if($result=mysqli_query($conn,$sql)){
      $result2=mysqli_fetch_assoc($result);
    }
    else{
      $result2['error']='Could not fetch team id';
    }

    $sql='INSERT INTO `t_relations`(`user_id`,`role`,`team_id`) VALUES ("'.$user_id.'","admin",'.$result2['MAX_ID'].')';
    //INSERT admin
    if(mysqli_query($conn,$sql)){
      $result3['error']='';
      $team_id=$result2['MAX_ID'];
      //header("Location: ./newnotifteamsform.php");
    }
    else {
      $result3['error']='Could not set user to admin!';
    }
    $arrlen=count($notif_user_to);
    $ok=0;
    for($i=0;$i<$arrlen;$i++){
      $sql='INSERT INTO `notifications`(`notif_id`, `notif_user_to`,`notif_user_from`,`notif_team_id`,`notif_datetime`) VALUES ('.$notif_id.','.$notif_user_to[$i].','.$user_id.','.$result2["MAX_ID"].',"'.$notif_datetime.'")';
      $query=mysqli_query($conn,$sql);
        //echo $sql;
        if ($query) {
             $result4[$i]='';
         }
         else
         {
             $result4[$i]="Could not insert result";
             $ok=1;
          }
    }
    if($ok==1)
    $result4['error']='happened';
	}
	else {
		$result['error']="Team insert failed.";
	}
$resultf=array();
$resultf['result1']=$result;
$resultf['result2']=$result2;
$resultf['result3']=$result3;
$resultf['result4']=$result4;
/*if (mysqli_num_rows($result)==0){
  echo '<p>Error! There is something wrong with your username or password.</p>';
}
else{
$_SESSION['user_id']=$result['user_id'];
}*/
//header("Location: ../index.php");
echo json_encode($resultf);
die();
 ?>
