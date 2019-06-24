<?
require_once('../auth-reg/checkAuth.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>labsCreator</title>
		<link rel="stylesheet" href="http://diplom/Styles/reset.css">
		<link rel="stylesheet" href="http://diplom/Styles/dashicons.css">
		<link rel="stylesheet" href="http://diplom/Styles/style.css">
		<link rel="stylesheet" href="http://diplom/Scripts/labs/labsCreatorStyle.css">
		<script src="http://diplom/Scripts/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="header-back"></div>


<!-- HEADER -->
<?php
require_once('../../pages/header.php');
?>
<!-- HEADER -->


<div class = "main-container">
	<article></article>
	<main>
		<div class="main-box-parent-flex login" id = "folderMain">

  <section class="container">
    	
      <h1>Создание новой лабораторной работы</h1>

      <form action="http://diplom/php/tempBD.php" method="get" id="createLabForm">
      	<!-- <p><span>Предмет</span></p>
      	<p><input type="text" name="subject-name" value="" placeholder="Введите предмет"></p> -->
		<input hidden type="number" name="id" value="<?php echo $_GET['fk']; ?>" required>

      	<p><span>Название</span></p>
      	<p><input type="text" name="name" placeholder="Введите название" required></p>

      	<p><span>Преподаватель</span></p>
      	<p><span  type = "text" name="login" class="static"><?php echo $_SESSION['login']; ?></span></p>
		
		<input hidden type="tet" name="type" value="lab" required>

      	<p><span>Индификатор</span></p>
   		<div class="input" id="cor5"> 
   			<input type="text" id="posAdult" name="contest_id" required /> 
				   <script type="text/javascript"> 
				    var input = document.getElementById('posAdult'), 
				        parent = input.parentNode, 
				        select = document.createElement('SELECT'); 
				     
				    select.id = input.id; 
				    select.name = input.name; 			
				    select.options.add(new Option('1')); 
				    select.options.add(new Option('2')); 
				    select.options.add(new Option('3')); 
				     
				    parent.insertBefore(select, input); 
				    parent.removeChild(input); 
				</script> 
		</div>  
		
      	<p><span>Открытие</span></p>
        <p><input type="date" name="date-open"></p>

        <p><span>Закрытие</span></p>
        <p><input type="date" name="date-closed"></p>
		
		<p><span>Доступ</span></p>
      	<p><input type="number" name="acces" placeholder="Введите индификатор задачи" required></p>
   
      	<p><span>Задача</span></p>
      	<p><textarea name="comment" placeholder="Введите текст задачи"></textarea></p>

      	<!-- <p><span>Тесты решения</span></p>
      	<p><input type="file" name="tests" value="" placeholder="Введите имя"></p>
 -->
         <p class="submit" ><input type="submit" name="commit" value="Отправить" id = "submitButt" multiple></p>
      </form>  
   
  </section>

     <!--   <p><span>Доступ для</span></p>
   		<div class="input" id="cor5"> 
   			<input type="text" value="" id="access" name="description"/> 
				   <script type="text/javascript"> 
				    var input = document.getElementById('posAdult'), 
				        parent = input.parentNode, 
				        select = document.createElement('SELECT'); 
				     
				    select.id = input.id; 
				    select.name = input.name; 
				    select.options.add(new Option('all'));     
				    select.options.add(new Option('1')); 
				    select.options.add(new Option('2')); 
				    select.options.add(new Option('3')); 
				     
				    parent.insertBefore(select, input); 
				    parent.removeChild(input); 
				</script> 
		</div>   -->

      <!--   <p class="invisible password"><span>Пароль</span></p>
        <p class="invisible password"><input type="password" name="password" value="" placeholder="Password"></p>
        	<p class="remember_me">
          		<label>
	            	<input type="checkbox" name="remember_me" id="needPasswordf" onchange="needPassword()">
	           		Мне нужен пароль
          		</label>
        	</p> -->

<!-- 			<form action="" id="labsCreatorForm">

				<span class="name">Название работы:</span>
				<input type="text">
				<br>
				<span class="name">Создатель:</span>
				<span><?php echo $_SESSION['login']; ?></span>
				<br>
				<span class="name-text-task">Задание лабораторной:</span>
				<br>
				<input type="text" class="text-task">

				<span class="name">Доступно для</span>
				<input type="text">
				
				<span class="name">Время начала/конца</span>
				<input type="text">
			</form>	 -->	

		</div>	

	</main>

</div>
<script src ="http://diplom/Scripts/events.js"></script>
<!-- <script src ="http://diplom/Scripts/ajax_history.js "></script> -->
<script src ="http://diplom/Scripts/labs/labsCreatorScript.js"></script>
</body>
</html>