
$(document).ready(function(){
    console.log('hello');
    $('#catul').on('change', function() {
      //alert("I happened");
      var category_id=$("#catul option:selected").data('id');
      var ok="#doneul";
      var ok2="#theul";
      if(category_id==0){
        // Afiseaza tot
        $(ok2+" input:checkbox").each(function(){
            var li=$(this).parent();
            if(li.hasClass('listdefault'))
              li.toggleClass("listdefault listselected");
          });
        $(ok+" input:checkbox").each(function(){
              var li=$(this).parent();
              if(li.hasClass('listdefault'))
                li.toggleClass("listdefault listselected");
         });
         if ($("#theul").children('li.listselected').length > 0) {
                           $("#theul").find(".ifemptyt").fadeOut(0);
                       } else $("#theul").find(".ifemptyt").fadeIn(0);
         if ($("#doneul").children('li.listselected').length > 0) {
                           $("#doneul").find(".ifemptyt").fadeOut(0);
                       } else $("#doneul").find(".ifemptyt").fadeIn(0);
      }
      else
      {
        // Afiseaza specific
      $(ok2+" input:checkbox").each(function(){
          var li=$(this).parent();
          if(li.hasClass('listselected'))
            li.toggleClass("listselected listdefault");
        });
      $(ok+" input:checkbox").each(function(){
            var li=$(this).parent();
            if(li.hasClass('listselected'))
              li.toggleClass("listselected listdefault");
       });
          $.ajax({
                url: "php/showcategory.php",
                type: "POST",
                data: {
                  category_id:category_id,
                },
                cache: false,
                success: function(dataResult){
                  var dataResult = JSON.parse(dataResult);
                  if (dataResult.error==''){
                    // schimb in hidden
                    dataResult.ids.forEach(function(valoare){
                      $('#theul li[data-id='+ valoare +']').toggleClass("listdefault listselected");
                      $('#doneul li[data-id='+ valoare +']').toggleClass("listdefault listselected");
                    });
                    if ($("#theul").children('li.listselected').length > 0) {
                                      $("#theul").find(".ifemptyt").fadeOut(0);
                                  } else $("#theul").find(".ifemptyt").fadeIn(0);
                    if ($("#doneul").children('li.listselected').length > 0) {
                                      $("#doneul").find(".ifemptyt").fadeOut(0);
                                  } else $("#doneul").find(".ifemptyt").fadeIn(0);
                  }
                  else {
                    alert("There has been an error"); // TBC
                    alert(dataResult.error);
                    alert(dataResult.sql);
                  }
                }
            });
          }
    });
});
//test for touch events support and if not supported, attach .no-touch class to the HTML tag.
if (!("ontouchstart" in document.documentElement)) {
document.documentElement.className += " no-touch";
}

//
function isEmpty( el ){
  return !$.trim(el.html())
}

function addTask(){
  var task=$("#myInput").val();
  var taskcat = $('#catul option:selected').val();
  var catid=$('#myInputaddC option:selected').data('id');
  //console.log(taskcat);
  $.ajax({
				url: "php/addtask.php",
				type: "POST",
				data: {
					task_string: task,
          category_id: catid,
				},
				cache: false,
				success: function(dataResult){
          $("#theul").find(".ifemptyt").fadeOut(0);
					var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
            // REMINDER TO MODIFY IN CASE OF CHANGES
            $('#theul').append('<li class="listselected" data-id='+dataResult.task_id+'>'+'<input type="checkbox" /> '+'<label>'+task+'</label>'+'<input type="text"></input>'+'<button class="editb" onclick="editTask(this)">Edit</button>'+'<button class="delb" onclick="deleteTask(this)">Delete</button></li>');
            $("#catul").val(taskcat).trigger('change');
          }
          else {
            alert("There has been an error..."); // TBC
          }

				}
			});
    }
