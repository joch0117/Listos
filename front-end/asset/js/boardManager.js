import BoardApi from './api/boardApi.js';
import Board from './board.js';
import { getUserId } from './token.js';

export default class BoardManager {
    constructor() {
        this.api = new BoardApi();
        this.boards = [];
        this.currentBoardId = null;
    }

    // Initialisation du board manager : charge tous les tableaux
    async init() {
        try {
            const boardsData = await this.api.fetchBoard();
            this.boards = boardsData.map(data => new Board(data));
        } catch (e) {
            console.error("Erreur chargement tableaux:", e);
            this.boards = [];
        }
        // Branche le bouton “Nouveau tableau”
        const btn = document.querySelector('.new-board-btn');
        if (btn) btn.onclick = () => this.handleAddBoard();
        this.renderBoards();
        this.renderBoardContent();
    }

    // Ajout d’un tableau via l’API
    async handleAddBoard(title = 'Nouveau tableau') {
        try {
            const userId = getUserId();
            if (!userId) throw new Error('Utilisateur non connecté');
            const boardData = await this.api.addBoard({ 
                title,
                user:`/api/users/${userId}`
            });
            const board = new Board(boardData);
            this.boards.push(board);
            this.renderBoards();
            this.selectBoard(board.id);
        } catch (e) {
            alert('Erreur lors de l’ajout du tableau.');
            console.error(e);
        }
    }

    // Suppression d’un tableau via l’API
    async deleteBoard(id) {
        try {
            await this.api.deleteBoard(id);
            this.boards = this.boards.filter(b => b.id !== id);
            if (this.currentBoardId === id) {
                this.currentBoardId = this.boards.length ? this.boards[0].id : null;
            }
            this.renderBoards();
            this.renderBoardContent();
        } catch (e) {
            alert('Erreur lors de la suppression du tableau.');
            console.error(e);
        }
    }

    // Affichage de la sidebar (liste des boards)
    renderBoards() {
        const sidebarList = document.querySelector('.board-list');
        if (!sidebarList) return;
        sidebarList.innerHTML = '';
        this.boards.forEach(board => {
            const li = document.createElement('li');
            li.className = 'board-list-item';
            li.dataset.boardId = board.id;
            li.innerHTML = `
                <span class="board-title" contenteditable="true">${board.title}</span>
                <button class="delete-board-btn" title="Supprimer" style="background: none; border: none; cursor: pointer;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24">
                    <path fill="#b92127" d="M7 21a2 2 0 0 1-2-2V7H3V5h5V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h5v2h-2v12a2 2 0 0 1-2 2H7Zm10-14H7v12h10V7Zm-4 2v8h-2V9h2Z"/>
                  </svg>
                </button>
            `;
            li.onclick = () => this.selectBoard(board.id);
            // Édition inline (renommage, PATCH API)
            li.querySelector('.board-title').onblur = async (e) => {
                board.setTitle(e.target.innerText);
                try {
                    await this.api.updateBoard(board.id, { title: board.title });
                    this.renderBoards();
                    this.renderBoardContent();
                } catch (e) {
                    alert('Erreur lors de la modification du titre.');
                    console.error(e);
                }
            };
            // Suppression
            li.querySelector('.delete-board-btn').onclick = (e) => {
                e.stopPropagation();
                this.deleteBoard(board.id);
            };
            sidebarList.appendChild(li);
        });
    }

    // Sélection d’un tableau
    selectBoard(id) {
        this.currentBoardId = id;
        this.renderBoardContent();
    }

    // Affichage de la zone principale du board
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
            <h2 class="board-main-title" contenteditable="true">${board.title}</h2>
            <button class="btn new-list-btn" style="align-self: flex-start; margin-bottom: 1em;">+ Nouvelle liste</button>
            <div class="task-lists-container"></div>
        `;
        // Renommage inline titre principal (PATCH API)
        content.querySelector('.board-main-title').onblur = async (e) => {
            board.setTitle(e.target.innerText);
            try {
                await this.api.updateBoard(board.id, { title: board.title });
                this.renderBoards();
            } catch (e) {
                alert('Erreur lors de la modification du titre.');
                console.error(e);
            }
        };
        // (Brancher la gestion des listes plus tard sur .new-list-btn)
    }
}
