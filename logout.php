<?php
	session_start();
	// Destroying All Sessions
	if(session_destroy())
	{
	// Redirecting To The Login Page
	    header("Location: login.php");
	}
?>