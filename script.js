document.addEventListener('DOMContentLoaded', () => {
    const listaFilmes = document.getElementById('lista-filmes');

    // Event listener para marcar/desmarcar filme como assistido
    listaFilmes.addEventListener('click', async (event) => {
        const target = event.target;
        if (target.classList.contains('btn-assistido')) {
            const filmeItem = target.closest('.filme-item');
            const filmeId = filmeItem.dataset.id;
            const isAssistido = target.dataset.assistido === 'true';
            
            // Simula uma requisição para o servidor para atualizar o status do filme
            // Em uma aplicação real, você faria uma requisição AJAX para um endpoint PHP dedicado
            // Ex: await fetch('update_status.php', { method: 'POST', body: ... });

            // Simulação de atualização do servidor
            const novoStatus = !isAssistido;
            target.dataset.assistido = novoStatus;
            
            if (novoStatus) {
                filmeItem.classList.add('assistido');
                target.textContent = 'Desmarcar';
                target.style.backgroundColor = '#aaa';
            } else {
                filmeItem.classList.remove('assistido');
                target.textContent = 'Assistido';
                target.style.backgroundColor = '#5d46be';
            }
        }
    });

    // Manipulação do formulário para adicionar filmes via Javascript
    // Isso é útil para uma experiência de usuário mais fluida
    const formFilme = document.getElementById('form-filme');
    formFilme.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede o envio tradicional do formulário
        
        const titulo = document.getElementById('titulo').value;
        const ano = document.getElementById('ano').value;

        if (titulo.trim() === '') {
            return;
        }

        // Simulação de requisição AJAX para o servidor
        // Em um cenário real, você enviaria os dados para um script PHP que
        // insere no banco de dados e retorna o novo item
        // Ex: const response = await fetch('add_filme.php', { method: 'POST', body: new FormData(formFilme) });
        // const novoFilme = await response.json();

        // Simulação de criação de um novo item (como se tivesse vindo do servidor)
        const novoFilmeElemento = document.createElement('div');
        novoFilmeElemento.classList.add('filme-item');
        // A ID precisa ser gerada dinamicamente pelo servidor
        novoFilmeElemento.setAttribute('data-id', Math.floor(Math.random() * 1000));
        novoFilmeElemento.innerHTML = `
            <span><strong>${titulo}</strong> (${ano})</span>
            <button class='btn-assistido' data-assistido='false'>Assistido</button>
        `;

        // Adiciona o novo filme no topo da lista
        const primeiroFilme = listaFilmes.querySelector('.filme-item');
        if (primeiroFilme) {
            listaFilmes.insertBefore(novoFilmeElemento, primeiroFilme);
        } else {
            listaFilmes.appendChild(novoFilmeElemento);
            const mensagemVazia = listaFilmes.querySelector('.mensagem-vazia');
            if (mensagemVazia) {
                mensagemVazia.remove();
            }
        }
        
        // Limpa o formulário
        formFilme.reset();
    });
});