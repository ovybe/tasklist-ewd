$(".main").css("padding-top","4vh");
// Get the modal

var modali = document.getElementById("myModali");
var modalt = document.getElementById("myModalt");

// Get the button that opens the modal
var btn = document.getElementById("modalbutt");
var btni = document.getElementById("modalbutti");

// Get the <span> element that closes the modal
var spani = document.getElementsByClassName("closei")[0];

//Current element
var currEl;

//email id array for invites
let email_id_arr=new Array();
let user_id_arr=new Array();

// When the user selects the team, show info.
function showTeamInfo(el){
  //console.log($(currEl).parent());
  var team_id=$(el).data('id');
  var team_name=$(el).find("label").html();
  $("#tnp").html(team_name);
    $("#tinfo").css("display","none");
   $("#tmenuinfo").css("display","block");
   $("#invitebmenu").remove();
   $("#tmenuinfo").append('<button onclick="inviteUsers(this)" data-id="'+$(el).data('id')+'" id="invitebmenu">Invite Users</button>')
   if($("#tmenuinfo").find("#editb")){
       $("#editb").remove();
       $("#delb").remove();
   }
   if($("#teamlistc").find($(el))){
     $("#tmenuinfo").append('<button class="modalbutt" data-id="'+$(el).data('id')+'" id="editb" onclick="editTeam(this)">Edit</button>')
     $("#tmenuinfo").append('<button onclick="deleteTeam(this)" data-id="'+$(el).data('id')+'" id="delb" class="delbutt">Delete</button>')
   }
   else{
     if($("#tmenuinfo").find("#editb")){
       $("#editb").remove();
       $("#delb").remove();
     }
   }
   //GET userlist
   $.ajax({
         url: "php/tgetuserlist.php",
         type: "POST",
         data: {
           team_id: team_id,
         },
         cache: false,
         success: function(dataResult){
           var dataResult = JSON.parse(dataResult);
           //EMPTY USER LIST
           $("#iuserlist").empty();
           if (!dataResult.hasOwnProperty('empty')){
             //trebuie sa adaug in lista
             $.each(dataResult,function(key,val){
               var insertedelem='<li data-id="'+val[0]+'" value="'+val[1]+'"><label>'+val[1]+'</label></li>';
               //console.log(insertedelem);
               $("#iuserlist").append(insertedelem);
             });
             //alert("Got past jquery each...");
           }
           else {
             //if it already exists avoid putting another one
             if(!$("#iuserlist").find("#emp").length){
                 $("#iuserlist").append("<p id='emp'>No users found.</p>"); // TBC
                 //console.log(dataResult);
                 }else{
                 $("#emp").css("display","inline");
               }
           }
         }
       });
}
// When the user clicks on the button, open the modal
function editTeam(el){
currEl=el;
//console.log($(currEl).parent());
var team_id=$(el).parent().data('id');
var team_name=$(el).parent().parent().parent().find('.namet').html();
console.log(team_id);
//console.log($(el).parent());
//console.log(team_id);
//console.log(team_name);
// GET userlist
$.ajax({
      url: "php/tgetuserlist.php",
      type: "POST",
      data: {
        team_name: team_name,
        team_id: team_id,
      },
      cache: false,
      success: function(dataResult){
        var dataResult = JSON.parse(dataResult);
        //EMPTY USER LIST
        $("#cuserlist").empty();
        if (!dataResult.hasOwnProperty('empty')){
          //trebuie sa adaug in lista
          $.each(dataResult,function(key,val){
            var insertedelem='<li data-id="'+val[0]+'" value="'+val[1]+'"><label>'+val[1]+'</label><button onclick="deleteUser(this)" class="delbuttuser">Delete</button></li>';
            console.log(insertedelem);
            $("#cuserlist").append(insertedelem);
          });
          //alert("Got past jquery each...");
        }
        else {
          //if it already exists avoid putting another one
          if(!$("#cuserlist").find("#emp").length){
              $("#cuserlist").append("<p id='emp'>No users found.</p>"); // TBC
              //console.log(dataResult);
              }else{
              $("#emp").css("display","inline");
            }
        }
      }
    });
$(".teamform").data('id',team_id);
 modal.style.display = "block";
 $("#tname").val(team_name);
 $("#tname").data('id',team_id);
//console.log($("#tname").data('id'));
}


