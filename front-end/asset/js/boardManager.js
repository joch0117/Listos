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
            li.innerHTML = `<span class="board-title" contenteditable="true">${board.title}</span>`;

            li.onclick = () => this.selectBoard(board.id);

            li.querySelector(`.board-title`).onblur = (e) => {
                board.setTitle(e.target.innerText);
                this.renderBoards();
                this.renderBoardContent();
            };
            sidebarList.appendChild(li);
        });
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