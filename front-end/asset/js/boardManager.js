import Board from './board.js';

export default class BoardManager {
    constructor(){
        this.boards = [];
        this.currentBoardId = null;
    }

    addBoard(title = 'Nouveau tableau'){
        const board = new Board({title});
        this.boards.push(board);
        this.renderBoards();
        this.selectBoard(board.id);
    }

    renderBoards(){
        const sidebarList = document.querySelector('.board-list');
        if (!sidebarList) return;
        sidebarList.innerHTML = '';
        this.boards.forEach(board => {
            const li = document.createElement('li');
            li.className = 'board-list-item';
            li.dataset.boardId = board.id;
            li.innerHTML = 
            `<span class="board-title" contenteditable="true">${board.title}</span>
            <button class="delete-board-btn" title="Supprimer ce tableau" style="background: none; border: none; cursor: pointer; padding-left: 0.5em; vertical-align: middle;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
            <path fill="#b92127" d="M7 21a2 2 0 0 1-2-2V7H3V5h5V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h5v2h-2v12a2 2 0 0 1-2 2H7Zm10-14H7v12h10V7Zm-4 2v8h-2V9h2Z"/>
            </svg>
            </button>`;

            li.querySelector('.delete-board-btn').onclick = (e) =>{
                e.stopPropagation();
                this.deleteBoard(board.id)
            }

            li.onclick = () => this.selectBoard(board.id);

            li.querySelector(`.board-title`).onblur = (e) => {
                board.setTitle(e.target.innerText);
                this.renderBoards();
                this.renderBoardContent();
            };
            sidebarList.appendChild(li);
        });
    }

    deleteBoard(id) {
        this.boards = this.boards.filter(b => b.id !== id);
        if (this.currentBoardId === id) {
            this.currentBoardId = this.boards.length ? this.boards[0].id : null;
        }
        this.renderBoards();
        this.renderBoardContent();
    }

    selectBoard(id){
        this.currentBoardId= id;
        this.renderBoardContent();
    }

    renderBoardContent() {
    const board = this.boards.find(b => b.id === this.currentBoardId);
    const content = document.querySelector('.board-content');
    if (!content) return;
    if (!board) {
        content.innerHTML = `<h2>Bienvenue sur Listos !</h2>
            <p>Sélectionnez ou créez un tableau à gauche.</p>`;
        return;
    }
    content.innerHTML = `
        <h2 class="board-main-title" contenteditable="true">${board.title}</h2>`;
    // Renommage inline titre central
    content.querySelector('.board-main-title').onblur = (e) => {
        board.setTitle(e.target.innerText);
        this.renderBoards();
    };
    }

        init() {
        const btn = document.querySelector('.new-board-btn');
        if (btn) btn.onclick = () => this.addBoard();
        this.renderBoards();
        this.renderBoardContent();
    }
}