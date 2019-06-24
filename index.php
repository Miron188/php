<?
require_once('Scripts/auth-reg/checkAuth.php');
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Main</title>
		<link rel="stylesheet" href="http://diplom/Styles/reset.css">
		<link rel="stylesheet" href="http://diplom/Styles/dashicons.css">
		<link rel="stylesheet" href="http://diplom/Styles/style.css">
		<link rel="stylesheet" href="http://diplom/Styles/style_subjects.css">
		<link rel="stylesheet" href="http://diplom/Scripts/teachers/modalWin.css">
		<link rel="stylesheet" href="http://diplom/Scripts/teachers/styles-modal.css">

		<script src="http://diplom/Scripts/jquery-3.3.1.min.js"></script>


</head>
<body>
	<div class="header-back"></div>

<?php
require_once('pages/header.php');
?>

<div class = "main-container">
	<article>
		<?php
		session_start();
			if($_SESSION['rights']>1){
			require_once('pages/sidebar.php');
			}
		?>
	</article>
<main>

	<div class = "main-title" id = "marker">
		<span class ="dashicons dashicons-welcome-learn-more main-icon" oncl></span>
			<a href="/"><h2>Дисциплины:</h2></a>
	</div>

		<div class="main-box-parent-flex" id = "folderMain">
			<div class="main-box-child-flex box add centering-inline" id = "addSubject">
				<span class="dashicons dashicons-plus plus"></span>
			</div>
		</div>	

</main>
</div>

<?php
require_once('pages/footer.php');
?>

<script src="http://diplom/Scripts/ajax_history.js"></script> 
<script src ="http://diplom/Scripts/events.js"></script>
<script src = "http://diplom/Scripts/teachers/addFile.js"></script>
</body>
</html>