// Data inicial (30/09/2022)
var dataInicial = new Date('2025-10-01');
var dataAtual = new Date();

// Calcula a diferenÃ§a em milissegundos entre as duas datas
var diferenca = dataAtual.getTime() - dataInicial.getTime();

// Converte a diferenÃ§a de milissegundos para dias
var dias = Math.floor(diferenca / (1000 * 60 * 60 * 24));

// Cria um elemento span
var spanElement = document.createElement("span");
spanElement.textContent = + dias + " dias";

// ObtÃ©m o elemento pai onde o contador serÃ¡ exibido
var containerElement = document.getElementById("contador");

// Adiciona o elemento span ao pai
containerElement.appendChild(spanElement);