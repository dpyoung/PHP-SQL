<?php 

/********************************************************************************
*	INPUT ERROR REDIRECT HELPER FUNCTION
*		Note: redirects only work before page content loads.
*
*	redirect('http://your.site');
********************************************************************************/
function redirect($url, $statusCode = 303){
	header('Location: ' . $url, true, $statusCode);
	die();
}

/********************************************************************************
*	FILTER INPUT FUNCTION
*		Function restricts data overall length, trims whitespace, escapes, returns
********************************************************************************/
function test_input($data) {
	if(strlen($data) > 65535)
	{	/*SPAM GUARD*/
		fwrite(STDERR, "An error occurred. Check the length of your input.\n");
		exit(1); // A response code other than 0 is a failure
	}
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>