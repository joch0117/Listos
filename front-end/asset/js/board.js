//class gestion tableau

export default class Board {
    constructor({
        id= null,
        title="Nouveau tableau",
        created_at = null,
        user_id = null,
        task_lists = []
    }= {}){
        this.id = id || Date.now().toString()+ Math.floor(Math.random()*10000).toString();
        this.title = title;
        this.created_at = created_at || new Date().toISOString();
        this.user_id = user_id;
        this.task_lists = task_lists;
    }

    setTitle(newTitle){
        this.title = newTitle.trim() || 'Sans titre';
    }

    setId(newId){
        this.id = newId;
    }

    addTaskList(taskList){
        this.task_lists.push(taskList);
    }
}