<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/db_vars.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/nm_includes/Class_NodeKeeper.php");

$myKeeper = new NodeKeeper();
$myKeeper->populate_nodes();
$myKeeper->render_nodes();

?>