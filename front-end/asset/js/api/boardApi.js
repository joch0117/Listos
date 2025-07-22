import { getToken } from '../token.js';

export default class BoardApi{
    constructor(apiUrl){
        this.apiUrl = apiUrl || 'http://localhost/api/boards';
    }

    get headers() {
        return{
            'Content-Type':'application/ld+json',
            'Authorization':'Bearer '+getToken()
        };
    }
//get
    async fetchBoard(){
        const res = await fetch(this.apiUrl,{
            headers:this.headers
        });
        if(!res.ok) throw new Error('Erreur chargement boards');
        return await res.json();
    }
    
    
    //post
    async addBoard(data){
        const res = await fetch(this.apiUrl,{
            method: 'POST',
            headers: this.headers,
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur ajout board');
        return await res.json();
    }
    //DELETE
    async deleteBoard(id){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'DELETE',
            headers: this.headers,
        });
        if (!res.ok) throw new Error('Erreur supression board');
    }
    //patch
    async updateBoard(id,data){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'PATCH',
            headers: {  
                ...this.headers,
                'Content-Type': 'application/merge-patch+json'
            },
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur modification board');
        return await res.json();
    }
}