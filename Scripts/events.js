(function(){
	$('document').ready(function(){
		//alert("asd");

	$('#folderMain').on('click', '#addSubject', function(e){	
	let name = prompt("Введите имя предмета");

	$('#overlay').addClass('active');	

	$.post("http://diplom/php/tempBD.php", {'type':'subject',
	 					'action' : 'addSubject',
	  					'name': name, 'acces': 0},

	  				 function(data){	  	

	  				 	console.log("Subject" + data);
	  					getContent('all', false, 'getAll', 'subject', 1);
	  					$('#overlay').removeClass('active');
	  				});	
	});
});
})();

 function addFolder(){
	//alert("sad");		
	getContent(fk, false, 'addFolder', 'folder', 0, prompt('Введите имя', 'newFolder'+fk));
	$('#modal').removeClass('active');
	};

function addLab(){		
	document.location.href = 'http://diplom/Scripts/labs/labsCreator.php';
	};

function openLab(file){
	//alert($(file).data('connectedfk'));
	$.get(
          {url:'http://diplom/php/tempBD.php',
          data: {'action':'getContest',
                'type': 'lab',
                'id': $(file).data('connectedfk'),
                'name' : 'teacher',
                'acces': 1}})
        .done(function(data ) {  
        	console.log('contest_id = '+data);
        	let url = encodeURIComponent("SID=b98ef99e4c0da1ad&action=139&prob_id="+data);
        	let href = "http://diplom/studentTask.php/?url="+url;
        	window.open(href);
        });
};	

function pdfViwer(file){
	let name = file.parentNode.textContent;
	let href = "http://diplom/uploads/"+ document.getElementById('modal-butt').getAttribute('data-connectfk') +"/" + name.replace(/['"]+/g,'');
	
	window.open(href);
	//console.log($('box-name').innerText);
	//alert(file.innertext);
};



function clickMember(){
	window.location.href = "http://diplom/Scripts/auth-reg/profile.php";
};

function logout(){
	window.location.href = "http://diplom/Scripts/auth-reg/logout.php";
};



