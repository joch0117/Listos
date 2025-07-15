// gestion des tokens

// sauvegarde le token en local storage
export function saveToken(token){
    localStorage.setItem('jwt',token);
}
// récupére le token depuis local storage
export function getToken(){
    return localStorage.getItem('jwt');
}

//suprime le token
export function removeToken(){
    localStorage.removeItem('jwt');
}

//vérifie si connecté (= token présent et décodable)
export function isLoggedIn(){
    const token = getToken();
    if(!token) return false;
    try {
        const payload = decodeToken(token);

        if (payload && payload.exp){
            const now = Math.floor(Date.now()/1000);
            return payload.exp > now;
        }
        return true;
    }catch{
        return false;
    }
}

//décode le jwt (Base64)
export function decodeToken(token){
    const payload = token.split('.')[1];
    if(!payload) return null;

    let base64 = payload.replace(/-/g,'+').replace(/ _/g,'/');

    while (base64.lenght % 4){
        base64 += '=';
    }
    try{
        return JSON.parse(atob(base64));
    }catch (e){
        return null;
    }
}
