<?
require_once('checkAuth.php');
print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
		<link rel="stylesheet" href="http://diplom/Styles/profile.css">
		<link rel="stylesheet" href="http://diplom/Styles/reset.css">
		<link rel="stylesheet" href="http://diplom/Styles/dashicons.css">
		<link rel="stylesheet" href="http://diplom/Styles/style.css">
		<link rel="stylesheet" href="http://diplom/Scripts/teachers/modalWin.css">
		<link rel="stylesheet" href="http://diplom/Scripts/teachers/styles-modal.css">
	<script src="http://diplom/Scripts/jquery-3.3.1.min.js"></script>

</head>
<body>
	<div class="header-back"></div>

<?php
require_once('../../pages/header.php');
?>
		
	 <div class = "main-container">
		<article>
		</article>

		<main>

			<div class = "main-title">
				<span class ="dashicons dashicons-welcome-learn-more main-icon"></span>
					<h2>Личный кабинет</h2>					
			</div>

			<div class="main-box-parent-flex" id = "folderMain">			
				<div class = "profile-info">	
							
					<img id = "img" src="http://diplom/Img/users/<?php echo $_SESSION['login']; ?>.jpg" alt="profile photo">				
					<span class="txt name">Логин</span> 
					<span class="txt value"><?echo $_SESSION['login'];?></span>
					<br>
					<span class="txt name">Статус</span>
					<span class="txt value">админ</span>
				</div>	
				<button onclick="logout()">Выйти из профиля</button>				
			</div>
			
		</main>


	</div>

</body>
<script src="http://diplom/Scripts/auth-reg/member.js"></script>
</html>