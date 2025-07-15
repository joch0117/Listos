// js login

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
            const response = await fetch('http://localhost/api/login',{
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            const result = await response.json();
            
            if(response.ok){
                localStorage.setItem('jwt',result.token);
                alert("connexion réussi !");
                window.location.hash = "#acceuil";
            }else {
                alert(result.error || "Erreur lors de l'inscription");
            }
        }catch (error){
            alert("Error réseau :"+ error.message);
        }
    });
}