//fonction pour le menu page d'acceuil dropdown menu
console.log("Acceuil");


function dropdown(){
//dropdown menu ouverture


document.addEventListener('DOMContentLoaded',function(){
    const btn = document.getElementById("dropdownToggle");
    const menu = btn.parentNode;
    btn.addEventListener("click", function(e){
        menu.classList.toggle("open");
    });
});

document.addEventListener('DOMContentLoaded', function() {
  const btn = document.getElementById("dropdownToggle");
  const menu = btn.parentNode;

  // Ouvre/ferme le menu au clic sur le bouton
  btn.addEventListener("click", function(e){
    menu.classList.toggle("open");
    e.stopPropagation(); // Empêche le clic de remonter au document
  });

  // Ferme le menu si on clique ailleurs
  document.addEventListener("click", function(e) {
    if (!menu.contains(e.target)) {
      menu.classList.remove("open");
    }
  });
});

}

dropdown();
