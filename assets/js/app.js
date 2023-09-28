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

    $("#addTaskForm").submit(function(event){
        event.preventDefault();

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

        if(!error){
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'app/ajax/task/add.task.php',
                data: formData,
                beforeSend: function() {
                    $(".add").append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></i></div>');
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    removeLoader();
                }
            });
        }
        
    });
}