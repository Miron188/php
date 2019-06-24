!function(e){"function"!=typeof e.matches&&(e.matches=e.msMatchesSelector||e.mozMatchesSelector||e.webkitMatchesSelector||function(e){for(var t=this,o=(t.document||t.ownerDocument).querySelectorAll(e),n=0;o[n]&&o[n]!==t;)++n;return Boolean(o[n])}),"function"!=typeof e.closest&&(e.closest=function(e){for(var t=this;t&&1===t.nodeType;){if(t.matches(e))return t;t=t.parentNode}return null})}(window.Element.prototype);

   function handleFiles(files){
        $('#modal').removeClass('active');
      //if(files.length == 1 ){
      console.log(files[0].name);

       

            var data = new FormData();
    $.each( files, function( key, value ){
        data.append( key, value );
    });
  
    // Отправляем запрос

    $.ajax({
        url: 'http://diplom/php/tempBD.php?uploadfiles&id='+fk,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'html',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function( respond, textStatus, jqXHR ){
 
            // Если все ОК 
            $.get({url:'http://diplom/php/tempBD.php',
          data: {'action':'addPdf',
                'type': 'pdf',
                'id': fk,
                'name' : files[0].name,
                'acces': 0}})
        .done(function(data){

          $('#folderMain').html(data);
          $('#overlay').removeClass('active');
        }

          );
 
            if( typeof respond.error === 'undefined' ){
                // Файлы успешно загружены, делаем что нибудь здесь
 
                // выведем пути к загруженным файлам в блок '.ajax-respond'
 
                //var files_path = ;
                //alert(respond.files);
            }
            else{
                console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
            }
        },
        error: function( jqXHR, textStatus, errorThrown ){
            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
        }
    });
      };

          // $.post("Scripts/tempBD.php", {'method': 'get'}, function(data){
          //   let answer = data + "<div class='main-box-child-flex subject-box'><span class='dashicons dashicons-media-document box-icon type-text '></span><span class='box-name'>"+files[0].name+"</span></div>";
          //   //console.log(answer);
          //   let a = $.post("Scripts/workDB.php", {'action': 'addFile','type': 'file'});
          //   console.log("post add: "+ a);
          //   getContent(files[0].name, false);
          // });
       //console.log(answer);       

document.addEventListener('DOMContentLoaded', function() {

   /* Записываем в переменные массив элементов-кнопок и подложку.
      Подложке зададим id, чтобы не влиять на другие элементы с классом overlay*/
   var modalButtons = document.querySelectorAll('.js-open-modal'),
       overlay      = document.querySelector('.js-overlay-modal'),
       closeButtons = document.querySelectorAll('.js-modal-close');


      $('#folderMain').on('click', '#modal-butt', function(){    
   
          var modalId = this.getAttribute('data-modal'),         
          modalElem = document.querySelector('.modal[data-modal="' + modalId + '"]');
          //$('#modal').data('connectfk' $(this).data('connectfk'));
         
          //alert('!!!! ' + );
           
            modalElem.classList.add('active');
            overlay.classList.add('active');
      });
   
   closeButtons.forEach(function(item){

      item.addEventListener('click', function(e) {
         var parentModal = this.closest('.modal');

         parentModal.classList.remove('active');
         overlay.classList.remove('active');
      });

   }); // end foreach


    document.body.addEventListener('keyup', function (e) {
        var key = e.keyCode;

        if (key == 27) {
            alert("key");
            document.querySelector('.modal.active').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
        };
    }, false);


    overlay.addEventListener('click', function() {
        document.querySelector('.modal.active').classList.remove('active');
        this.classList.remove('active');
    });    


    //добавление файлов
    $('.my').change(function() {
    if ($(this).val() != '') $(this).prev().text('Выбрано файлов: ' + $(this)[0].files.length);
    else $(this).prev().text('Выберите файлы');
    });
}); // end ready