<?php 
/*
* nm_includes/nm_delete_a_node.php
*/
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/utilities.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/db_vars.php");

$net_add_value = test_input($_POST['nodeToDelete']);
if(strlen($net_add_value) >= 7 && strlen($net_add_value) <= 17){
	try {
		//$mysql_connection = new PDO("sqlsrv:Server=localhost;Database=testdb", "UserName", "Password");
		$pdo = new PDO("" . $GLOBALS['networkpinger_sql_host'] . ";dbname=" . $GLOBALS['networkpinger_sql_db'], $GLOBALS['networkpinger_sql_user'], $GLOBALS['networkpinger_sql_pass']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM nodes WHERE net_add = :netaddvalue;"); 
		$stmt->bindParam(':netaddvalue', $net_add_value);
		//if(!stristr($response,"timed out") && !stristr($response,"unreachable")){
		$stmt->execute();
		echo "<p class='text-success'>Successfully executed SQL.</p><br />";
	}catch(PDOException $e){
		echo "<p class='text-danger'>Connection failed: " . $e->getMessage() . "</p><br />";
	}
}else{
	echo "<p class='text-danger'>IP address format is strange. Refresh the page, then try again.</p><br />";
}

echo "<button class=\"btn btn-success createanode\">Create Node</button>";