function addCategory(){
//  var ct=newCat($("#myInputC").val());
  var category_name=$("#myInputC").val();
  $.ajax({
        url: "php/addcategory.php",
        type: "POST",
        data: {
          category_name: category_name,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in liste
            $('#catul').append('<option data-id="'+dataResult.category_id+'" value="'+category_name+'">'+category_name+'</option>');
            $('#myInputaddC').append('<option data-id="'+dataResult.category_id+'" value="'+category_name+'">'+category_name+'</option>');
            $('#changecat').append('<option data-id="'+dataResult.category_id+'" value="'+category_name+'">'+category_name+'</option>');
            $('#changecatdone').append('<option data-id="'+dataResult.category_id+'" value="'+category_name+'">'+category_name+'</option>');
          }
          else {
            alert("There has been an error..."); // TBC
          }

        }
      });
  //console.log(ct);
}
function editCategory(){
var inputch=$("#editforcat").val();
var catid=$("#catul option:selected").data('id');
var containsClass=$("#editforcat").hasClass("editMode");
if(containsClass){
//switch to .editmode
//label becomes the inputs value.
  if(catid==0){
  alert('Eroare! Nu poti modifica "All" intrucat ea arata toate elementele!');
  $("#editforcat").val('');
}
  else{
  $.ajax({
        url: "php/editcategory.php",
        type: "POST",
        data: {
          category_name: inputch,
          category_id: catid,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
            $("#catul option[data-id='"+catid+"']").each(function() {
              //removes each option.
              $(this).text(inputch);
            });
            $("#changecat option[data-id='"+catid+"']").each(function() {
              //removes each option.
              $(this).text(inputch);
            });
            $("#changecatdone option[data-id='"+catid+"']").each(function() {
              //removes each option.
              $(this).text(inputch);
            });
            $("#myInputaddC option[data-id='"+catid+"']").each(function() {
              //removes each option.
              $(this).text(inputch);
            });
            $("#editforcat").val('');
            $("#catul").val(inputch).trigger('change');
          }
          else {
            alert("There has been an error..."); // TBC
          }
        }
      });
    }
}
//toggle .editmode on the parent.
$("#editforcat").toggleClass("editforc editMode");
}
//CHANGE CATEGORY
function changeCatToDo(){
  changeCatgen("#changecat","#theul");
}
function changeCatDone(){
  changeCatgen("#changecatdone","#doneul");
}
function changeCatgen(id,idlist){
  var selectedid=[];
  //console.log(id);
  $(idlist+" input:checkbox").each(function(){
    if(this.checked){
      var li=$(this).parent();
      var taskid=li.data('id');
      if(li.hasClass('listselected')){
      selectedid.push(taskid);
      }
    }
    //console.log(selectedid);
  });
  //console.log(selectedid);
  var inputch=$(id+" option:selected").val();
  var currentcat=$("#catul option:selected").val();
  var catid=$(id+" option:selected").data('id');
  //console.log(catid);
  //console.log(inputch);
  if(selectedid.length==0){
    alert("Nothing was selected for category change!");
  }
  else
  $.ajax({
        url: "php/changecategory.php",
        type: "POST",
        data: {
          category_id: catid,
          data_id: selectedid,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
             setTimeout(function(){ alert("Success!"); }, 1000);
             $("#catul").val(currentcat).trigger('change');
          }
          else {
            setTimeout(function(){ alert("There has been an error..."); }, 2000);
            console.log(dataResult.sql); // TBC
          }
        }
      });
}
//EDIT TASK
function editTask(el){
var li=$(el).parent();
//console.log(li);
var editInput=$(li).find('input[type=text]').first();
var label=$(li).find("label").first();
var containsClass=$(li).hasClass("editMode");
var taskval=editInput.val();
var taskid=li.data('id');
//console.log(editInput.text());
//console.log(label.text());
		//If class of the parent is .editmode
		if(containsClass){
		//switch to .editmode
		//label becomes the inputs value.
      $.ajax({
            url: "php/updatetask.php",
            type: "POST",
            data: {
              task_string: taskval,
              data_id: taskid,
            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
              if (dataResult.error==''){
                //trebuie sa adaug in lista
                label.text(taskval);
              }
              else {
                alert("There has been an error..."); // TBC
              }
            }
          });
		}else{
			editInput.val(label.text());
		}
		//toggle .editmode on the parent.
		$(li).toggleClass("editb editMode");
}
// DELETE

function deleteCategory(){
  var cat=$("#catul option:selected");
  var catid=$("#catul option:selected").data('id');
  //console.log(li);
  if(catid==0){
    alert('Eroare! Nu poti sterge "All" intrucat ea arata toate elementele!');
  }
  else
  $.ajax({
        url: "php/deletecategory.php",
        type: "POST",
        data: {
          category_id: catid,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
          cat.remove();
          $("#changecat option[data-id='"+catid+"']").each(function() {
            //removes each option.
            $(this).remove();
          });
          $("#changecatdone option[data-id='"+catid+"']").each(function() {
            //removes each option.
            $(this).remove();
          });
          $("#myInputaddC option[data-id='"+catid+"']").each(function() {
            //removes each option.
            $(this).remove();
          });
          $("#catul").val('All').trigger('change');
          }
          else {
            alert("There has been an error...");
            alert(dataResult.error); // TBC
          }
        }
      });
}

