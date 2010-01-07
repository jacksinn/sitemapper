<?php include("header.php"); ?>
<?php
	if($_POST['url'] || $argv[1]){
		//echo $argv[1];
		$url = $_POST['url'] ? $_POST['url'] : $argv[1];
		$urlItems = preg_split("/\//", $url);
		
		$filename = $urlItems[count($urlItems)-1] . ".old";
		$oldfile = $FILE_PATH . $filename;
		$newfile = $FILE_PATH . $urlItems[count($urlItems)-1] . ".in";
		
		$fp = @fopen($oldfile, 'w');
		
		// Curl Options
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
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
		fclose($fp);
		curl_close($ch);
		
		echo "<a href=\"sites/" . $filename . "\">OLD FILE</a>";
		
		//parse file
		$lines = file($oldfile);
		
		$fp = @fopen($newfile, 'w');
		foreach($lines as $line){
			if(preg_match("/http[^\<]*/", $line, $match)){
				// Curl Options
				$ch = curl_init($match[0]);

				// make sure we get the header
				curl_setopt($ch, CURLOPT_HEADER, 1);
				// make it a http HEAD request
				curl_setopt($ch, CURLOPT_NOBODY, 1);
				// add useragent
				curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
				//Tell curl to write the response to a variable
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				// The maximum number of seconds to allow cURL functions to execute.
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2);
				// Tell curl to stop when it encounters an error
				curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			   
				try{
					$result = curl_exec($ch);
					// Testing for correct header response
					if(!curl_errno($ch)){
						//copy($tmpCache, $jpiimCache);
						fwrite($fp, $match[0] . ", 1\n");
					} else {
						fwrite($fp, $match[0] . ", 0\n");
					}
				}catch(Exception $e) {
					echo "Inner Curl Failed: " . $e;
				}

			}
		}
		fclose($fp);
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
