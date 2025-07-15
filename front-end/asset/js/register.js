//js/register

export function initRegisterForm(){
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit',async function(e){
        e.preventDefault();

        const pseudo = document.getElementById('pseudo').value.trim();
        const name = document.getElementById('name').value.trim();
        const prenom = document.getElementById('prenom').value.trim();
        const email = document.getElementById('email').value.trim();
        const plainPassword = document.getElementById('plainPassword').value.trim();
        const verifPassword = document.getElementById('verifPassword').value.trim();

        if (plainPassword != verifPassword){
            alert("Les mots de passes ne correspondent pas !");
            return;
        }


        const data = {
            pseudo,
            name,
            prenom,
            email,
            plainPassword
        };

        try{
            const response = await fetch('http://localhost/api/register',{
                method: 'POST',
                headers: { 'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            });
            const result = await response.json();

            if(response.ok){
                localStorage.setItem('jwt', result.token);
                alert("Inscription réussi !");
                window.location.hash = "#accueil";
            }else{
                alert(result.error || "Erreur lors de l'inscription");
            }
        }catch (error){
            alert("Error réseau :" + error.message);
        }
    });
}