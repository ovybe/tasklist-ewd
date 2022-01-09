<div id="notifdiv">
  <?php if(mysqli_num_rows($resultn)>0)
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
      <div data-id="1"><label>You have received an invite to team <?=$team_row['t_name']?> from <?=$name_row['name']?> -> </label><button data-id="<?=$rown['notif_team_id']?>" class='acceptinvb' onclick="inviteAccept(this)" >Accept</button><button data-id="<?=$rown['notif_team_id']?>" class="refuseinvb" onclick="inviteRefuse(this)" >Refuse</button><button data-id="<?=$rown['notif_team_id']?>" class="delnotifb" onclick="clearNotif(this)">Clear</button></div>
<?php
    }
    }
  }
     ?>
</div>
