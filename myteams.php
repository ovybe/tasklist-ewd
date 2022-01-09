      <?php
      $headermore=null;
      include 'header.php';
      include 'notif.php';
      ?>
    <button id="cteam"><i class="fas fa-plus"></i> Create Team</button>
    </div>
  <div class="breadcrumbs"><a class="lnk" href="./index.php">Home</a><a class='ina'>></a><a class='ina'>My Teams</a></div>
    <!-- close topbar -->
    <div class="container">
      <table class='border_table'>
        <thead>
          <tr>
            <th width="80%" align="left">Team</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td>Echipa</td>
            <td>
              <div data-id="1" class="toolbar">
              <div class='toolbar_button'>Invite User</div>
              <div class='toolbar_button'>Edit</div>
              <div class='toolbar_button'>Delete</div>
            </div>
            </td>
          </tr> -->
          <?php
          $sql= 'SELECT * FROM `teams` WHERE t_creator_id='.$user_id;
          $result= mysqli_query($conn,$sql);
          //$team_id_arr=array();
          if(mysqli_num_rows($result)>0){
            //$j=0;
            while($row=mysqli_fetch_assoc($result)){
              //$team_id_arr[$j]=$row['t_id'];
              //$j++;
              ?>
              <tr>
                <td class='namet'><div class="box" style="background-color:<?=$row['t_color']?>"></div><?=$row['t_name']?></td>
                <td>
                  <div data-id="<?=$row['t_id']?>" class="toolbar">
                  <div data-action='invite' class='toolbar_button'><i class="fas fa-user-plus"></i></div>
                  <div data-action='redir' class='toolbar_button'><i class="fas fa-info-circle"></i></div>
                  <div data-action='redircal' class='toolbar_button'><i class="fas fa-calendar-week"></i></div>
                  <div data-action='delete' class='toolbar_button'><i class="fas fa-trash"></i></div>
                </div>
                </td>
              </tr>
               <?php
            }
            $tcheck1=0;
          }
          else{
            $tcheck1=1;
          }
             ?>
             <?php
             $sql= 'SELECT * FROM `teams` t INNER JOIN `t_relations` r ON t.t_id=r.team_id WHERE role="user" AND r.user_id='.$user_id;
             $result= mysqli_query($conn,$sql);
             //echo $sql;
             if(mysqli_num_rows($result)>0){
               while($row=mysqli_fetch_assoc($result)){
                 ?>
                 <tr>
                   <td><div class="box" style="background-color:<?=$row['t_color']?>"></div><?=$row['t_name']?></td>
                   <td>
                     <div data-id="<?=$row['t_id']?>" class="toolbar">
                     <div data-action='invite' class='toolbar_button'><i class="fas fa-user-plus"></i></div>
                     <div data-action='redir' class='toolbar_button'><i class="fas fa-info-circle"></i></div>
                     <div data-action='redircal' class='toolbar_button'><i class="fas fa-calendar-week"></i></div>
                   </div>
                   </td>
                 </tr>
                  <?php
               }
             }
             else{
               if($tcheck1==1){
                 echo "<tr><td>No teams have been found.</td><td></td></tr>";
               }
             }
            ?>
        </tbody>
      </table>
    </div>


      <div id="myModali" class="modal">
        <!-- User invite Modal content -->
        <div class="modali-content">
          <span class="closei">&times;</span>

          <form class="emailform" action="javascript:;" method="post">
           <!-- User list -->
           <p>Users currently in the team:</p>
            <ul id="cuserlist">
              <p id='emp'>No users found.</p></ul>
              <div class="emailtip">
                <label for="email">Email to invite: </label>
                <input id="email" name="email_p" type="text"/>
                <button class="buton" onclick="add_email(this)">Add</button>
                <table id="eTable">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <th>Username</th>
                    </tr>
                  </thead>
                  <tbody>
                </tbody>
                </table>
              </div>
            <button onclick="send_invite(this)" id="#inviteb">Invite Users</button>
          </form>

        </div>

        </div>


        </div>
        </div>
    </div>
    </div>
    <script>
    const userId = '<?php echo $_SESSION["user_id"]; ?>';
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js" integrity="sha256-hlKLmzaRlE8SCJC1Kw8zoUbU8BxA+8kR3gseuKfMjxA=" crossorigin="anonymous"></script>
    <script src="js/notifs.js"></script>
    <script src="js/myteams.js"></script>
  </body>
</html>
