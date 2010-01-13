<?php
function insertSite($valArray){
	//id, loc, lastmod, changefreq, priority, prop, old_url, valid, 301url
	$values = "''";
	foreach($valArray as $val){
		$values .= ", '" . $val . "'";
	}
	$queryString = "INSERT into pages";
	$queryString .= "VALUES()";
	
	return mysql_query($queryString);
}

function getSites($prop){
	//id, loc, lastmod, changefreq, priority, prop, old_url, valid, 301url
	$queryString = "SELECT * ";
	$queryString .= "FROM pages ";
	$queryString .= "WHERE prop='" . $prop . "' ";
	$queryString .= "AND valid=1";
	
	return mysql_query($queryString);
}
?>
