scheduler.config.readonly = true;
scheduler.init("scheduler_here", new Date(), "week");
scheduler.setLoadMode("day");

// load data from the backend
scheduler.load("data/api.php?team_id="+CURRENT_TEAM);
// send updates to the backend
var dp = new dataProcessor("data/api.php?team_id="+CURRENT_TEAM);
dp.init(scheduler);  // set data exchange mode
dp.setTransactionMode("JSON");
