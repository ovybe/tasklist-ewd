<!-- Notification button -->
<?php include 'php/connect.php';
$sql='SELECT * FROM `notifications` where notif_user_to='.$user_id;
$resultn= mysqli_query($conn,$sql);
?>
<div class="notif_padding">
<a class="lnk"><i class="fas fa-user"></i> <?php echo $user;?></a>
<a onclick="showNotifs()" href="#" class="notification">
  <span><i class="fas fa-bell"></i></span>
  <?php if(mysqli_num_rows($resultn)>0)
  { ?>
  <span class="badge"><?=mysqli_num_rows($resultn)?></span>
<?php } ?>
    <?php
    include 'php/connect.php';
    $sql='SELECT * FROM `notifications` where notif_user_to='.$user_id;
    $resultn= mysqli_query($conn,$sql);
     if(mysqli_num_rows($resultn)>0){
       echo '<div id="notifdiv" data-fade="out">';
     }
     else echo '<div id="notifdiv" data-fade="out" class="emptynot">';
    if(mysqli_num_rows($resultn)>0){
      while($rown=mysqli_fetch_assoc($resultn)){
      if($rown['notif_id']==1){
              $sql2='SELECT t_name from `teams` where t_id='.$rown['notif_team_id'];
              $result2=mysqli_query($conn,$sql2);
              $team_row=mysqli_fetch_assoc($result2);
              $sql3='SELECT name from `users` where user_id='.$rown['notif_user_from'];
              $result3=mysqli_query($conn,$sql3);
              $name_row=mysqli_fetch_assoc($result3);
        ?>
        <div class="invite" data-id="1"><label>You got an invite to team <?=$team_row['t_name']?> from <?=$name_row['name']?></label><button data-id="<?=$rown['notif_team_id']?>" class='acceptinvb' onclick="inviteAccept(this)" ><i class="fas fa-check"></i></button><button data-id="<?=$rown['notif_team_id']?>" class="refuseinvb" onclick="inviteRefuse(this)" ><i class="fas fa-minus"></i></button></div>
  <?php
      }
      }
    }
       ?>
  </div>
</a>
<a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>

</div>
