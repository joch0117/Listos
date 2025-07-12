//fonction pour le menu page d'acceuil dropdown menu
console.log("Acceuil");

//dropdown menu
document.addEventListener('DOMContentLoaded',function(){
    const btn = document.getElementById("dropdownToggle");
    const menu = btn.parentNode;
    btn.addEventListener("click", function(e){
        console.log("bouton clické")
        menu.classList.toggle("open");
    });
});