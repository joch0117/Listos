export default class List {
    constructor({
        id= null,
        title="Nouvelle tache",
        created_at = null,
        user_id = null,
        list_id = null
    }= {}){
        this.id = id || Date.now().toString()+ Math.floor(Math.random()*10000).toString();
        this.title = title;
        this.created_at = created_at || new Date().toISOString();
        this.user_id = user_id;
        this.list_id = list_id;
        this.board= board;
    }

    setTitle(newTitle){
        this.title = newTitle.trim() || 'Sans titre';
    }

    setId(newId){
        this.id = newId;
    }

    addCard(cards){
        this.cards.push(cards);
    }
}