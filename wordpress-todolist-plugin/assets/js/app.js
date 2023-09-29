/* DOMContentLoaded */  
$(document).ready(main)

function main() {
    /* switch theme light-dark */
    $("#switch-theme").click(function(){
        if (document.body.classList.contains('dark')) {
            setTheme('light');
        } else {
            setTheme('dark');
        }

    });
    
    const userPreference = localStorage.getItem('theme');

    if (userPreference) {
        setTheme(userPreference);
    }

    $("#add-task").click(function() {
        taskHandler(this, 'app/ajax/task/add.task.php', true)
    });
    
    $("#update-task").click(function() {
        taskHandler(this, 'app/ajax/task/update.task.php', false, true)
    });
    
    $(".delete-task").click(function() {
        taskHandler(this, 'app/ajax/task/remove.task.php', false, false, true)     
    });
}

function setTheme(theme) {
  document.body.className = theme;
  // Store the user's preference in local storage
  localStorage.setItem('theme', theme);
  $("#switch-theme img").attr(
    "src",
    theme === "light"
        ? "./assets/icons/icon-moon.svg"
        : "./assets/icons/icon-sun.svg"
    );
}

function taskHandler(element, url, createme=false, updateme=false, deleteme=false){

    error = false;
    const title = $("#title").val();
    const desc = $("#desc").val();

    var error = false;
    if(title == "" && createme){
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

    var cattr = (!createme) ? $("#update-task").attr('cattr') : ''; 

    var formData;

    if(createme)
        formData = {title : title, description : desc}

    if(updateme)
        formData = {title : title, description : desc, cattr : cattr}

    if(deleteme){
        cattr = $(element).attr('cattr');
        formData = {cattr : cattr};
    }

    if(!error){
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            beforeSend: function() {
                if(!deleteme)
                    $(".add").append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div>')
            },
            success: function(response) {

                if(createme)
                    location.reload()
                
                if(updateme){
                    path = window.location.pathname;
                    window.location.href = path;
                };
                
                if(deleteme)
                    $(element).parent().remove()

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