import { getToken } from '../token.js';

export default class TaskListApi{
    constructor(apiUrl){
        this.apiUrl = apiUrl || 'http://localhost/api/task_lists';
    }

    get headers() {
        return{
            'Content-Type':'application/json',
            'Authorization':'Bearer '+ getToken()
        };
    }
//get
    async fetchTaskLists(){
        const res = await fetch(this.apiUrl,{
            headers:this.headers
        });
        if(!res.ok) throw new Error('Erreur chargement listes');
        return await res.json();
    }
    //post

    async addTaskList(data){
        const res = await fetch(this.apiUrl,{
            method: 'POST',
            headers: this.headers,
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur ajout liste');
        return await res.json();
    }
    //DELETE
    async deleteTaskList(id){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'DELETE',
            headers: this.headers,
        });
        if (!res.ok) throw new Error('Erreur supression liste');
    }
    //patch
    async updateTaskList(id,data){
        const res = await fetch(`${this.apiUrl}/${id}`,{
            method: 'PATCH',
            headers: {  
                ...this.headers,
                'Content-Type': 'application/merge-patch+json'
            },
            body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error('Erreur modification liste');
        return await res.json();
    }
}