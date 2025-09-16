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
});