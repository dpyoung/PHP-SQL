<?php 
/*
*	Class_NodeKeeper.php
*/
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/Class_NetworkNode.php");

class NodeKeeper{
	private static $nodes = array();
	private static $pdo;
	/********************************************************************************
	*	
    	*       Description:			populate_nodes, to fetch all stored network locations
	*		Pre:			ODBC connection configuration defined in /nm_includes/db_vars.php
 	*					This is linked via /nm_includes/Class_NetworkNode.php
	*		Post:			NetworkNode objects array is created
	*		Return:			N/A
	*		TODO:			
	********************************************************************************/
	function populate_nodes(){
		try {
			//$mysql_connection = new PDO("sqlsrv:Server=localhost;Database=testdb", "UserName", "Password");
			self::$pdo = new PDO("" . $GLOBALS['networkpinger_sql_host'] . ";dbname=" . $GLOBALS['networkpinger_sql_db'], $GLOBALS['networkpinger_sql_user'], $GLOBALS['networkpinger_sql_pass']);
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = self::$pdo->prepare("SELECT * FROM nodes");
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tempNode = new NetworkNode($row['entry_id'], $row['net_add'], $row['mac_add'], $row['up_down'], $row['up_time'], $row['attributes']);
				array_push(self::$nodes, $tempNode);
			}
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
	}
	
	/********************************************************************************
	*	
    	*       Description:			render_nodes, to render all fetched network locations
	*		Pre:			object's $nodes array is populated via populate_nodes()
	*		Post:			NetworkNode objects array is rendered in DIV elements
	*		Return:			N/A
	*		TODO:			
	********************************************************************************/	
	function render_nodes(){
		foreach(self::$nodes as $node){
			$hosthash = md5($node->getEntryID());
			if($node->getUpDown() == 1){
				?>
				<div class='node-entry bg-success' data-nodeid="<?= $node->getNetAdd(); ?>">
					<span style='display:inline-block;max-width:50%;'><i class="fas fa-3x fa-hdd"></i> Server at <?= $node->getNetAdd(); ?> is Up.<br />
					<button class='btn btn-primary btn-sm expandanode' href="#_<?= $hosthash; ?>" data-toggle="collapse" >Node Details</button></span>
					<span style='display:inline-block;max-width:50%;float:right;'>
						<button class='btn btn-sm btn-info'>Edit Node</button>
						<button class='deleteanode btn btn-sm btn-danger'>Delete Node</button>
					</span>
					<div style="display:none;" id="_<?= $hosthash; ?>" class="nodedetailsdiv">
						<p>
						<?php if(strlen($node->getMacAdd()) > 0){ ?>Mac: <?= $node->getMacAdd(); ?><br /><?php } ?>
						<?php if(strlen($node->getUpTime()) > 0){ ?>Up Time: <?= $node->getUpTime(); ?><br /><?php } ?>
						<?php foreach($node->getAttributes() as $attribute){
							if(strlen($attribute) > 0){ ?><?= $attribute; ?><br /><?php }
						}
						?>
						</p>
					</div>
				</div>
				<?php
			}else{
				?>
				<div class='node-entry bg-danger' data-nodeid="<?= $node->getNetAdd(); ?>">
					<span style='display:inline-block;max-width:50%;'><i class="fas fa-3x fa-dumpster-fire"></i> Server at <?= $node->getNetAdd(); ?> is Down.<br />
					<button class='btn btn-primary btn-sm expandanode' href="#_<?= $hosthash; ?>" data-toggle="collapse" >Node Details</button></span>
					<span style='display:inline-block;max-width:50%;float:right;'>
						<button class='btn btn-sm btn-info'>Edit Node</button>
						<button class='deleteanode btn btn-sm btn-danger'>Delete Node</button>
					</span>
					<div style="display:none;" id="_<?= $hosthash; ?>" class="nodedetailsdiv">
						<p>
						<?php if(strlen($node->getMacAdd()) > 0){ ?>Mac: <?= $node->getMacAdd(); ?><br /><?php } ?>
						<?php if(strlen($node->getUpTime()) > 0){ ?>Up Time: <?= $node->getUpTime(); ?><br /><?php } ?>
						<?php foreach($node->getAttributes() as $attribute){
							if(strlen($attribute) > 0){ ?><?= $attribute; ?><br /><?php }
						}
						?>
						</p>
					</div>
				</div>
				<?php
			}
		}
	}
	
	/********************************************************************************
	*	
    	*       Description:			getNodes
	*		Pre:			object is instantiated
	*		Post:			NetworkNode objects array is returned
	*		Return:			$array of type <NetworkNode>
	*		TODO:			
	********************************************************************************/		
	function getNodes(){
		return self::$nodes;
	}

}
