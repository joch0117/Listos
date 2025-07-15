//fonction pour le menu page d'acceuil dropdown menu

export function dropdown(btn){
  if (!btn) return;
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