// When the user clicks on the save button, close the modal, save Team Info
// function saveTeamInfo(currEl,team_id){
// var team_name=$("#tname").val();
// //console.log(team_name);
// //console.log(team_id);
// //console.log($(currEl).parent().val())
// $.ajax({
//       url: "php/editteam.php",
//       type: "POST",
//       data: {
//         team_name: team_name,
//         team_id: team_id,
//       },
//       cache: false,
//       success: function(dataResult){
//         var dataResult = JSON.parse(dataResult);
//         if (dataResult.error==''){
//           //trebuie sa adaug in lista
//           $(currEl).html(team_name);
//           $(modal).fadeOut(0);
//         }
//         else {
//           alert("There has been an error..."); // TBC
//         }
//       }
//     });
// }
// When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   $("#cuserlist").empty();
//   modal.style.display = "none";
// }
// spani.onclick = function() {
//   $("#cuserlist").empty();
//   modali.style.display = "none";
// }

// When the user clicks anywhere outside of the modal/team, close it
// window.onclick = function(event) {
//   if (event.target == modal) {
//     $("#cuserlist").empty();
//     modal.style.display = "none";
//   }
// }
window.onclick = function(event) {
  if (event.target == modali) {
    $("#cuserlist").empty();
    modali.style.display = "none";
  }
}

// When the user clicks the delete button next to the label, delete team

function deleteTeam(el){
  //var currEl=el;
  var parentEl=$(el).parent().parent().parent();
  //console.log(currEl);
  var team_id=$(el).parent().data('id');
  $.ajax({
        url: "php/deleteteam.php",
        type: "POST",
        data: {
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.errordel1==''){
            //trebuie sa adaug in lista
            if(dataResult.errordel2==''){
            parentEl.remove();
          } //removes li
          else{
            console.log(dataResult);
            alert("couldn't remove relations check console log");
          }
          }
          else {
            console.log(dataResult);
            alert("There has been an error..."); // TBC
          }
        }
      });
}

// When the user deletes another user from the list
function deleteUser(el){
  var user_id=$(el).parent().data('id');
  team_id=$("#invitebmenu").data('id');
  console.log(user_id);
  console.log(team_id);
  $.ajax({
        url: "php/removeuserfromteam.php",
        type: "POST",
        data: {
          user_id: user_id,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
            $(el).parent().remove();
          }
          else {
            console.log(dataResult);
            alert("There has been an error..."); // TBC
          }
        }
      });
}

//invite users
let email_name_arr=new Array();
let user_name_arr=new Array();
function add_email(el){
  event.preventDefault();
  console.log($(el).parent().parent());
  var team_id=$(el).parent().parent().data('id');
  console.log(team_id);
  var email_in=$("#email").val();
  console.log(email_in);
  if(email_name_arr.includes(email_in)){
  alert("Email already introduced");
  return;
  }
  $.ajax({
        url: "php/checkemailmyteams.php",
        type: "POST",
        data: {
          email: email_in,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (!dataResult.hasOwnProperty('error')){
            // REMINDER TO MODIFY IN CASE OF CHANGES
            console.log(dataResult);
            console.log(dataResult.email);
            if($.inArray(dataResult.row[0],user_id_arr)!=-1){
              alert("Email already introduced 2");
              return;
            }
            $('#eTable > tbody:last-child').append('<tr><td>'+dataResult.row[2]+'</td><td>'+dataResult.row[1]+'</td></tr>');
            email_id_arr.push(dataResult.row[0]);
            email_name_arr.push(email_in);
            user_name_arr.push(dataResult.row[1]);
            $("#email").val('');
            console.log(email_id_arr);
            console.log(user_name_arr);
          }
          else {
            if(dataResult['error']=='invexistent')
             alert("User already invited");
            if(dataResult['error']=='useralreadyinteam')
             alert("User is already in the team");
            if(dataResult['error']=='fetchinfoerror')
             alert("Couldn't fetch info. Email doesn't exist.");

          }
        }
});
}

