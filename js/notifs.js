function showNotifs(){
    console.log("notif clicked");
    if($("#notifdiv").data('fade')=="in"){
        $("#notifdiv").fadeOut(0);
        $("#notifdiv").data('fade','out');
      }
      else{
        $("#notifdiv").fadeIn(0);
        $("#notifdiv").data('fade','in');
      }
}
function showLogout(){
    console.log("notif clicked");
    if($("#userdiv").data('fade')=="in"){
        $("#userdiv").fadeOut(0);
        $("#userdiv").data('fade','out');
      }
      else{
        $("#userdiv").fadeIn(0);
        $("#userdiv").data('fade','in');
      }
}

function inviteAccept(el){
  //userId
  var team_id=$(el).data('id');
  console.log(team_id);
  $.ajax({
        url: "php/acceptInvite.php",
        type: "POST",
        data: {
          user_id: userId,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          //EMPTY USER LIST
          if (dataResult['error']==""){
            //trebuie sa adaug in lista
            //console.log(dataResult);
            location.reload();
            //alert("Got past jquery each...");
          }
          else {
            //if it already exists avoid putting another one
            //console.log(dataResult);
            alert("There was an error accepting the invite.");
          }
        }
      });
}
function inviteRefuse(el){
  //userId
  var team_id=$(el).data('id');
  console.log(team_id);
  $.ajax({
        url: "php/refuseInvite.php",
        type: "POST",
        data: {
          user_id: userId,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          //EMPTY USER LIST
          if (dataResult['error']==""){
            //trebuie sa adaug in lista
            location.reload();
            //alert("Got past jquery each...");
          }
          else {
            //if it already exists avoid putting another one
            alert("There was an error refusing the invite.");
          }
        }
      });
}

function clearNotif(el){
  //userId
  var team_id=$(el).data('id');
  console.log(team_id);
  $.ajax({
        url: "php/clearNotif.php",
        type: "POST",
        data: {
          user_id: userId,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          //EMPTY USER LIST
          if (dataResult['error']==""){
            //trebuie sa adaug in lista
            location.reload();
            //alert("Got past jquery each...");
          }
          else {
            //if it already exists avoid putting another one
            alert("There was an error deleting the notification.");
          }
        }
      });
}
