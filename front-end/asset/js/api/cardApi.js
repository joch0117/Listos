import { getToken } from '../token.js';

export default class CardApi{
    constructor(apiUrl){
        this.apiUrl = apiUrl || 'http://localhost/api/maps';
    }

    get headers() {
        return{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+getToken()
        };
    }
    //get
    async fetchCards(){
        const res = await fetch(this.apiUrl,{
            headers:this.headers
        });
        if(!res.ok) throw new Error('Erreur chargement cards');
        return await res.json();
    }
    //post

    async addCard(data){
        const res = await fetch(this.apiUrl,{
            method: 'POST',
            headers: this.headers,
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur ajout card');
        return await res.json();
    }
    //DELETE
    async deleteCard(id){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'DELETE',
            headers: this.headers,
        });
        if (!res.ok) throw new Error('Erreur supression card');
    }
    //patch
    async updateCard(id,data){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'PATCH',
            headers: {  
                ...this.headers,
                'Content-Type': 'application/merge-patch+json'
            },
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur modification card');
        return await res.json();
    }
}