function inviteUsers(el){
  user_id_arr=[];
  team_id=$(el).parent().data('id');
  // GET userlist
  $.ajax({
        url: "php/tgetuserlist.php",
        type: "POST",
        data: {
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          //EMPTY USER LIST
          $("#cuserlist").empty();
          if (!dataResult.hasOwnProperty('empty')){
            //trebuie sa adaug in lista
            $.each(dataResult,function(key,val){
              var insertedelem='<li data-id="'+val[0]+'" value="'+val[1]+'"><label>'+val[1]+'</label></li>';
              console.log(insertedelem);
              $("#cuserlist").append(insertedelem);
            });
            //alert("Got past jquery each...");
          }
          else {
            //if it already exists avoid putting another one
            if(!$("#cuserlist").find("#emp").length){
                $("#cuserlist").append("<p id='emp'>No users found.</p>"); // TBC
                //console.log(dataResult);
                }else{
                $("#emp").css("display","inline");
              }
          }
        }
      });
      $("#cuserlist").each(function(val,element){
        user_id_arr.push($(element).data('id'));
      });
      $(".emailform").data('id',team_id);
      modali.style.display = "block";
  console.log(user_id_arr);
}
function send_invite(el){
  // MAKE PHP and NECERSSARY EDITS
  // WE HAVE userId from session
  team_id=$(el).parent().data('id');
  console.log(team_id);
//  console.log(email_id_arr);
//  console.log(user_name_arr);
  $.ajax({
        url: "php/userinvite.php",
        type: "POST",
        data: {
          user_from: userId,
          user_to: email_id_arr,
          team_id: team_id,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (!dataResult.hasOwnProperty('error')){
            console.log("invited");
            $("#eTable tbody").empty();
            $("#email").val('');
            email_id_arr=[];
            email_name_arr=[];
            user_name_arr=[];
          }
          else {
            console.log(dataResult);
          }
          }
      });
      modali.style.display="none";
}

//popup window which refreshes page on close
document.getElementById("cteam").onclick = function () {
    var win=window.open('/create_team.php','popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=yes');
    var timer = setInterval(function() {
        if(win.closed) {
            clearInterval(timer);
            location.reload();
        }
    }, 1000);

        };

$('.toolbar_button').on('click', function(){
        var toolbar_arr=['invite','edit','delete'];
        if($(this).data('action')=='delete'){
          deleteTeam(this);
        }
        else if($(this).data('action')=='redir'){
          window.location.href="../team_page.php?id="+$(this).parent().data('id');
        }
        else if($(this).data('action')=='redircal'){
          window.location.href="../team_calendar.php?id="+$(this).parent().data('id');
        }
        else if($(this).data('action')=='invite'){
          inviteUsers(this);
        }
        });

$( ".teamform" ).submit(function( event ) {
        event.preventDefault();
        var team_id=$(this).data('id');
        var el=$('.toolbar[data-id="'+team_id+'"]').parents("tr").find(".namet");
        //console.log(el.data('id'));
        saveTeamInfo(el,team_id);

        });

