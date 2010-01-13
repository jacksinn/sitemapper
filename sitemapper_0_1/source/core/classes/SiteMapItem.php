<?php
class SiteMapItem {
	//VARIABLES
	private $loc;
	private $lastmod;
	private $changefreq;
	private $priority;
	private $siteMapBlock;
	
	//CONSTRUCTOR
	function __construct($lo="http://www.example.org", $lm="2010-01-01", $cf="never", $pr=0.5){
		$this->loc = $lo;
		$this->lastmod = $lm;
		$this->changefreq = $cf;
		$this->priority = $pr;
	}
	
	//DESTRUCTOR
	function __destruct(){
		return 1;
	}
	
	//SET METHODS
	function setLoc($lo){
		$this->loc = $lo;
	}
	function setLastMod($lm){
		$this->lastmod = $lm;
	}
	function setChangeFreq($cf){
		$this->changefreq = $cf;
	}
	function setPriority($pr){
		$this->priority = $pr;
	}
	
	//GET METHODS
	function getLoc(){
		return $this->loc;
	} 
	function getLastMod(){
		return $this->lastmod;
	}
	function getChangeFreq(){
		return $this->changefreq;
	} 
	function getPriority(){
		return $this->priority;
	} 
	
	//CLASS METHODS
	function getSiteMapBlock(){
		$this->siteMapBlock = "\t<url>\n";
		$this->siteMapBlock .= "\t\t<loc>" . $this->loc ."</loc>\n";
		$this->siteMapBlock .= "\t\t<lastmod>" . $this->lastmod ."</lastmod>\n";
		$this->siteMapBlock .= "\t\t<changefreq>" . $this->changefreq ."</changefreq>\n";
		$this->siteMapBlock .= "\t\t<priority>" . $this->priority ."</priority>\n";
		$this->siteMapBlock .= "\t</url>\n";
		
		return $this->siteMapBlock;
	}
}
?>
