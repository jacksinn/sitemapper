<?php
	include("settings.php");
	include("dbConn.php");
	include("sql.php");
	include("sitemapClass.php");

	$siteArray = array();
	
	if($result = getSites($_GET['site'])){
		while($row = mysql_fetch_array($result)){
			$site = new SiteMapItem($row['loc'], $row['lastmod'], $row['changefreq'], $row['priority']);
			array_push($siteArray, $site);
		}
	}
		
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	foreach($siteArray as $s){
		echo $s->getSiteMapBlock();
	}
	echo "</urlset>";
	mysql_close($conn);
?>