/*
// MY TASKS FROM HERE ON
    var sortableStart,oldList,newList;
    $( "#sortable1, #sortable2, #sortable3" ).sortable({
        connectWith: ".connectedSortable",
        stop: function(event, ui) {
            var initialStatus=oldList.data('status');
            var currentStatus=newList.data('status');
            var initialIndex=parseInt(sortableStart.data('index'));
            var afterIndex;
            var nextSortable=sortableStart.next();
            if(nextSortable.length)
              afterIndex=parseInt(nextSortable.data('index'));
            else {
              afterIndex=-1;
            }
            var currentIndex;
            var prevItem=ui.item.prev();
            if(prevItem.length)
              currentIndex=parseInt(prevItem.data('index'));
            else
              currentIndex=0;
              console.log("currentIndex:"+currentIndex);
              var oldEach=$( "#"+oldList.attr('id')+" li" );
              var newEach=$( "#"+newList.attr('id')+" li" );

              var confirm=false;

              if(initialStatus==currentStatus){ //daca sunt in aceeasi lista
              oldEach.each(function( index ) {
                var nextRow = oldEach.eq(index+ 1);
                var prevRow = oldEach.eq(index- 1);
                var lastRow = oldEach.eq(-1);
                console.log("index:"+$(this).data('index'));

                if(initialIndex==$(this).data('index')){
                    confirm=true;
                    if(prevRow.data('index') != lastRow.data('index')){
                      $(this).attr('data-index',parseInt(prevRow.attr('data-index'))+1);
                    }
                    else
                    {
                      $(this).attr('data-index',0);
                    }
                  }
                else {
                  if(confirm==true){
                        $(this).attr('data-index',parseInt(prevRow.attr('data-index'))+1);
                  }
                  else{
                    //console.log("prevRow:"+prevRow.html());
                    //console.log("lastRow:"+lastRow.html());
                    if(prevRow.data('index')!=lastRow.data('index')){
                        //console.log("prevrow:",prevRow.data('index'));
                        $(this).attr('data-index',parseInt(prevRow.attr('data-index'))+1);
                      }
                    else
                        $(this).attr('data-index',0);
                  }
                }
              });

              }
              else{ // altfel merge pe asta
                confirm=false;
                console.log("afterIndex is:"+afterIndex);
                if(afterIndex!=-1){
                oldEach.each(function( index ) {
                  var nextRow = oldEach.eq(index+ 1);

                  //console.log($(this).data('index'));
                  if(afterIndex==$(this).data('index')){
                      confirm=true;
                    }
                    if(confirm==true){
                      $(this).attr('data-index',$(this).data('index')-1);
                    }
                });
                }
                confirm=false;
              newEach.each(function( index ) {
                var nextRow = newEach.eq(index+ 1);
                var prevRow = newEach.eq(index- 1);

                //console.log($(this).data('index'));
                if(currentIndex==$(this).data('index')){
                    confirm=true;
                    //console.log($(this).html());
                  }
                  if(confirm==true){
                    console.log($(this).data('index'));
                    $(this).attr('data-index',prevRow.data('index')+1);
                  }
              });
            }
            //console.log('stop: '+ui.item.index());
            //console.log("Moved " + sortableStart.text() + " from " + oldList.attr('id') + " to " + newList.attr('id'));
            var task_id=ui.item.data('id');
            var list1=[];
            var list2=[];

            oldEach.each(function( index ) {
              list1.push({'task_id': $(this).data("task"),'task_index': $(this).data("index")});
            });
            newEach.each(function( index ) {
              list2.push({'task_id': $(this).data("task"),'task_index': $(this).data("index")});
            });
            console.log(list1);

            $.ajax({
                  url: "php/updateorder.php",
                  type: "POST",
                  data: {
                    user_from: userId,
                    user_to: email_id_arr,
                    team_id: team_id,
                  },
                  cache: false,
                  success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if (!dataResult.hasOwnProperty('error')){
                      console.log("invited");
                      $("#eTable tbody").empty();
                      $("#email").val('');
                      email_id_arr=[];
                      email_name_arr=[];
                      user_name_arr=[];
                    }
                    else {
                      console.log(dataResult);
                    }
                    }
                });

        },
        start: function(event, ui) {
            console.log('start: ' + ui.item.index())
            sortableStart=ui.item;
            oldList=newList=ui.item.parent();
        },
        change: function (event, ui) {
          if (ui.sender) {
            newList = ui.placeholder.parent();
          }
        }
    });

});*/
$(".closei").on("click",function(){
  $("#myModali").fadeOut(0);
});
