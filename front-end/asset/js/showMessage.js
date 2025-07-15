export async function showMessage(type, text) {
    const container = document.getElementById('messageContainer');
    if (!container) return;
    const file = type === 'success' ? 'message-success.html' : 'message-error.html';
    const res = await fetch(`partials/${file}`);
    container.innerHTML = await res.text();
    const el = document.getElementById(
        type === 'success' ? 'messageSuccessText' : 'messageErrorText'
    );
    if (el) el.textContent = text;

    // Optionnel : masquer le message après 2 secondes
    setTimeout(() => { container.innerHTML = ''; }, 2000);
}
