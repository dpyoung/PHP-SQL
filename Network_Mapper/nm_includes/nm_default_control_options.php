<?php 
/*
*	nm_default_control_options.php
*/
class NMControl{
		
	static function printCreate(){
	?>
		<button class="btn btn-success createanode">Create Node</button>
	<?php
	}

	static function printSubmit(){
	?>
		<button class="btn btn-success submitanode">Submit Node</button> 
	<?php
	}

	static function printCancel(){
	?>
		<button class="btn btn-danger cancelanode">Cancel Node</button>
	<?php
	}

	static function printRefreshMap(){
	?>
		<button class="btn btn-info refreshamap">Refresh Nodes</button>
	<?php
	}

}