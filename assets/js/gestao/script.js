document.addEventListener("DOMContentLoaded", function () {
    // Função para abrir o modal e preencher o ID da instituição
    window.abrirModal = function (id) {
        const modal = document.getElementById("modalForm");
        if (modal) {
            modal.style.display = "block"; // Exibe o modal
            const inputId = document.getElementById("instituicaoId");
            if (inputId) {
                inputId.value = id; // Define o ID no campo oculto
            }
        } else {
            console.error("Modal não encontrado.");
        }
    };

    // Fechar o modal ao clicar no botão "modal-close"
    const closeModalButton = document.querySelector(".modal-close");
    if (closeModalButton) {
        closeModalButton.addEventListener("click", function () {
            const modal = document.getElementById("modalForm");
            if (modal) {
                modal.style.display = "none";
            }
        });
    } else {
        console.error("Botão de fechar '.modal-close' não encontrado.");
    }

    // Fechar o modal ao clicar fora do conteúdo
    window.onclick = function (event) {
        const modal = document.getElementById("modalForm");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});


document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("cnpjForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                const statusElement = document.getElementById("status-cadastro");

                if (data.status === "error") {
                    statusElement.textContent = data.message;
                    statusElement.style.color = "red";
                } else if (data.status === "success") {
                    statusElement.textContent = data.message;
                    statusElement.style.color = "green";
                    form.reset();
                }
            })
            .catch((error) => {
                console.error("Erro ao processar o cadastro:", error);
            });
    });
});

// Função para inicializar o modal de imagens
function setupImageModal() {
    const imageModal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeImageModal = document.getElementById("closeImageModal");
    const tableImages = document.querySelectorAll("table img");

    // Abre o modal ao clicar em uma imagem
    tableImages.forEach((img) => {
        img.addEventListener("click", () => {
            modalImage.src = img.src;
            imageModal.style.display = "flex";
        });
    });

    // Fecha o modal ao clicar no botão de fechar
    closeImageModal.addEventListener("click", () => {
        imageModal.style.display = "none";
    });

    // Fecha o modal ao clicar fora da imagem
    imageModal.addEventListener("click", (event) => {
        if (event.target === imageModal) {
            imageModal.style.display = "none";
        }
    });
}

// Inicializa o modal de imagem quando a página carregar
document.addEventListener("DOMContentLoaded", () => {
    setupImageModal();
});

