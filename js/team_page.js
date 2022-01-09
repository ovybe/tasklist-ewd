$(".lists").css("padding-left","15vw");
// scheduler
function get_tasks(){ // FINISHED FOR SCHEDULER
	// userId is a const in index.php
	//console.log('userid:'+userId);
	$.ajax({
				url: "php/gettasks.php",
				type: "POST",
				data: {
					user_id: CURRENT_TEAM,
				},
				cache: false,
				success: function(dataResult){
          //$("#theul").find(".ifemptyt").fadeOut(0);
					var dataResult = JSON.parse(dataResult);
          if (!dataResult.hasOwnProperty('error')){
            //trebuie sa adaug in lista
            // REMINDER TO MODIFY IN CASE OF CHANGES
						//console.log(dataResult);
						$.each(dataResult,function(key,val){
							scheduler.addEvent({id:val.task_id, text:val.task_string, start_date:val.task_start_date, end_date:val.task_end_date});
						});
						//alert("Got past jquery each...");
          }
          else {
             // TBC
						 //scheduler.addEvent({id:dataResult.task_id, text:dataResult.task, start_date:startdate+" 00:00", end_date:enddate+" 23:59"});
						 //$("#catul").val(taskcat).trigger('change');
						 alert("There has been an error getting the tasks for the Calendar. Check dataResult");
          }

				}
			});
}

// DATERANGEPICKER
$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'YYYY/MM/DD HH:mm:ss'
    }
  });
});

// SORTABLE
$( function() {
  $( "#sortable1, #sortable2, #sortable3" ).sortable({
    connectWith: ".connectedSortable",
    update: function( event, ui ) {
			  checkIfEmpty($(this));
        //console.log($(this).attr('data-status'));
        var data = {}
        data = $(this).sortable('toArray', { attribute : "data-task" });
        //console.log(data);
        // POST to server using $.post or $.ajax
       $.ajax({
            data: {order: data, status: $(this).attr('data-status')},
            type: 'POST',
            url: 'php/order.php',
            success: function(data){
                //console.log(data);
            }
        });
    }
  }).disableSelection();
} );

function checkIfEmpty(listElement){
		if(listElement.children("li").length >=1)
				listElement.removeClass('empty');
		else listElement.addClass('empty');
}

$("#taskAddButton").click(function() {
  $("#myModalt").fadeIn(0);


  // AJAX here

});
$("#closet").click(function() {
  $("#myModalt").fadeOut(0);
  // AJAX here


});

  // USER CLICKS ADD
$( ".taskform" ).submit(function( event ) {
      event.preventDefault();
      var task_string=$("#taskAddInput").val();
      var order=$("#sortable1 li").length;
      var datetime=$('#Datepick1').val().split(" - ");

          //console.log(el.data('id'));
      $.ajax({
            url: "php/addtask.php",
            type: "POST",
            data: {
              task_string:task_string,
              user_id:CURRENT_TEAM,
              order:order,
              datetime:datetime,
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              //EMPTY USER LIST
              $("#iuserlist").empty();
              if (!dataResult.hasOwnProperty('empty')){
                //trebuie sa adaug in lista
                //console.log(dataResult);
                  $("#sortable1").append('<li style="background-color:'+CURRENT_TEAM_COLOR+'" data-task="'+dataResult['task_id']+'" data-before="'+datetime[0]+'" data-after="'+datetime[1]+'" class="ui-state-default"><span class="task-text">'+task_string+'</span><div class="toolbar"><button data-action="edit" class="toolbar_button"><i class="fas fa-edit"></i></button><button data-action="delete" class="toolbar_button"><i class="fas fa-minus"></i></button></div></li>');
                  //$("#sortable1").append('<li data-task="'+dataResult['task_id']+'" class="ui-state-default">'+task_string+'</li>');
									$("#sortable1").removeClass("empty");
									$("#sortable1").sortable('refresh');
									$("#myModalt").fadeOut(0);
                  //console.log(insertedelem);
                //alert("Got past jquery each...");
              }
              else {
                //if it already exists avoid putting another one
                console.log(dataResult);
                  }
              }
            });
        });

// USER PRESSES DELETE BUTTON
function deleteTask(el){
          var task_id=$(el).parent().parent().data('task');
          console.log(task_id);
          // AJAX here
          $.ajax({
                url: "php/deletetask.php",
                type: "POST",
                data: {
                  data_id:task_id,
                },
                cache: false,
                success: function(dataResult){
                  var dataResult = JSON.parse(dataResult);
                  if (dataResult['error']==''){
                    //trebuie sa adaug in lista
                    console.log(dataResult);
											if($(el).parent().parent().parent().children('li').length==1)
												$(el).parent().parent().parent().addClass('empty');
										  $(el).parent().parent().remove();
                      $("#sortable1").sortable('refresh');
                      //console.log(insertedelem);
                    //alert("Got past jquery each...");
                  }
                  else {
                    //if it already exists avoid putting another one
                    console.log(dataResult);
                      }
                  }
                });

              }

function kickUser(el){
 	var data_id=$(el).parent().data('id');
 	//console.log(task_id);
 	// AJAX here
 	$.ajax({
       	url: "php/kickuser.php?tid="+CURRENT_TEAM,
       	type: "POST",
       	data: {
         	data_id:data_id,
       	},
       	cache: false,
       	success: function(dataResult){
         	var dataResult = JSON.parse(dataResult);
         	if (dataResult['error']==''){
           	//trebuie sa adaug in lista
           	console.log(dataResult);
						  $(el).parent().parent().parent().parent().append('<tr><td id="emptask">No users other than you found.</td><td></td></tr>');
							$(el).parent().parent().parent().remove();
         	}
         	else {
           	console.log(dataResult);
             	}
         	}
       	});
}

