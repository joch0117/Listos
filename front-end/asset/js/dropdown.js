//fonction pour le menu page d'acceuil dropdown menu
console.log("Acceuil");

selector=document.getElementById('dropdownToggle')

function dropdown(btn){
  if (!btn) return;
  console.log(btn)
  let menu = btn.parentNode;

  btn.addEventListener("click", function(e){
    menu.classList.toggle("open");
    e.stopPropagation();
  })

  document.addEventListener("click",function(e){
    if(!menu.contains(e.target)){
      menu.classList.remove("open");
    }
  })
}

dropdown(selector);
