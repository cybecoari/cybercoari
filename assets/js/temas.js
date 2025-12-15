function activateTheme(themeName) {
    const htmlElement = document.getElementById('html-theme');

    // Remove classes de tema existentes
    htmlElement.classList.remove('modo-escuro', 'diurno', 'noturno');
    
    // Adiciona a classe do novo tema (usando a mesma lógica do PHP)
    if (themeName === 'noturno') {
        htmlElement.classList.add('modo-escuro');
    }
    // Se for 'diurno', não adiciona nada (modo claro por padrão)

    // Atualiza o ícone do botão
    updateThemeButton(themeName);

    // Salva a preferência
    saveThemePreference(themeName);
}

function updateThemeButton(themeName) {
    const btn = document.getElementById('btn-toggle-theme');
    if (btn) {
        btn.textContent = themeName === 'noturno' ? '☀️' : '🌙';
        btn.title = themeName === 'noturno' ? 'Modo Claro' : 'Modo Escuro';
    }
}

// Função para salvar a preferência do tema
function saveThemePreference(themeName) {
    localStorage.setItem('themePreference', themeName);
}

// Função para carregar a preferência do tema salva
function loadThemePreference() {
    const savedPreference = localStorage.getItem('themePreference');
    const htmlElement = document.getElementById('html-theme');
    const isDarkMode = htmlElement.classList.contains('modo-escuro');
    
    if (savedPreference) {
        // Usa o tema salvo no localStorage
        activateTheme(savedPreference);
    } else {
        // Se não houver tema armazenado, usa o tema atual do PHP
        const currentTheme = isDarkMode ? 'noturno' : 'diurno';
        activateTheme(currentTheme);
        saveThemePreference(currentTheme);
    }
}

// Alternar tema manualmente
function toggleTheme() {
    const htmlElement = document.getElementById('html-theme');
    const isDarkMode = htmlElement.classList.contains('modo-escuro');
    const newTheme = isDarkMode ? 'diurno' : 'noturno';
    
    activateTheme(newTheme);
    
    // Sincronizar com servidor via AJAX
    syncThemeWithServer(newTheme);
}

// Sincronizar com servidor via AJAX - ATUALIZADA para seu endpoint
function syncThemeWithServer(theme) {
    fetch('inckudes/atualizar_tema.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `tema=${theme}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Tema sincronizado com sucesso:', data.tema);
        } else {
            console.error('Erro ao sincronizar tema:', data.message);
            // Reverte em caso de erro
            const currentTheme = theme === 'noturno' ? 'diurno' : 'noturno';
            activateTheme(currentTheme);
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        // Reverte em caso de erro de rede
        const currentTheme = theme === 'noturno' ? 'diurno' : 'noturno';
        activateTheme(currentTheme);
    });
}

// Carrega a preferência do tema ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    loadThemePreference();
    
    // Configura o botão de alternar tema
    const btn = document.getElementById('btn-toggle-theme');
    if (btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleTheme();
        });
    }
});

// Remove as funções antigas que não são mais necessárias
// function activateTheme2() - REMOVIDA
// loadThemePreference() duplicada - REMOVIDA