// TASK EDITING
$("#closeEd").click(function() {
  $("#myModalEd").fadeOut(0);
  // AJAX here


});
var EditableTask;
function editTaskMenu(el){
$("#myModalEd").fadeIn(0);
var task_li=$(el).parent().parent();
EditableTask=task_li;
var task_string=task_li.find(".task-text").text();

$('input[name="datetimesedit"]').daterangepicker({
      timePicker: true,
      startDate: $(el).parent().parent().data('before'),
      endDate: $(el).parent().parent().data('after'),
      locale: {
        format: 'YYYY/MM/DD HH:mm:ss'
      }
});
$("#taskEditInput").val(task_string);
$("taskEditInput").text(task_string);
$(".edittaskform").data('task',task_li.data('task'));
}
// EDIT TASK ON SUBMIT
$( ".edittaskform" ).submit(function( event ) {
      event.preventDefault();
      var task_string=$("#taskEditInput").val();
      var task_id=$(".edittaskform").data('task');
      var datetime=$('#DatepickEd').val().split(" - ");

          //console.log(el.data('id'));
      $.ajax({
            url: "php/updatetask.php",
            type: "POST",
            data: {
              task_string:task_string,
              task_id:task_id,
              datetime:datetime,
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              //EMPTY USER LIS
              if (dataResult['error']==''){
                //trebuie sa adaug in lista
                console.log(dataResult);

                  EditableTask.find('.task-text').text(task_string);
                //  console.log(scheduler.getEvent(task_id));
                  $("#myModalEd").fadeOut(0);
                  //console.log(insertedelem);
                //alert("Got past jquery each...");
              }
              else {
                //if it already exists avoid putting another one
                console.log(dataResult);
                  }
              }
            });
        });

$('body').on('click','.toolbar_button', function(){
                //console.log("I happened:",this);
                if($(this).data('action')=='delete'){
                  deleteTask(this);
                }
                else if($(this).data('action')=='edit'){
                  editTaskMenu(this);
                }
        });
$('.table_button').on('click', function(){
				                //console.log("I happened:",this);
				                if($(this).data('action')=='delete'){
				                  kickUser(this);
				                }
				        });
// TEAM EDIT
$("#teamEditbutt").click(function(){
	$("#myModalTED").fadeIn(0);
});
$(".closeTED").click(function() {
  $("#myModalTED").fadeOut(0);
});
$( ".teamform" ).submit(function( event ) {
      event.preventDefault();
      var team_string=$("#tename").val();
      var team_id=$(".teamform").data('id');
			var team_color=$("#tecolor").val();
          //console.log(el.data('id'));
      $.ajax({
            url: "php/editteam.php",
            type: "POST",
            data: {
              team_id:team_id,
              team_name:team_string,
							team_color:team_color,
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              //EMPTY USER LIS
              if (dataResult['error']==''){
                //trebuie sa adaug in lista
                console.log(dataResult);
                //  console.log(scheduler.getEvent(task_id));
									$("#sortable1 li").each(function() {
										$(this).css("background-color",team_color);
									});
									$("#sortable2 li").each(function() {
										$(this).css("background-color",team_color);
									});
									$("#sortable3 li").each(function() {
										$(this).css("background-color",team_color);
									});
									$("#bordertablemember").css("background-color",team_color);
									$("#bordertablehead2").css("background-color",team_color);
                  $("#myModalTED").fadeOut(0);
                  //console.log(insertedelem);
                //alert("Got past jquery each...");
              }
              else {
                //if it already exists avoid putting another one
                console.log(dataResult);
                  }
              }
            });
        });


// INVITE Users
//email id array for invites
let email_id_arr=new Array();
let user_id_arr=new Array();
let email_name_arr=new Array();
let user_name_arr=new Array();
function add_email(el){
  //console.log($(el).parent().parent());
  //var team_id=$(el).parent().parent().data('id');
  //console.log(team_id);
	event.preventDefault();
  var email_in=$("#email").val();
  //console.log(email_in);
  if(email_name_arr.includes(email_in)){
  alert("Email already introduced");
  return;
  }
  $.ajax({
        url: "php/checkemailmyteams.php",
        type: "POST",
        data: {
          email: email_in,
          team_id: CURRENT_TEAM,
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
						else if(dataResult['error']=='useralreadyinteam')
             alert("User is already in the team");
            else if(dataResult['error']=='fetchinfoerror')
             alert("Couldn't fetch info. Email doesn't exist.");

          }
        }
});
}

function inviteUsers(){
  user_id_arr=[];
  // GET userlist
      $(".border_table tbody tr .toolbar").each(function(val,element){
        user_id_arr.push($(element).data('id'));
      });
      //$(".emailform").data('id',CURRENT_TEAM);
      $("#myModali").fadeIn(0);
  console.log(user_id_arr);
}
function send_invite(el){
  // MAKE PHP and NECERSSARY EDITS
  // WE HAVE userId from session
  //team_id=$(el).parent().data('id');
  //console.log(team_id);
//  console.log(email_id_arr);
//  console.log(user_name_arr);
  $.ajax({
        url: "php/userinvite.php",
        type: "POST",
        data: {
          user_from: userId,
          user_to: email_id_arr,
          team_id: CURRENT_TEAM,
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
      $("myModali").fadeOut(0);
}
$("#invitemenu").click(function(){
	$("#myModali").fadeIn(0);
});
$(".closei").click(function() {
  $("#myModali").fadeOut(0);
});
