<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/utilities.php");

class NetworkNode{
	private $entry_id = "";
	private $net_add = "";
	private $mac_add = "";
	private $up_down = 0;
	private $up_time = 0;
	private $attributes = array();
	
	/********************************************************************************
	*	
    	*       Description:			Constructor
	*		Pre:			ODBC connection Exists with specified credentials
	*		Post:			NetworkNode object created with appropriate attributes
	*		Return:			N/A
	*		TODO:			Combine SQL queries into one for efficiency/speed.
	********************************************************************************/
	public function __construct($entry_id, $net_add, $mac_add, $up_down, $up_time, $attributes){
		$entry_id = preg_replace('/[^0-9]/', '', $entry_id);
		$net_add = preg_replace('/[^0-9\.\;\:]/', '', $net_add);
		$mac_add = preg_replace('/[^0-9A-Za-z\.\-\:]/', '', $mac_add);
		$up_down = preg_replace('/[^0-1]/', '0', $up_down);
		$up_time = preg_replace('/[^0-9]/', '', $up_time);
		foreach($attributes as $attribute){
			$attribute = test_input($attribute);
			array_push($this->attributes, $attribute);
		}
		$this->entry_id = $entry_id;
		$this->net_add = $net_add;
		$this->mac_add = $mac_add;
		$this->up_down = $up_down;
		$this->up_time = $up_time;
	}
			
	function setNetAdd($net_add){
		$this->net_add = $net_add;
	}
	
	function setMacAdd($mac_add){
		$this->mac_add = $mac_add;
	}
	
	function setUpDown($up_down){
		$this->up_down = $up_down;
	}
	
	function setUpTime($up_time){
		$this->up_time = $up_time;
	}
	
	function setAttributes($attributes){
		foreach($attributes as $attribute){
			array_push($this->attributes, $attribute);
		}
	}
	
	
	function getEntryID(){
		return $this->entry_id;
	}
	function getNetAdd(){
		return $this->net_add;
	}
	function getMacAdd(){
		return $this->mac_add;
	}
	function getUpDown(){
		return $this->up_down;
	}
	function getUpTime(){
		return $this->up_time;
	}
	function getAttributes(){
		return $this->attributes;
	}
	
	
}

?>
