import { dropdown } from './dropdown.js'; //menu dropdown toute les pages 



document.addEventListener('DOMContentLoaded', function() {
    const selector = document.getElementById('dropdownToggle');
    dropdown(selector);
});
