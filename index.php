<?php include("header.php"); ?>
<?php
	if($_POST['url']){
		echo $_POST['url'];

		$old_file = preg_split("/\//", $_POST['url']);
		//print_r($old_file);
		//$count = count($old_file);
		//echo $count
		//echo $old_file[count($old_file)-1];
		$filename = $old_file[count($old_file)-1] . ".old";
		$oldfile = $FILE_PATH . $filename;
		$fp = @fopen($oldfile, 'w');
		// Curl Options
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $_POST['url']);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // get the response as a string from curl_exec(), rather than echoing it
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); // don't use a cached version of the url
		// Try to write file
		try{
			$result = curl_exec($ch);
			fwrite($fp, $result);
		}catch(Exception $e) {
			echo "Suck it didnt work: " . $e;
		}
		echo "<a href=\"sites/" . $filename . "\">OLD FILE</a>";
	}
?>
<center>
<form method="post" action="index.php">
	URL to SiteMap XML: <input type="text" name="url">
	<br />
	<input type="submit" name ="submit" value="Submit">
</form>
</center>
<?php include("footer.php"); ?>
