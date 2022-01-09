
const draggable_list = document.getElementById('draggable-list');
const draggable_list2 = document.getElementById('draggable-list2');

const check = document.getElementById('check');

var orderedList = draggable_list.getElementsByTagName('li');
console.log(orderedList);
var orderedList2 = draggable_list2.getElementsByTagName('li');
// Store listItems
const listItems=[],listItems2=[];

let dragStartIndex;
let dragStartEl;
let dragStartParent;

createLists();

// Insert listItems into DOM

function createLists(){

  [...orderedList]
  .sort(function(a, b) {
    return +a.dataset.order - +b.dataset.order;
  });
  [...orderedList]
  .forEach((item,index)=>{
    console.log(item);
    console.log(index);

    const listItem=item;

    listItem.setAttribute('data-index',index);

    listItems.push(listItem);

    addEventListeners();
  });

  [...orderedList2]
  .forEach((item,index)=>{

    const listItem2=item;

    listItem2.setAttribute('data-index',index);

    listItems2.push(listItem2);

    addEventListeners();
    });
}

function dragStart(){
  //console.log("Event:", 'dragstart');
  dragStartIndex = +this.closest('li').getAttribute('data-index');
  dragStartEl=this.closest('li');
  dragStartParent= this.parentNode.parentNode;
  console.log(dragStartParent);
  //console.log(dragStartIndex);
}
function dragEnter(){
  //console.log("Event:", 'dragenter');
  this.classList.add('over');
}
function dragLeave(){
  //console.log("Event:", 'dragleave');
  this.classList.remove('over');

}
function dragOver(e){
  //console.log("Event:", 'dragover');
  e.preventDefault();
}
function dragDrop(){
  //console.log("Event:", 'drop');
  const dragEndIndex = +this.getAttribute('data-index');
  const dragEndParent= this.parentNode;
  console.log(this.parentNode.getAttribute('id'));
  console.log(dragStartParent.getAttribute('id'));
  if(dragStartParent.getAttribute('id')==dragEndParent.getAttribute('id') && dragStartParent.getAttribute('id')=='draggable-list')
    {
      var tempo=this.dataset.order;
      this.dataset.order=dragStartEl.dataset.order;
      dragStartEl.dataset.order=tempo;
      swapItems(dragStartIndex,dragEndIndex);
    }
  else if(dragStartParent.getAttribute('id')==dragEndParent.getAttribute('id') && dragStartParent.getAttribute('id')=='draggable-list2')
    {
    var tempo=this.dataset.order;
    this.dataset.order=dragStartEl.dataset.order;
    dragStartEl.dataset.order=tempo;
    swapItems2(dragStartIndex,dragEndIndex);
    }
  else
    swapParents(dragStartIndex,dragEndIndex,dragStartParent,dragEndParent);

  this.classList.remove('over');
}

function swapItems(fromIndex,toIndex){
  const itemOne = listItems[fromIndex].querySelector('.draggable-el');
  const itemTwo = listItems[toIndex].querySelector('.draggable-el');
  console.log(listItems[fromIndex]);
  console.log(listItems[toIndex]);
  console.log(itemOne);
  console.log(itemTwo);

    if(fromIndex<toIndex){
      for(i=fromIndex;i<toIndex;i++){
        const itemAfter=listItems[i+1].querySelector('.draggable-el');
        listItems[i].appendChild(itemAfter);
        }
      listItems[toIndex].appendChild(itemOne);
    }
    else{
      for(i=fromIndex;i>toIndex;i--){
        const itemAfter=listItems[i-1].querySelector('.draggable-el');
        listItems[i].appendChild(itemAfter);
        }
      listItems[toIndex].appendChild(itemOne);
    }
  }

  function swapItems2(fromIndex,toIndex){
    const itemOne = listItems2[fromIndex].querySelector('.draggable-el');
    const itemTwo = listItems2[toIndex].querySelector('.draggable-el');

      if(fromIndex<toIndex){
        for(i=fromIndex;i<toIndex;i++){
          const itemAfter=listItems2[i+1].querySelector('.draggable-el');
          listItems2[i].appendChild(itemAfter);
          }
        listItems2[toIndex].appendChild(itemOne);
      }
      else{
        for(i=fromIndex;i>toIndex;i--){
          const itemAfter=listItems2[i-1].querySelector('.draggable-el');
          listItems2[i].appendChild(itemAfter);
          }
        listItems2[toIndex].appendChild(itemOne);
      }
    }

function swapParents(fromIndex,toIndex,fromParent,toParent){
    console.log("happened");
  }

