<?php include ($VERSION_PATH . "core/header.php"); ?>
<?php
if($prop = sanitize($_GET['prop'])){
	$siteArray = array();
	
	if($result = getSites($prop)){
		while($row = mysql_fetch_array($result)){
			$site = new SiteMapItem($row['loc'], $row['lastmod'], $row['changefreq'], $row['priority']);
			array_push($siteArray, $site);
		}
	}
		
	$sitemapXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$sitemapXML .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	foreach($siteArray as $s){
		$sitemapXML .=  $s->getSiteMapBlock();
	}
	$sitemapXML .=  "</urlset>";
	
	print_to_file($FILE_PATH . $prop . ".xml", $sitemapXML);
	
} else {
	echo "You need to supply a property";
}
?>
<?php include ($VERSION_PATH . "core/footer.php"); ?> 
