let email_id_arr=new Array();
let email_name_arr=new Array();
function add_email(){
  event.preventDefault();
  var email_in=$("#email").val();
  console.log(email_in);
  if(email_name_arr.includes(email_in)){
  alert("Email already introduced");
  return;
  }
  $.ajax({
        url: "php/checkemail.php",
        type: "POST",
        data: {
          email: email_in,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (!dataResult.hasOwnProperty('error')){
            // REMINDER TO MODIFY IN CASE OF CHANGES
            console.log(dataResult);
            console.log(dataResult.email);
            $('#eTable > tbody:last-child').append('<tr><td>'+dataResult.row[2]+'</td><td>'+dataResult.row[1]+'</td></tr>');
            email_id_arr.push(dataResult.row[0]);
            email_name_arr.push(email_in);
            console.log(email_id_arr);
          }
          else {
             alert("Email does not exist or there has been an error. Try again.");
          }
        }
});
/*
$.ajax({
      url: "php/checkuser.php",
      type: "POST",
      data: {
        user_id: userId,
      },
      cache: false,
      success: function(dataResult){
        var dataResult = JSON.parse(dataResult);
        if (!dataResult.hasOwnProperty('error')){
          // REMINDER TO MODIFY IN CASE OF CHANGES
          $.each(dataResult,function(key,val){
            scheduler.addEvent({id:val.task_id, text:val.task_string, start_date:val.task_start_date, end_date:val.task_end_date});
          });
        }
        else {
           alert("There has been an error getting the tasks for the Calendar. Check dataResult");
        }
      }
});*/
}

function clicked(e)
{
  var t_name=$("#tName").val();
  var t_color=$("#tColor").val();
  console.log(t_name);

    if(!confirm('Are you sure you want to create a team?')) {
      e.preventDefault();
    }
    else{
      e.preventDefault();
      console.log(email_id_arr);
      $.ajax({
            url: "php/createteamform.php",
            type: "POST",
            data: {
              user_from: userId,
              t_name:t_name,
              t_color:t_color,
              id: 1,
              user_to: email_id_arr,
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              if(dataResult.hasOwnProperty('error')){
                console.log(dataResult);
                alert("Error! Team name '"+t_name+"' already exists.");
                //$('#create_team').trigger("reset");
              }
              else{
              if (!dataResult.result1.hasOwnProperty('error')){
                // REMINDER TO MODIFY IN CASE OF CHANGES
                console.log(dataResult);
                //console.log(dataResult.email);
                //$('#eTable > tbody:last-child').append('<tr><td>'+dataResult.row[2]+'</td><td>'+dataResult.row[1]+'</td></tr>');

              }
              else {
                 //alert("Email does not exist.");
                console.log(dataResult.result1);
                console.log("Error at result 1.");
                //return;
              }
              if(dataResult.result2.hasOwnProperty('error')){
                console.log("Error at result 2.");
                //return;
              }
              if(dataResult.result3['error']===""){}
              else {
                console.log("Error at result 3.");
                //return;
              }
              if(dataResult.result4.hasOwnProperty('error')){
                console.log("Error at result 4.");
                //return;
              }
              window.close();
            }
          }
    });
          return false;
  }
  }
