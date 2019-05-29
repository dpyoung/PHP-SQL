<?php 
/*
*	nm_front_javascript.php
*		Front Page Javascript
*
*/
?>
<script>
/*Javascript for Front Page goes here.*/

/*Important Progress Bar Vars. Meant to periodically sync page with server status.*/
var isMoving = 0;
var id;

/**
*	nm_update_view_complete()
*		PARAMS: none
*		PRE:	view database exists, as does connection.
*		POST:	prints list of device ping results.
**/
function nm_update_view_complete(){
	var clockoutVal = "";
	$.post("nm_includes/ping_test.php", {clockout: clockoutVal}, function(result){
		$("#nm_body_contents").html(result); 
	});
}

/*
*	Status Bar Update + Viewer Update. Refreshes middle of page; may annoy users with drop-downs open!!!
*/
function move() {
	var elem = document.getElementById("myBar");   
	var width = 0;
	clearInterval(id);
	id = setInterval(frame, 600);
	function frame() {
		if (width >= 100) {
			clearInterval(id);
			isMoving = 0;
			nm_update_view_complete();
		} else {
			width+=0.1;
			isMoving = 1;
			elem.style.width = width + '%'; 
		}
	}
}

/*
Updates network data on page load.
*/
$(document).ready(function() { 
	move();
});



/*
Updates page sessions on page soft refresh, performed by user.
*/
$(document).on("click", '.refreshapage', function(event) { 
	console.log("Updating live network responses... ");
	nm_update_view_complete();
	move();
});

/*
Updates status of all ping responses on network database.
*/
$(document).on("click", '.pingthenetwork', function(event) {
	event.preventDefault();
	console.log("Pinging the network. Please wait...."); 
	$.get("nm_includes/nm_ping_nodes.php", function(result){
		console.log(result); 
		nm_update_view_complete();
		move();
	});
});



/*******************************************************************************
JS DELETIONS
*******************************************************************************/
/*
*	CLICK .deleteanode
*		
*		DELETE A NODE
* 		Used to "delete" a node post-creation
*	
*/
$(document).on("click", '.deleteanode', function(event) { 
	event.preventDefault();
	var whereAmI = $(this).parent();
	//console.log(whereAmI);
	whereAmI = whereAmI.parent();
	console.log(whereAmI);
	//var nodeYouWillDelete = whereAmI.dataset.nodeid;
	var nodeYouWillDelete = whereAmI.attr('data-nodeid');
	console.log(nodeYouWillDelete);
	var r=confirm("Are you sure you want to delete this node?");
	if (r==true){
		console.log("Attempting to delete node: ");
		console.log(nodeYouWillDelete);
		$.post("nm_includes/nm_delete_a_node.php", {nodeToDelete: nodeYouWillDelete}, function(result){
			//$("").html(result); 
			$(".editorForm").html(result); 
			whereAmI.remove();
		});
	}
});
/*
*	CLICK .cancelanode
*		
*		DELETE A THING WE WERE JUST WORKING ON
* 		Used to "close" a form used to create new nodes
*	
*/
$(document).on("click", '.cancelanode', function(event) { 
	event.preventDefault();	
	$.post("nm_includes/nm_create_a_node.php", {create: "cancel"}, function(result){
		$("#editorForm").html(result); 
	});
});



/*******************************************************************************
JS ADDITIONS
*******************************************************************************/
/*
*	CLICK .createanode
*		
*		ADD A NODE
* 		Used to "add" a node
*	
*/
$(document).on("click", '.createanode', function(event) {
	event.preventDefault();
	$.post("nm_includes/nm_create_a_node.php", {create: "start"}, function(result){
		$("#editorForm").html(result); 
	});
});

/*
*	CLICK .submitanode
*		
*		ADD A NODE
* 		Used to "add" a node
*	
*/
$(document).on("click", '.submitanode', function(event) {
	event.preventDefault();
		
	$.post( "nm_includes/nm_create_a_node.php", $("#createnodeform").serialize(), function(result){
	/*$.post("nm_includes/nm_create_a_node.php", {create: "submit"}, function(result){*/
		/** TODO: determine if you want errors to return the old form or replace this one ... **/
		if(result.length > 0){
			$("#editorForm").html(result); 
		}else{
			
		}
		//$(".editorForm").html(result); 
		
	});
});


/*
FRUSTRATING SHIT
*/
$(document).on("click", '.expandanode', function(event) { 
	event.preventDefault();
	var whereAmI = $(this).parent();
	//console.log(whereAmI);
	whereAmI = whereAmI.parent();
	console.log(whereAmI);
	//var nodeYouWillDelete = whereAmI.dataset.nodeid;
	var nodeYouWillExpand = whereAmI.children('div.nodedetailsdiv');
	console.log(nodeYouWillExpand);
	nodeYouWillExpand.fadeToggle();
});
</script>