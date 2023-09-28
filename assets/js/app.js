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
}