<?php 
require_once 'connect.php';
session_start(); 

$mysqli = new mysqli($host,
        $user,
        $password,
        $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
};

$method = $_SERVER['REQUEST_METHOD'];

$data = array();
if( isset($_GET['uploadfiles'])){
	writeLog('открылось');

    $error = false;
    $files = array();
 	$dir2 =$_GET['id'];
    $uploaddir = '../uploads/'.$dir2.'/'; 
 	writeLog($uploaddir);
    // Создадим папку если её нет
 
    if(!is_dir($uploaddir)){
    	mkdir( $uploaddir, 0777);
    }
    	
    foreach( $_FILES as $file ){
    	writeLog(basename($file['name']));
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = realpath( $uploaddir . $file['name'] );
        }
        else{
            $error = true;
        }
    }
 
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
 
   // writeLog( $data );
}

switch ($method) {
  case 'POST':
  if(isset($_POST)){
  	  getTemplateHTML($_POST['action'], $_POST['type']); 
  	};
    break;
  case 'GET':
    if(isset($_GET)){
  	  getTemplateHTML($_GET['action'], $_GET['type']); 
  	}; 
    break;
  default:
    echo 'ОШИБКА В КОНТРОЛЛЕРЕ';
    break;
};

if(isset($_GET['commit'])){
	header('Refresh: 0; url=http://diplom');
 	echo "Recoded. Wait, please";
 	addFile();
};	

function writeLog($message){
	$fd = fopen("log.txt", 'a') or die("не удалось создать файл");
	fwrite($fd, $message);
	fclose($fd);
};

