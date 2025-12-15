document.addEventListener('DOMContentLoaded', () => {
    // ================== Carrega tema ==================
    if (typeof loadThemePreference === 'function') loadThemePreference();

    // ================== Flash messages ==================
    <?php if (temErro()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            html: '<?= getErro() ?>',
            confirmButtonColor: '#d33'
        });
    <?php elseif (temSucesso()): ?>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso',
            html: '<?= getSucesso() ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php endif; ?>

    // ================== Atualiza usuários online ==================
    function atualizarOnline() {
        fetch('includes/online.php') // ajuste o caminho se necessário
            .then(res => res.json())
            .then(data => {
                // Atualiza contador
                const contador = document.getElementById('usuarios-online');
                if (contador) contador.textContent = data.online;

                // Atualiza lista de usuários online (se existir)
                const lista = document.getElementById('lista-usuarios-online');
                if (lista) {
                    if (data.usuarios.length > 0) {
                        lista.innerHTML = data.usuarios.map(u => `<li>${u}</li>`).join('');
                    } else {
                        lista.innerHTML = '<li>Nenhum usuário online</li>';
                    }
                }
            })
            .catch(err => console.error('Erro ao atualizar online:', err));
    }

    // Atualiza imediatamente e depois a cada 10 segundos
    atualizarOnline();
    setInterval(atualizarOnline, 10000);

    // ================== Botão WhatsApp ==================
    // Você pode adicionar aqui se quiser
});