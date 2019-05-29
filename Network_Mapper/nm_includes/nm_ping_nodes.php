<?php 
/*
* nm_ping_nodes.php
*/
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/db_vars.php");

class NetworkPinger{
	private $nodes = array();
	private static $pdo;
	
	function populate_nodes(){
		try {
			//$mysql_connection = new PDO("sqlsrv:Server=localhost;Database=testdb", "UserName", "Password");
			self::$pdo = new PDO("" . $GLOBALS['networkpinger_sql_host'] . ";dbname=" . $GLOBALS['networkpinger_sql_db'], $GLOBALS['networkpinger_sql_user'], $GLOBALS['networkpinger_sql_pass']);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = self::$pdo->prepare("SELECT net_add FROM nodes");
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				array_push($this->nodes, $row['net_add']);
			}
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	function ping_my_server($hostaddress){
		$response = shell_exec("ping " . $hostaddress . " -n 1");
		$stmt = self::$pdo->prepare("UPDATE nodes SET up_down = :isUpValue WHERE net_add = :isIPValue;"); 
		$stmt->bindParam(':isUpValue', $upValue);
		$stmt->bindParam(':isIPValue', $ipAddress);
		$hosthash = md5($hostaddress);
		if(stristr($response,"time=")||stristr($response,"time<")){
			$upValue = "1";
			$ipAddress = $hostaddress;
			$stmt->execute();
		}else{
			$upValue = "0";
			$ipAddress = $hostaddress;
			$stmt->execute();
		}
	}
	
	function getNodes(){
		return $this->nodes;
	}
}

$myPinger = new NetworkPinger();
$myPinger->populate_nodes();
foreach($myPinger->getNodes() as $node){
	$myPinger->ping_my_server($node);
}
echo "Completed network ping.";

//$myNode = new NetworkNode($entry_id, $net_add, $mac_add, $up_down, $up_time, $attributes);
//Nothing to see here
?>