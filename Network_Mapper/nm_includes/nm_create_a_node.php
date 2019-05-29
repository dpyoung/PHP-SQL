<?php 
/*
* nm_create_a_node.php
*/
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/db_vars.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/nm_default_control_options.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/Utilities.php");

$create = test_input($_POST['create']);
$net_add = test_input($_POST['net_add']);
$mac_add = test_input($_POST['mac_add']);
if(strlen($mac_add) == 0){
	$mac_add = null;
}
//TODO: add error responses and data validation; this "test_input" just ensures the DB doesn't get wrecked

if($create == "start"){
	?>
	<form id="createnodeform">
		<input type="hidden" required="required" name="create" value="submit" />
		<input type="text" required="required" name="net_add" placeholder="IP or Net Address" />
		<input type="text" name="mac_add" placeholder="MAC Address" />
	</form>
	<?php
	//Create node-creation form
	NMControl::printSubmit();
	NMControl::printCancel();
}elseif($create == "submit"){
	if(!empty($net_add) && strlen($net_add)>=7){
	    try{//$response = shell_exec("ping " . $hostaddress . " -n 1");
			$pdo = new PDO("" . $GLOBALS['networkpinger_sql_host'] . ";dbname=" . $GLOBALS['networkpinger_sql_db'], $GLOBALS['networkpinger_sql_user'], $GLOBALS['networkpinger_sql_pass']);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); /*INSERT INTO `nodes`(`entry_id`, `net_add`, `mac_add`, `up_down`, `up_time`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])*/
			$stmt = $pdo->prepare("INSERT INTO nodes(net_add, mac_add, up_down, up_time) VALUES (:netAdd, :macAdd, '0', '0');"); 
			$stmt->bindParam(':netAdd', $netadd);
			$stmt->bindParam(':macAdd', $macadd);
			$netadd = $net_add;
			$macadd = $mac_add;
			$stmt->execute();
			echo "Success! <br />";
			NMControl::printCreate();
	    }catch(PDOException $e){
	        echo "Error: " . $e->getMessage();
			?><form id="createnodeform">
				<input type="hidden" name="create" value="submit" />
				<input type="text" name="net_add" placeholder="IP or Net Address" <?php ; ?> />
				<input type="text" name="mac_add" placeholder="MAC Address" />
			</form>
			<?php
	    }
		//On Success, we reprint the Create Node button.
	}else{
		//On Error, reprint form instead.
	?>
	<form id="createnodeform">
		<input type="hidden" name="create" value="submit" />
		<input type="text" name="net_add" placeholder="IP or Net Address" <?php ; ?> />
		<input type="text" name="mac_add" placeholder="MAC Address" />
	</form>
	<?php
		NMControl::printSubmit();
		NMControl::printCancel();
	}
	//respond with nothing, that means success; in case of failure, reprint form.
}else{
		NMControl::printCreate();
}