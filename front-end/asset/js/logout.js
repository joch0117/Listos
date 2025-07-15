// logout deconnexion

import { removeToken } from './token.js';
import { showMessage } from './showMessage.js';

export function logout(){
    removeToken();
    window.location.hash ='#accueil';
    location.reload();
    showMessage('success', "Déconnexion réussie !");
}