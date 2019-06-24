<?
	session_start();
	print_r($_SESSION);

		if($_SESSION['rights'] < 2) {
			//header('location: login.php');
			exit;
		}
	
?>