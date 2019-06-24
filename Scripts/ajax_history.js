    
    // Для добавления обработчика элименту нужно добавить class = historyAPI и href = {имя}
var fk;

    $('document').ready(function(){
        //alert("обновимся");
        getContent('all', false, 'getAll', 'subject', 1);

        $('#folderMain').on('click', '.historyAPI', function(e){            
            e.preventDefault();
            let href = $(this).attr('href');

            // console.log('href(id) = ' + href); 

            // console.log('e - '+e);

            // console.log('id '+$(this).attr("id"));

            // console.log('fk '+$(this).data('connectfk'));

            if(($(this).attr("id")) == "modal-butt"){
                fk = $(this).data('connectfk');

                console.log('fk = '+$(this).data('connectfk'));
               // getContent($(this).data('connectfk'), false, 'addFolder', 'folder', 0, prompt("Введите имя"));
            }
                else {
                    console.log('history');
                getContent(href, true, 'openFolder', 'folder', 0, $(this).attr('name'));             
                }
            
        });
    });


// Adding popstate event listener to handle browser back button
    window.addEventListener("popstate", function(e) {
        console.log("popstate    " + location.pathname.slice(1));
// Get State value using e.state
        getContent(location.pathname.slice(1), false);
    });


    function getContent(href, addEntry, action, type, acces, name) {
        $('#overlay').addClass('active');        

        $.get(
          {url:'http://diplom/php/tempBD.php',
          data: {'action':action,
                'type': type,
                'id': href,
                'name' : name,
                'acces': acces}})
        .done(function(data ) {  
        //console.log("data get folder- "+ data);  

// Updating Content on Page
        $('#folderMain').html(data);

        if(addEntry == true) {
// Add History Entry using pushState
        history.pushState(null, null, name);}

        $('#overlay').removeClass('active');
    });
};
