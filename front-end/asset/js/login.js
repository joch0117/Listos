// js login
import { saveToken } from './token.js';
import { showMessage } from './showMessage.js';

export function initLogin(){
    const form = document.querySelector('form');
    if(!form) return;

    form.addEventListener('submit',async function(e){
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        const data = {
            email,
            password
        }

        try{
            const response = await fetch('http://localhost/api/login_check',{
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            let result = null
            try{
            result = await response.json();
            }catch(e){
                result = {};
            }

            if(response.ok){
                saveToken(result.token);
                showMessage('success', "Connexion réussie !");
                window.location.hash = "#accueil";
            }else {
                showMessage(result.error || "Erreur lors de la connexion");
            }
        }catch (error){
            showMessage('error', result.error || "Erreur lors de la connexion");
        }
    });
}