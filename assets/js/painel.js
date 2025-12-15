// ================== PAINEL.JS ==================
// 🔹 Tema escuro / claro + atualização automática de usuários online
// 🔹 Mantém o usuário "online" enquanto o painel está aberto

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const btn = document.getElementById('btn-toggle-theme');
    const icon = btn?.querySelector('i');

    // ================== TEMA ==================
    const temaSalvo = localStorage.getItem('themePreference') || '<?= $temaUsuarioFallback ?>';
    const isDark = temaSalvo === 'noturno';
    body.classList.toggle('modo-escuro', isDark);
    if (icon) icon.className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';

    if (btn) {
        btn.addEventListener('click', () => {
            const modoEscuroAtivo = body.classList.toggle('modo-escuro');
            const novoTema = modoEscuroAtivo ? 'noturno' : 'diurno';
            localStorage.setItem('themePreference', novoTema);
            if (icon) icon.className = modoEscuroAtivo ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        });
    }

    // ================== ATUALIZAR CONTADOR DE USUÁRIOS ONLINE ==================
    function atualizarOnline() {
        fetch('includes/online.php', { cache: 'no-store' })
            .then(res => res.json())
            .then(data => {
                if (data && typeof data.online !== 'undefined') {
                    const contador = document.getElementById('usuarios-online');
                    if (contador) contador.textContent = data.online;
                }
            })
            .catch(err => console.error('Erro ao atualizar online:', err));
    }

    // Atualiza já ao carregar
    atualizarOnline();

    // Atualiza a cada 60 segundos
    setInterval(atualizarOnline, 60000);

    // ================== MANTER USUÁRIO ONLINE ==================
    function manterOnline() {
        fetch('includes/manter_online.php', { cache: 'no-store' })
            .then(res => res.json())
            .then(data => {
                if (data.status !== 'online') {
                    console.warn('Sessão inativa:', data);
                }
            })
            .catch(console.error);
    }

    // Envia ping a cada 30 segundos para manter status ativo
    setInterval(manterOnline, 30000);
});