function getTemplateHTML($action, $type){
	switch ($type) {
		case 'subject':
			switch ($action) {
			 case 'getAll':
				getAllSubjects();
				break;
			  case 'addSubject':		
				addSubject();		
				break;
				}
			break;

		case 'folder':
			switch ($action) {
			  case 'openFolder':
				openFolder();
			  break;
			  case 'addFolder':		
				addFolder();		
			  break;
			}
		break;
			

		case 'pdf':
			switch ($action) {
			  case '---':
				openFolder();
			  break;
			  case 'addPdf':		
				addFile();		
			  break;
			}
			break;

		case 'lab':
			switch ($action) {
			  case 'addLab':
				addFile();
			  break;
			  case 'getContest':		
				getContest();	
			  break;
			}
			break;
	};
};
// function addLab(){
// }
function getContest(){	
	global $mysqli;
	global $templateHTML;
	session_start();

	$result = $mysqli->query("SELECT contest_id FROM file_new WHERE connectFk LIKE '".$_GET['id']."' AND creator LIKE '".$_GET['name']."'", MYSQLI_USE_RESULT);
			if ($mysqli->errno) {
				writeLog('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
				die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
			};
	while ($row = $result->fetch_assoc()) {

	  	    echo $row[contest_id];
	};
};

function addFile(){
	global $mysqli;
	session_start();
	$creator = $_SESSION['login'];
	$name = $_GET['name'];
	$acces = $_GET['acces'];
	$type = $_GET['type'];
	$date = date('Y/m/d');
	$id = $_GET['id'];
		if(!$id){
			writeLog('connectFk пуст '. $id);
			die();
		}

	//mkdir("$creator");
	//writeLog(' |   '.$creator. ' '.$name.' '.$acces+'     | ');

	$sql ='INSERT INTO file_new (connectFk, name, creator, acces, type, createdAt, contest_id) VALUES ("'.$id.'","'.$name.'", "'.$creator.'", "'.$acces.'", "'.$type.'", "'.$date.'","'.$_GET[contest_id].'")';

			if (mysqli_query($mysqli, $sql)) {
			      openFolder();

			} else {
			      echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
			      writeLog("Error: " . $sql . "<br>" . mysqli_error($mysqli));
			};

};


function addFolder(){
	global $mysqli;
	session_start();
	$creator = $_SESSION['login'];
	$name = $_GET['name'];
	$acces = $_GET['acces'];
	$date = date('Y/m/d');
	$id = $_GET['id'];
		if(!$id){
			writeLog('connectFk пуст '. $id);
			die();
		}
	//writeLog(' |   '.$creator. ' '.$name.' '.$acces+'     | ');
	$sql ='INSERT INTO folder_new (connectFk, name, creator, acces, createdAt) VALUES ("'.$id.'","'.$name.'", "'.$creator.'", "'.$acces.'", "'.$date.'")';

			if (mysqli_query($mysqli, $sql)) {
			      echo openFolder();
			} else {
			      echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
			      writeLog("Error: " . $sql . "<br>" . mysqli_error($mysqli));
			};
};



function openFolder(){

	$code_addFolderButton = "<div class = 'main-box-child-flex subject-box' ><span class='dashicons dashicons-plus box-icon type-add js-open-modal historyAPI' data-connectFk = '".$_GET['id']."'  data-modal='1' id='modal-butt' ></span><span class='box-name'>Add</span></div>";

	global $mysqli;
	global $templateHTML;
	$result = $mysqli->query("SELECT * FROM folder_new WHERE connectFk LIKE '".$_GET['id']."'", MYSQLI_USE_RESULT);
			if ($mysqli->errno) {
				die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
			};
	while ($row = $result->fetch_assoc()) {
	  	    echo ("<div class='main-box-child-flex subject-box'>
						<a href='".$row[id]."' name ='".$row[name]."' 
						class='dashicons dashicons-category box-icon type-folder historyAPI'></a>
						<span class='box-name'>'".$row[name]."'</span></div>");
	};
	$result = $mysqli->query("SELECT * FROM file_new WHERE connectFk LIKE '".$_GET['id']."'", MYSQLI_USE_RESULT);
			if ($mysqli->errno) {
				die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
			};
	while ($row = $result->fetch_assoc()) {
		if($row['type'] == 'pdf'){
			echo ("<div class='main-box-child-flex subject-box'><span class='dashicons dashicons-media-document box-icon type-text' data-connectedFk = '".$row['connectFk']."' onclick = 'pdfViwer(this)'></span><span class='box-name'>'".mb_strimwidth($row[name], 0, 12)."'<span class = 'invisible'>'".mb_strimwidth($row[name], 12, 100)."'</span></span></div>");
		}
		if($row['type'] == 'lab'){
			echo ("<div class='main-box-child-flex subject-box'><span class='dashicons dashicons-desktop box-icon type-text' data-connectedFk = '".$row['connectFk']."' onclick = 'openLab(this)'></span><span class='box-name'>'".mb_strimwidth($row[name], 0, 12)."'<span class = 'invisible'>'".mb_strimwidth($row[name], 12, 100)."'</span></span></div>");
		}
	}
	session_start();
	if($_SESSION['rights']>1){
		echo $code_addFolderButton;
	}

};


function addSubject(){				

			global $mysqli;
			session_start();
			$creator = $_SESSION['login'];

			$name = $_POST['name'];
			$acces = $_POST['acces'];

			//writeLog(' |   '.$creator. ' '.$name.' '.$acces+'     | ');

			$sql ='INSERT INTO subject_new (name, creator, acces) VALUES ("'.$name.'", "'.$creator.'", "'.$acces.'")';

			if (mysqli_query($mysqli, $sql)) {
			      echo "New record created successfully";
			} else {
			      echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
			};
};

function getAllSubjects(){
	global $mysqli;
		$result = $mysqli->query("SELECT id, name, acces FROM subject_new", MYSQLI_USE_RESULT);
			if ($mysqli->errno) {
				die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
			};

	while ($row = $result->fetch_assoc()) {
	  	    echo ('<div class="main-box-child-flex box">
					<a href="'.$row['id'].'" class = "main-box-ref centering-inline historyAPI" name ='.$row['name'].'>
						<span class="main-box-name" name="'.$row['name'].'" data-acces ="'.$row['acces'].'">'.$row['name'].'</span>
					</a>
				</div>');
	}
	session_start();
		if($_SESSION['rights']>1){
			echo('<div class="main-box-child-flex box add centering-inline" id = "addSubject" data-acces = "0"><span class="dashicons dashicons-plus plus"></span></div>');
		}			
	};

	function getSubjects($name){
		$result = $mysqli->query("SELECT content, acces FROM subject_new WHERE name LIKE '".$name."'' ", MYSQLI_USE_RESULT);
			if ($mysqli->errno) {
				die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
			};

	while ($row = $result->fetch_assoc()) {
	  	    echo ('<div class="main-box-child-flex box">
					<a href="'.$row['name'].'" class = "main-box-ref centering-inline historyAPI" name ='.$row['name'].'>
						<span class="main-box-name" name="'.$row['name'].'" data-acces ="'.$row['acces'].'">'.$row['name'].'</span>
					</a>
				</div>');
	}
	session_start();
	if($_SESSION['rights']>1){
		echo('<div class="main-box-child-flex box add centering-inline" id = "addSubject" data-acces = "0"><span class="dashicons dashicons-plus plus"></span></div>');		
	}			
};	
?>