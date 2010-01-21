<?php include($VERSION_PATH . "core/header.php"); ?>
<?php
	if($_POST['url'] || $argv[1]){
		//echo $argv[1];
		$xmlurl = $_POST['url'] ? $_POST['url'] : $argv[1];
		$urlItems = preg_split("/\//", $xmlurl);
		
		$filename = $urlItems[count($urlItems)-1] . ".old";
		$oldfile = $FILE_PATH . $filename;
		$newfile = $FILE_PATH . $urlItems[count($urlItems)-1] . ".in";
		
		$fp = @fopen($oldfile, 'w');
		
		// Curl Options
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $xmlurl);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 	// get the response as a string from curl_exec(), rather than echoing it
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1); 	// don't use a cached version of the url
		
		// Try to write file
		try{
			$result = curl_exec($ch);
			fwrite($fp, $result);
		}catch(Exception $e) {
			echo "Suck. It didnt work: " . $e;
		}
		fclose($fp);
		curl_close($ch);
		
		echo "<a href=\"sites/" . $filename . "\">OLD FILE</a>";
		
		//parse file
		$lines = file($oldfile);
		
		$fp = @fopen($newfile, 'w');
		foreach($lines as $line){
			//loooking for loc, lastmod, changefreq, priority
			//LOC
			//if we're on the loc line, make sure it's a valid url
			if(preg_match("/(\<loc\>)(http[^\<]*)/", $line, $match)){
				// Curl Options
				$url = $match[2];
				try{
					$chArray = get_url($url, 0); //0 for no redirect
					// Testing for correct header response
					echo $url . " | " . curl_getinfo($chArray["ch"], CURLINFO_HTTP_CODE) . "<br />";
					if(curl_getinfo($chArray["ch"], CURLINFO_HTTP_CODE) != 301){
						echo "<br />" . $chArray["header"]["url"] . " ***NO REDIR***<br />";
					} else {
						$chArray = get_url($url, 1); //1 for redirect
						echo $chArray["header"]["url"] . " ***REDIR***<br />";
					}
					if(!curl_errno($chArray["ch"])){
						//copy($tmpCache, $jpiimCache);
						fwrite($fp, $url . ", 1\n");
					} else {
						//output the error number
						fwrite($fp, $url . ", 0\n");
					}
				}catch(Exception $e) {
					echo "Inner Curl Failed: " . $e;
				}

			}
			//LASTMOD
			else if(preg_match("/(\<lastmod\>)([^\<]*)/", $line, $match)){
			}
			//CHANGEFREQ
			else if(preg_match("/(\<changefreq\>)([^\<]*)/", $line, $match)){
			}
			//PRIORITY
			else if(preg_match("/(\<priority\>)([^\<]*)/", $line, $match)){
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
<?php include($VERSION_PATH . "core/footer.php"); ?> 
<?php function get_url($url, $follow){
	$ch = curl_init($url);

	// make sure we get the header
	curl_setopt($ch, CURLOPT_HEADER, 1);
	// follow redirects
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
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
	
	//curl_exec($ch);
	$content = curl_exec( $ch ); 
    $err     = curl_errno( $ch ); 
    $errmsg  = curl_error( $ch ); 
    $header  = curl_getinfo( $ch ); 

	$arr = array("ch" => $ch, "content" => $content, "err" => $err, "errmsg" => $errmsg, "header" => $header,);
	
	return $arr;
}
