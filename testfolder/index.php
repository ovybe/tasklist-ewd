<?php
require_once('connection.php');

function getTableFor($listStatus){
    global $conn;
    $html = FALSE;
    $sql = "SELECT * FROM `tasks` WHERE `status` = ".$listStatus." ORDER BY `order` ASC ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $html = '<ul id="sortable'.($listStatus+1).'" data-status="'.$listStatus.'" class="connectedSortable">';
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $html .= '<li data-task="'.$row['id'].'" class="ui-state-default">'.$row['task'].'</li>';
      }
      $html .= '</ul>';
    }
    return $html;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Test Sortable - Connect lists</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable1, #sortable2, #sortable3 {
    border: 1px solid #eee;
    width: 142px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
  }
  #sortable1 li, #sortable2 li, #sortable3 li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 120px;
  }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable1, #sortable2, #sortable3" ).sortable({
      connectWith: ".connectedSortable",
      update: function( event, ui ) {
          console.log($(this).attr('data-status'));
          var data = {}
          data = $(this).sortable('toArray', { attribute : "data-task" });
          console.log(data);
          // POST to server using $.post or $.ajax
         $.ajax({
              data: {order: data, status: $(this).attr('data-status')},
              type: 'POST',
              url: 'order.php',
              success: function(data){
                  console.log(data);
              }
          });
      }
    }).disableSelection();
  } );
  </script>
</head>
<body>
<?php
for($i=0; $i<=2; $i++){
    $sortable = getTableFor($i);
    if($sortable != FALSE)
        echo $sortable;
}
?>
</body>
</html>
