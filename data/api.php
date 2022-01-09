<?php
require_once("config.php");
$team_id=$_GET["team_id"];

$db = new PDO($dsn, $username, $password, $options);

function read($db, $requestParams){
  global $team_id;
 $queryParams = [];
 $queryText = "SELECT `task_id` as `id`,`task_string` as `text`,`task_start_date` as `start_date`, `task_end_date` as `end_date` FROM `tasks` where user_id=".$team_id;

 if (isset($requestParams["from"]) && isset($requestParams["to"])) {
   $queryText .= " AND `task_end_date`>=? AND `task_start_date` < ?;";
   $queryParams = [$requestParams["from"], $requestParams["to"]];
    }

   $query = $db->prepare($queryText);
   //echo $queryText;
   $query->execute($queryParams);
   $events = $query->fetchAll();
   return $events;
}

// create a new event
function create($db, $event){
    global $team_id;
    $queryText = "SELECT * FROM `tasks` WHERE user_id=".$team_id;
    $query = $db->prepare($queryText);
    $query->execute();
    $order= $query->rowCount();
    //echo $order;

    $queryText = "INSERT INTO `tasks` SET
        `user_id`=?,
        `task_start_date`=?,
        `task_end_date`=?,
        `task_string`=?,
        `task_status`=0,
        `task_order`=?
        ";
    $queryParams = [
        $team_id,
        $event["start_date"],
        $event["end_date"],
        $event["text"],
        $order
    ];

    $query = $db->prepare($queryText);
    //echo($queryText);
    $query->execute($queryParams);
    return $db->lastInsertId();
}
// update an event
function update($db, $event, $id){
    global $team_id;
    $queryText = "UPDATE `tasks` SET
        `task_start_date`=?,
        `task_end_date`=?,
        `task_string`=?
        WHERE `user_id`=? AND `task_id`=?";
    $queryParams = [
        $event["start_date"],
        $event["end_date"],
        $event["text"],
        $team_id,
        $id
    ];
    $query = $db->prepare($queryText);
    $query->execute($queryParams);
}
// delete an event
function delete($db, $id){
    global $team_id;
    $queryText = "DELETE FROM `tasks` WHERE `task_id`=? ;";
    $query = $db->prepare($queryText);
    $query->execute([$id]);
}

switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            $result = read($db, $_GET);
            break;
        case "POST":
            $requestPayload = json_decode(file_get_contents("php://input"));
            //$team_id= $requestPayload->team_id;
            $id = $requestPayload->id;
            $action = $requestPayload->action;
            $body = (array) $requestPayload->data;
            $result = ["action" => $action];
            if ($action == "inserted") {;
             $databaseId = create($db, $body);
             $result["tid"] = $databaseId;
            } elseif($action == "updated") {
                update($db, $body, $id);
                } elseif($action == "deleted") {
                delete($db, $id);
              }
             break;
        default:
            throw new Exception("Unexpected Method");
        break;
}
header("Content-Type: application/json");
echo json_encode($result);


?>
