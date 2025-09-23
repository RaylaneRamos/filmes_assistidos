document.addEventListener('DOMContentLoaded', () => {
    const listaFilmes = document.getElementById('lista-filmes');

    // Event listener para marcar/desmarcar filme como assistido ou remover
    listaFilmes.addEventListener('click', async (event) => {
        const target = event.target;

        // Lógica para marcar/desmarcar
        if (target.classList.contains('btn-assistido')) {
            const filmeItem = target.closest('.filme-item');
            const filmeId = filmeItem.dataset.id;
            const isAssistido = target.dataset.assistido === 'true';
            
            const novoStatus = !isAssistido;

            const formData = new FormData();
            formData.append('id', filmeId);
            formData.append('assistido', novoStatus);
            
            try {
                const response = await fetch('update_status.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
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
                } else {
                    console.error("Erro ao atualizar o status. Resposta do servidor:", await response.text());
                    alert("Não foi possível atualizar o status. Tente novamente.");
                }

            } catch (error) {
                console.error("Erro na requisição:", error);
                alert("Ocorreu um erro de conexão. Tente novamente.");
            }
        }
        
        // Lógica para remover o filme
        else if (target.classList.contains('btn-remover')) {
            const filmeItem = target.closest('.filme-item');
            const filmeId = target.dataset.id;
            
            const confirmacao = confirm("Tem certeza que deseja remover este filme?");
            if (!confirmacao) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('id', filmeId);

                const response = await fetch('delete_filme.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    filmeItem.remove();
                } else {
                    console.error("Erro ao remover o filme. Resposta do servidor:", await response.text());
                    alert("Não foi possível remover o filme.");
                }
            } catch (error) {
                console.error("Erro na requisição de remoção:", error);
                alert("Ocorreu um erro de conexão. Tente novamente.");
            }
        }
    });

    document.getElementById('form-filme').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const lista = document.getElementById('lista-filmes');
        const titulo = form.titulo.value;
        const ano = form.ano.value;
        const genero = form.genero.value;
        const duracao = form.duracao.value;
        const sinopse = form.sinopse.value;
        const nota = form.nota.value;
        const assistido = form.assistido.checked;
        const favorito = form.favorito.checked;

        let estrelas = '';
        for (let i = 1; i <= 5; i++) {
            estrelas += `<span class="estrela">${i <= nota ? '&#9733;' : '&#9734;'}</span>`;
        }

        let tags = '';
        if (assistido) tags += '<span class="tag assistido">Assistido</span>';
        if (favorito) tags += '<span class="tag favorito">Favorito</span>';

        const card = document.createElement('article');
        card.className = 'filme-card';
        card.innerHTML = `
            <div class="filme-info">
                <h2 class="filme-titulo">${titulo}</h2>
                <span class="filme-genero">${genero}</span>
                <span class="filme-duracao">${duracao} min</span>
                <p class="filme-sinopse">${sinopse}</p>
                <div class="filme-avaliacao">${estrelas}</div>
                <div class="filme-tags">${tags}</div>
                <button class="btn-remover" title="Remover">&#10006;</button>
            </div>
        `;
        card.querySelector('.btn-remover').onclick = () => card.remove();
        lista.prepend(card);
        form.reset();
    });
});