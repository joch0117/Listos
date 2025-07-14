// router.js
//import module dropdown
import { dropdown } from './dropdown.js';
//import module register
import { initRegisterForm } from './register.js';

// Fonction pour charger un partial HTML dans un conteneur (header, app, footer)
export async function loadPartial(containerId, partialFile) {
    const res = await fetch(`partials/${partialFile}`);
    const html = await res.text();
    document.getElementById(containerId).innerHTML = html;
    //module dropdown
            if (containerId === "header") {
        const btn = document.getElementById('dropdownToggle');
        if (btn) dropdown(btn);
    }
    //module inscription
    if(window.location.hash === '#inscription'){
        initRegisterForm();
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
    await loadPartial('footer', 'footer.html');
    await route();
});

// Changement de page (hash change)
window.addEventListener('hashchange', route);
