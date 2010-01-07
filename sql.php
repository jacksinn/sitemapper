<?php
function createTask($startDate, $description){
	$queryString = "INSERT INTO tasks ";
	//tid, start, updated (today)
	$queryString .= "VALUES( '', '" . $startDate . "', '" . date('Y-m-d') . "', ";
	//completed, done, 
	$queryString .= "'', '0', '" . $description . "', '' ";
	$queryString .= ")";
	
	//echo $queryString;
	
	$result = mysql_query($queryString);
	
	return $result;
}

function getTask($tid){
	$queryString =  "SELECT t.tid as TID, t.date_started as STARTED, ";
	$queryString .= "t.date_updated as UPDATED, t.date_completed as COMPLETED, ";
	$queryString .= "t.is_completed as DONE, t.description as DESCRIPTION, ";
	$queryString .= "t.comments as COMMENTS ";
	$queryString .= "FROM tasks t ";
	$queryString .= "WHERE t.tid = '" . $tid . "'";

	//echo $queryString;
	$result = mysql_query($queryString);
	if($result){
		return $result;
	}else{
		return false;
	}
}

function updateTask($tid, $description, $comments, $completed){
	//echo $tid . " \ " . $description . " \ " . $comments . " \ " . $completed . " \ ";
	$queryString = "UPDATE tasks t ";
	$queryString .= "SET t.description='" . $description . "', ";
	$queryString .= "t.comments='" . $comments . "', ";
	$queryString .= "t.date_updated='" . date('Y-m-d') . "', ";
	$queryString .= "t.is_completed=" . $completed . ", ";
	if($completed == 1){
		$queryString .= "t.date_completed='" . date('Y-m-d') . "' ";
	}else{
		$queryString .= "t.date_completed='0000-00-00' ";
	}
	$queryString .= "WHERE t.tid = " . $tid . " ";

	//echo $queryString;
	$result = mysql_query($queryString);
	return $result;
}

//THE FUNCTIONS BELOW ARE ALL DIFFERENT SELECTS BASED ON ALL, COMPLETED, or TODO
function allTasks(){
	$queryString =  "SELECT t.tid as TID, t.date_started as STARTED, ";
	$queryString .= "t.date_updated as UPDATED, t.date_completed as COMPLETED, ";
	$queryString .= "t.is_completed as DONE, t.description as DESCRIPTION, ";
	$queryString .= "t.comments as COMMENTS ";
	$queryString .= "FROM tasks t ";

	//echo $queryString;
	$result = mysql_query($queryString);
	if($result){
		return $result;
	}else{
		return "NO TASKS AVAILABLE";
	}
}

function completedTasks($searchDate){
	$html = "";
	
	$queryString =  "SELECT t.tid as TID, t.date_started as STARTED, ";
	$queryString .= "t.date_updated as UPDATED, t.date_completed as COMPLETED, ";
	$queryString .= "t.is_completed as DONE, t.description as DESCRIPTION, ";
	$queryString .= "t.comments as COMMENTS ";
	$queryString .= "FROM tasks t ";
	$queryString .= "WHERE t.is_completed = 1 AND ";
	$queryString .= "t.date_completed > '" . $searchDate . "' ";


	//echo $queryString;
	$result = mysql_query($queryString);
	if($result){
		return $result;
	}else{
		return "NO TASKS AVAILABLE";
	}
}


function todoTasks(){
	$html = "";
	
	$queryString =  "SELECT t.tid as TID, t.date_started as STARTED, ";
	$queryString .= "t.date_updated as UPDATED, t.date_completed as COMPLETED, ";
	$queryString .= "t.is_completed as DONE, t.description as DESCRIPTION, ";
	$queryString .= "t.comments as COMMENTS ";
	$queryString .= "FROM tasks t ";
	$queryString .= "WHERE t.is_completed  = 0 ";

	//echo $queryString;
	$result = mysql_query($queryString);
	if($result){
		return $result;
	}else{
		return "NO TASKS AVAILABLE";
	}
}
?>
