// logout deconnexion

import { removeToken } from './token.js';
import { showMessage } from './showMessage.js';

export function logout(){
    removeToken();
    showMessage('success', "Déconnexion réussie !");
    setTimeout(()=> {
    window.location.hash ='#accueil';
    location.reload();
    },1200);
}