function deleteTask(el){
  var li=$(el).parent();
  var taskid=li.data('id');
  //console.log(li);
  $.ajax({
        url: "php/deletetask.php",
        type: "POST",
        data: {
          data_id: taskid,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
          if ($(li).parent().children('li.listselected').length > 1) {
                              $(li).parent().find(".ifemptyt").fadeOut(0);
                          } else $(li).parent().find(".ifemptyt").fadeIn(0);
          li.remove();
          }
          else {
            alert("There has been an error..."); // TBC
          }
        }
      });
}
function DeleteGeneral(id){
  var selectedid=[];
  var selectedli=[];
  $(id+" input:checkbox").each(function(){
    if(this.checked){
      var li=$(this).parent();
      var taskid=li.data('id');
      if(li.hasClass('listselected')){
      selectedid.push(taskid);
      selectedli.push(li);
      }
    }
    //console.log(selectedid);
    })
    if(selectedid.length==0){
      alert("Nothing was selected for deletion!");
    }
    else
    $.ajax({
          url: "php/deletetasks.php",
          type: "POST",
          data: {
            data_id: selectedid,
          },
          cache: false,
          success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
            if (dataResult.error==''){
              //trebuie sa adaug in lista
              $.each(selectedli,function(){
                $(this).remove();
              });
              if ($(id).children('li.listselected').length > 0) {
                                $(id).find(".ifemptyt").fadeOut(0);
                            } else $(id).find(".ifemptyt").fadeIn(0);
            //console.log("Deleted successfully");
            }
            else {
              alert("There has been an error"); // TBC
            }
          }
        });
}
function DeleteSelectedToDo(){
  DeleteGeneral("#theul");
}
function DeleteSelectedDone(){
  DeleteGeneral("#doneul");
}
// MOVE
function moveGeneral(id_from,id_to,status){
  var selectedid=[];
  var selectedli=[];
  $(id_from+" input:checkbox").each(function(){
    if(this.checked){
      var li=$(this).parent();
      var taskid=li.data('id');
      if(li.hasClass('listselected')){
      selectedid.push(taskid);
      selectedli.push(li);
    }
    }
    //console.log(selectedid);
  });
  if(selectedid.length==0){
    alert("Nothing was selected to be moved!");
  }
  else{
    $.ajax({
          url: "php/movetasks.php",
          type: "POST",
          data: {
            data_id: selectedid,
            task_status: status,
          },
          cache: false,
          success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
            if (dataResult.error==''){
              //trebuie sa adaug in lista
              $.each(selectedli,function(){
                $(id_to).append(this);
              });
              //console.log(id_from);
              //console.log($(id_from).children('li.listselected').length);
              //console.log($(id_to).children('li.listselected').length);
              if ($(id_from).children('li.listselected').length > 0) {
                                $(id_from).find(".ifemptyt").fadeOut(0);
                            } else $(id_from).find(".ifemptyt").fadeIn(0);
              if ($(id_to).children('li.listselected').length > 0) {
                                $(id_to).find(".ifemptyt").fadeOut(0);
                            } else $(id_to).find(".ifemptyt").fadeIn(0);

            //console.log("Deleted successfully");
            }
            else {
              alert("There has been an error"); // TBC
            }
          }
        });
      }
}
function moveToDone(){
  moveGeneral("#theul","#doneul",1);
/*if ($('#theul').children('li').length > 0) {
    $("#ifemptyt").fadeOut(0);
}
else {
  if($("#ifemptyt").length == 0) {
    //it doesn't exist
    $("#theul").append('<h3 id="ifemptyt">There are no tasks to be done.</h3>');
  }
  else
  $("#ifemptyt").fadeIn(0);
}*/
}
function moveToBack(){
 moveGeneral("#doneul","#theul",0);
 /*if ($('#doneul').children('li').length > 0) {
     $("#ifemptyt").fadeOut(0);
 }
 else {
   if($("#ifemptytd").length == 0) {
     //it doesn't exist
     $("#doneul").append('<h3 id="ifemptytd">There are no tasks done.</h3>');
   }
   else
   $("#ifemptytd").fadeIn(0);
}*/
 /*if (isEmpty($('#theul'))) {
     $('#theul').append('<h3 id="ifemptyt">There are no tasks done.</h3>');
 }
 else $('#ifemptyt').remove();*/
}
function SelectGen(id){
  $(id+" input:checkbox").each(function(){
    if(!this.checked){
      $(this).prop( "checked", true );
    }
  });
}
function SelectallToDo(){
  SelectGen("#theul");
}
function SelectallDone(){
  SelectGen("#doneul");
}
