// NAVBAR MENU BURGER SCRIPT
function Burgerfunction(x) {
    x.classList.toggle("change");

    var y = document.getElementById("navbar");
    if (y.className == "navbar") {
        y.className += " responsive";
    } else {
        y.className = "navbar";
    }

}
// NAVBAR ACCORDION SCRIPT
var acc = document.getElementsByClassName("accordion");
var dropBtn = document.getElementById("navDropBtn");
var dropContent = document.getElementById("dropContent");
var i;


for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        
        var panel = this.nextElementSibling;
        if (panel.style.display === "flex") {
            panel.style.display = "none";
        } else {
            panel.style.display = "flex";
        }
        
        
    });
}

// TRIANGLE ICON ROTATION
function iconRotate() {
    var icon = document.getElementById("iconRotate");
    icon.classList.toggle("rotate");
}

// GO BACK TOP PAGE BUTTON SCRIPT
var mybutton = document.getElementById("myBtn");

window.onscroll = function () { scrollFunction() };

function scrollFunction() {

    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