function addEventListeners(){
  const draggables = document.querySelectorAll('.draggable-el');
  const dragListItems = document.querySelectorAll('.draggable-list li');
  const dragListItems2 = document.querySelectorAll('.draggable-list2 li');


  draggables.forEach(draggable =>{
    draggable.addEventListener('dragstart',dragStart);
  });

  dragListItems.forEach(item =>{
    item.addEventListener('dragover',dragOver);
    item.addEventListener('drop',dragDrop);
    item.addEventListener('dragenter',dragEnter);
    item.addEventListener('dragleave',dragLeave);
  });

  dragListItems2.forEach(item =>{
    item.addEventListener('dragover',dragOver);
    item.addEventListener('drop',dragDrop);
    item.addEventListener('dragenter',dragEnter);
    item.addEventListener('dragleave',dragLeave);
  });
}
// GET MODAL, GET BUTTON FOR OPENING MODAL, GET SPAN ELEMENT THAT CLOSES THE MODAL
var modal = document.getElementById("myModalc");
var btn = document.getElementById("modalbutt");
var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  $("#cuserlist").empty();
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    $("#cuserlist").empty();
    modal.style.display = "none";
  }
}

function openAddTask(){
  $.ajax({
        url: "php/tgetteamlist.php",
        type: "POST",
        data: {
          user_id:userId,
        },
        cache: false,
        success: function(dataResult){
          var dataResult = JSON.parse(dataResult);
          //EMPTY USER LIST
          $("#iuserlist").empty();
          if (!dataResult.hasOwnProperty('empty')){
            //trebuie sa adaug in lista
            console.log(dataResult);
            $.each(dataResult,function(key,val){
              if(val!=null){
              var insertedelem='<option data-id="'+val['t_id']+'" value="'+val['t_id']+'">'+val['t_name']+'</option>';
              //console.log(insertedelem);
              $("#teamAddTaskSelect").append(insertedelem);
            }
            });
            //alert("Got past jquery each...");
          }
          else {
            //if it already exists avoid putting another one
            console.log(dataResult);
              }
          }
        });
      modal.style.display="block";
}

function addTask(){
  var task=$("#taskAddInput").val();
  var order=orderedList.length;
  var team_id=$("#teamAddTaskSelect").val();
  //var datetime=$('#Datepick1').val().split(" - ");
  //console.log(datetime);
  //var startdate=datetime[0];
  //var enddate=datetime[1];
  //console.log(startdate);
  //console.log(enddate);
  $.ajax({
        url: "php/addtask.php",
        type: "POST",
        data: {
          user_id:userId,
          task_string:task,
          order:order,
          team_id:team_id,
          //category_id: catid,
          //start_date: startdate,
          //end_date: enddate,
        },
        cache: false,
        success: function(dataResult){
          $("#theul").find(".ifemptyt").fadeOut(0);
          var dataResult = JSON.parse(dataResult);
          if (dataResult.error==''){
            //trebuie sa adaug in lista
            // REMINDER TO MODIFY IN CASE OF CHANGES
            //console.log(dataResult);
            //$('#theul').append('<li class="listselected" data-id='+dataResult.task_id+'>'+'<input type="checkbox" /> '+'<label>'+task+'</label>'+'<input type="text"></input>'+'<button class="editb" onclick="editTask(this)">Edit</button>'+'<button class="delb" onclick="deleteTask(this)">Delete</button></li>');
            //scheduler.addEvent({id:dataResult.task_id, text:task, start_date:startdate, end_date:enddate});
            //$("#catul").val(taskcat).trigger('change');
            // NEW STUFF below
            const listItem=document.createElement('li');

            listItem.setAttribute('data-index',order);
            listItem.setAttribute('data-id',dataResult['task_id']);

            listItem.innerHTML=`<span class="number">${order +1}</span><div class="draggable-el" draggable="true"><p class="task-name">${task}</p><i class="fas fa-grip-lines"></i></div><span onclick="deleteTask(this)">X</span>`;

            listItems.push(listItem);

            //console.log(orderedList);

            draggable_list.appendChild(listItem);

            orderedList = draggable_list.getElementsByTagName('li');

          }
          else {
            alert("There has been an error..."); // TBC
          }

        }
      });
}

function deleteTask(el){
  var li=$(el).parent();
  //console.log(li);
  var taskid=li.data('id');
  //console.log(taskid);
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
          li.remove();
					//console.log(taskid);
          }
          else {
            alert("There has been an error..."); // TBC
          }
        }
      });
}
