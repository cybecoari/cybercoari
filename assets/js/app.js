// =============================
// 🌐 APP.JS — Funções globais
// =============================

// 🔸 Exibe alertas personalizados (sucesso, erro, aviso)
function showAlert(tipo, titulo, mensagem) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        html: mensagem,
        confirmButtonText: 'OK',
        confirmButtonColor: tipo === 'success' ? '#28a745' : (tipo === 'error' ? '#dc3545' : '#0d6efd'),
        background: document.body.classList.contains('modo-escuro') ? '#1a1a2e' : '#fff',
        color: document.body.classList.contains('modo-escuro') ? '#fff' : '#000'
    });
}

// 🔸 Reproduz som de notificação
function playSound(url) {
    const audio = new Audio(url);
    audio.play().catch(() => console.warn('Som bloqueado pelo navegador.'));
}

// 🔸 Utilitário: formata data/hora
function formatarDataHora() {
    const agora = new Date();
    return agora.toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'medium' });
}

// 🔸 Guarda o tema atual no localStorage
function salvarTema(modo) {
    localStorage.setItem('themePreference', modo);
}