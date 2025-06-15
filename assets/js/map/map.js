const overlay = document.getElementById('image-overlay');
const enlargedImage = document.getElementById('enlarged-image');

var map = L.map('map').setView([-27.63770377332425, -48.651619822297285], 11);

var greenIcon = L.divIcon({
    //iconUrl: 'assets/img/icons/icone.png', // Link do ícone
    className: 'custom-marker', // SEM animação aqui
    html: `
    <div class="marker-inner">
        <img src="assets/img/icons/icone.png" style="width:25px; height:41px;">
    </div>
    `,
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png', // Sombra do ícone
    iconSize: [25, 41], // Tamanho do ícone
    iconAnchor: [12, 41], // Ponto onde o ícone estará no mapa
    popupAnchor: [1, -34], // Ponto de ancoragem do popup relativo ao ícone
    shadowSize: [41, 41], // Tamanho da sombra
});


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function formatarHora(hora){
    if(!hora) return ''
    return hora.slice(0, 5)
}

var markers = []; // Array para armazenar os marcadores



function addMarkers(filteredData) {
    // Remove marcadores antigos
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];

    // Adiciona um marcador a cada intervalo
    filteredData.forEach((instituicao, index) => {
        setTimeout(() => {
            const marker = L.marker([instituicao.latitude, instituicao.longitude], {
                icon: greenIcon
            }).addTo(map);

            marker.bindPopup(`
                <div class="popup">
                <h3>${instituicao.nome}</h3>
                <p><b>Endereço:</b> ${instituicao.logradouro}, Nº ${instituicao.numero}${instituicao.complemento ? ', ' + instituicao.complemento : ''} - Bairro ${instituicao.bairro}, ${instituicao.cidade} - ${instituicao.uf}, CEP ${instituicao.cep}</p>
                <p><b>Telefone:</b> ${instituicao.telefone}</p>
                <p><b>Email:</b> ${instituicao.email}</p>
                <p><b>Descrição:</b> ${instituicao.descricao}</p>
                <p><b>Tipos de coleta:</b> ${instituicao.tipos_coleta.map(tipo => tipo.nome).join(', ')}</p>
                <p><b>Serviços:</b> ${
                ((tipo) => {
                    const mapa = {
                    'coleta': 'Coleta',
                    'distribuicao': 'Distribuição',
                    'distribuicao_e_coleta': 'Distribuição e Coleta'
                    };
                    return mapa[tipo] || 'Tipo desconhecido';
                })(instituicao.tipo_servico)
                }</p>
                <p><b>Horários de funcionamento:</b></p>
                <ul>
                ${instituicao.horarios_funcionamento.map(horario => `
                    <li>
                    ${horario.dia_inicio === horario.dia_fim 
                        ? horario.dia_inicio 
                        : horario.dia_inicio + ' à ' + horario.dia_fim}: 
                    das ${formatarHora(horario.abertura)} às ${formatarHora(horario.fechamento)}
                    </li>
                `).join('')}
                </ul>


                <div class="contatos-mapa">
                    <a class="whatsapp" href="https://wa.me/${instituicao.whatsapp}" target="_blank">
                        <img src="assets/img/icons/whatsapp.png" style="width:30px;height:auto;">
                    </a>
                    <a class="instagram" href="${instituicao.instagram}" target="_blank">
                        <img src="assets/img/icons/instagram.png" style="width:30px;height:auto;">
                    </a>
                </div>
                <img src="/${instituicao.imagem}" alt="Imagem do local" style="width:150px;height:auto; cursor:pointer;" class="popup-image">
            </div>
            `);

            markers.push(marker);
        }, index * 100); //intervalo entre cada marcador (pode ajustar o tempo)
    });
}





// Carregar dados das instituições
fetch('php/dados_instituicoes.php').then(response => response.json()) //Converte para JSON
    .then(data => {
        addMarkers(data); // Exibe tudo inicialmente

        //Armazena os documents do tipo e do serviço
        const filters = document.querySelectorAll('input[name="filter"]'); 
        const selectServico = document.getElementById('select-servico');

        //Deixa o filtro 'Todos' destacado como padrão.
        document.getElementById('option-todos').classList.add('filtro-ativo');


        function aplicarFiltros() {
            //Pega os valores dos filtros
            const tipoSelecionado = document.querySelector('input[name="filter"]:checked').value;
            const servicoSelecionado = selectServico.value;

            // Limpa estilos visuais
            document.querySelectorAll('.filter-option, .filter-residuo').forEach(el => {
                el.classList.remove('filtro-ativo', 'filtro-verde');
                el.style.transform = 'scale(1)';
            });
            
            // Mostra tudo, caso nenhum filtro esteja selecionado
            if (tipoSelecionado === 'Todos' && servicoSelecionado === 'todos') {
                document.getElementById('option-todos').classList.add('filtro-ativo');
                return addMarkers(data);
            }

            const filtrados = data.filter(instituicao => {

                /* tipoOk será true se:
                O tipo é "Todos"
                ou 
                A instituição tem pelo menos um tipo.nome igual ao selecionado.*/
                const tipoOk = tipoSelecionado === 'Todos' || instituicao.tipos_coleta?.some(tipo => tipo.nome === tipoSelecionado);
                
                /* servicoOk será true se:
                O serviço é "todos"
                ou
                tipo_servico da instituição for exatamente igual ao valor selecionado no dropdown.
                */
                const servicoOk = servicoSelecionado === 'todos' || instituicao.tipo_servico === servicoSelecionado;


                return tipoOk && servicoOk;
            });

            addMarkers(filtrados);

            const btn = [...document.querySelectorAll('.filter-option')].find(label => {
                return label.textContent.trim() === tipoSelecionado;
            });

            if (tipoSelecionado === 'Resíduos') {
                document.getElementById('option-residuos').classList.add('filtro-verde');
            } else if (btn) {
                btn.classList.add('filtro-ativo');
            }
        }

        // Adicionar um evento chamando a função aplicarFiltros em todos os itens do filtro
        filters.forEach(filter => {
            filter.addEventListener('change', aplicarFiltros);
        });
        selectServico.addEventListener('change', aplicarFiltros);


    }).catch(error => console.error('Erro ao carregar os dados:', error));



// Evento global para capturar cliques nas imagens do popup
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('popup-image')) {
        // Atualiza a imagem no overlay e exibe o modal
        enlargedImage.src = event.target.src;                   
        overlay.classList.remove('closed');
        overlay.classList.add('open');
    }
});

// Fecha o overlay ao clicar fora da imagem
overlay.addEventListener('click', (event) => {
    if (event.target === overlay) {
        overlay.classList.remove('open');
        overlay.classList.add('closed');
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const menu = document.getElementById("menu");
    const hamburger = document.getElementById("iconLogoImg");

    // Alterna entre aberto e fechado ao clicar no ícone
    hamburger.addEventListener("click", function() {
        menu.classList.toggle("open");
        menu.classList.toggle("closed");
    });
});
