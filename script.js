document.addEventListener('DOMContentLoaded', () => {
    const listaFilmes = document.getElementById('lista-filmes');

    // Event listener para marcar/desmarcar filme como assistido
    listaFilmes.addEventListener('click', async (event) => {
        const target = event.target;
        if (target.classList.contains('btn-assistido')) {
            const filmeItem = target.closest('.filme-item');
            const filmeId = filmeItem.dataset.id;
            const isAssistido = target.dataset.assistido === 'true';
            
            const novoStatus = !isAssistido;

            // Envia a requisição para o servidor para atualizar o status do filme
            const formData = new FormData();
            formData.append('id', filmeId);
            formData.append('assistido', novoStatus);
            
            try {
                const response = await fetch('update_status.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // Se a requisição for bem-sucedida, atualiza a interface
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
    });
});