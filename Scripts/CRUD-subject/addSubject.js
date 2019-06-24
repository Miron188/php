function addClick(){
	$('#overlay').addClass('active');
	let name = prompt("Введите имя предмета");

	//let code = '<div href = ' + '"' + name + '"' +' class="main-box-child-flex box historyAPI"><a href="'+ name +'"class = "main-box-ref centering-inline" name ="' +name+ '""><span class="main-box-name" name=' +name+ '>' +name+ '</span></a></div>';
	$('#addSubject').before(
				$.post("http://diplom/php/workDB.php",
				 {'add': 1, 'name': name, 'type': 'subject', 'acces': 0})
				);
	getContent('all', false);
	$('#overlay').removeClass('active');
};

