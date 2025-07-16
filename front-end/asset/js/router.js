// router.js
//module dropdow connecté/déconnecté
import { loadDropdownMenu } from './dropdownLoader.js';
//module connexion
import { initLogin } from './login.js';
//import module register
import { initRegisterForm } from './register.js';
//import class BoardManager
import BoardManager from './boardManager.js';

let boardManagerInstance = null;

// Fonction pour charger un partial HTML dans un conteneur (header, app, footer)
export async function loadPartial(containerId, partialFile) {
    const res = await fetch(`partials/${partialFile}`);
    const html = await res.text();
    document.getElementById(containerId).innerHTML = html;
    //module inscription
    if(window.location.hash === '#inscription'){
        initRegisterForm();
    }
    //module connexion
    if(window.location.hash === '#connexion'){
        initLogin();
    }
    //import class gestion board
    if (window.location.hash === '#tableau') {
    boardManagerInstance = new BoardManager();
    boardManagerInstance.init();
    }
}

export async function route() {
  // Récupère le hash de l’URL (ex : #connexion, #tableau, etc.)
    const page = window.location.hash.replace('#', '') || 'accueil';
    await loadPartial('app', `${page}.html`);

}

// Chargement initial du header/footer et de la page courante
window.addEventListener('DOMContentLoaded', async () => {
    await loadPartial('header', 'header.html');
    await loadDropdownMenu();
    await loadPartial('footer', 'footer.html');
    await route();
});

// Changement de page (hash change)
window.addEventListener('hashchange', async () =>{
    await loadDropdownMenu();
    await route();
});
