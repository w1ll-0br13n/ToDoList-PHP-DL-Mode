/* DOMContentLoaded */  
$(document).ready(main)

function main() {
    /* switch theme light-dark */
    $("#switch-theme").click(function(){
        $("body").toggleClass("light");
        const themeImg = this.children[0];
        themeImg.setAttr(
        "src",
        themeImg.getAttr("src") === "./assets/icons/icon-sun.svg"
            ? "./assets/icons/icon-moon.svg"
            : "./assets/icons/icon-sun.svg"
        );
    });

    $("#add-task").click(() => {
        taskHandler('app/ajax/task/add.task.php')
    });
    $("#update-task").click(() => {
        taskHandler('app/ajax/task/update.task.php', false)
    });

    function taskHandler(url, create=true){

        const title = $("#title").val();
        const desc = $("#desc").val();

        var error = false;
        if(title == ""){
            $(".form-group.title span").html("Required field");
            removeErrorMessage();
            error = true;
        }

        if(title.length > 255){
            $(".form-group.title span").html("Title too long. (max: 255)");
            removeErrorMessage();
            error = true;
        }

        if(desc.length > 500){
            $(".form-group.desc span").html("Description too long. (max: 500)");
            removeErrorMessage();
            error = true;
        }

        var cattr = (!create) ? $("#update-task").attr('cattr') : ''; 

        if(!error){
            $.ajax({
                type: 'POST',
                url: url,
                data: (create) ? {title : title, description : desc} : {title : title, description : desc, cattr : cattr},
                beforeSend: function() {
                    $(".add").append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div>');
                },
                success: function() {
                    if(create) {
                        location.reload();
                    }else{
                        path = window.location.pathname;
                        window.location.href = path;
                    }
                },
                error: function() {
                    removeLoader();
                }
            });
        }
        
    }

    function removeErrorMessage(){
        setTimeout(function(){
            $(".error-text").html('');
        }, 4000);
    }

    function removeLoader(){
        setTimeout(function(){
            $(".card-loader").remove();
        }, 500)
    }
}

function toogleCheck(element){
    const status = $(element).attr('checked');
    const cattr = $(element).attr('cattr');
    
    var newStatus = (typeof status !== 'undefined' && status !== false) ? false : true;
    $.ajax({
        type: 'POST',
        url: 'app/ajax/task/status.task.php',
        data: {newStatus : newStatus, cattr : cattr},
        beforeSend: function() {
            $(".todos").append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div>');
        },
        success: function() {
            location.reload();
        },
        error: function() {
            removeLoader();
        }
    });

};