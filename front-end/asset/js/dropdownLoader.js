//gestion dynamique menu connexion /deconnexion

import {isLoggedIn,getToken,decodeToken } from './token.js';
import { logout } from './logout.js';
import { dropdown } from './dropdown.js';

export async function loadDropdownMenu(){
    const container = document.getElementById('dropdownMenuContainer');
    if (!container) return;

    const file = isLoggedIn() ? 'dropdown-logged.html' : 'dropdown-guest.html';
    const res = await fetch(`partials/${file}`);
    container.innerHTML  = await res.text();

    const btn = document.getElementById('dropdownToggle');
    if(btn) dropdown(btn);

    if(isLoggedIn()){
        const logoutLink = document.getElementById('logoutLink');
        if(logoutLink){
            logoutLink.addEventListener('click', function(event){
                event.preventDefault();
                logout();
            })
        }
    }
}