<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UiHelp</title>
    <meta name="description" content="Um site com o intuito de ajudá-lo a encontrar locais de doação e descarte!">
    <meta property="og:image" content="/assets/img/icons/favicon.png" />
    <link rel="icon" href="/assets/img/icons/favicon.png" type="image/png">


    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "UiHelp",
        "url": "https://uihelp.com.br",
        "logo": "https://uihelp.com.br/assets/img/icons/icon2.png",
        "description": "Um site com o intuito de ajudá-lo a encontrar locais de doação e descarte!",
        "sameAs": [
            "https://www.instagram.com/ui.help/",
            "https://wa.me/5548991967983"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+55-48-99196-7983",
            "contactType": "customer support",
            "areaServed": "BR"
        }
    }
    </script>




    <!-- Link e Script do mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script> 
    
    
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="assets/css/map.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    
</head>
<body>
    <header>
        <!-- Ícone do menu -->
        <div class="iconLogo" >
            <img id="iconLogoImg" src="assets/img/icons/logo.png" alt="Logo UiHelp">
        </div>

        <!-- Menu lateral -->
        <nav id="menu" class="menu closed">

            <!-- Filtros do menu -->
            <section class="filtros">
                <label class="filter-option" id='option-todos'>
                    <input type="radio" name="filter" value="Todos" checked>
                    Todos
                </label>
                <label class="filter-option" id='option-roupas'>
                    <input type="radio" name="filter" value="Roupas">
                    Roupas
                </label>
                <label class="filter-option" id='option-moveis'>
                    <input type="radio" name="filter" value="Móveis">
                    Móveis
                </label>
                <label class="filter-option" id='option-brinquedos'>
                    <input type="radio" name="filter" value="Brinquedos">
                    Brinquedos
                </label>
                <label class="filter-option" id='option-alimentos'>
                    <input type="radio" name="filter" value="Alimentos">
                    Alimentos
                </label>
                <label class="filter-residuo" id='option-residuos'>
                    <input type="radio" name="filter" value="Resíduos">
                    Resíduos
                </label>


                <div id="filter-servico-div">
                    <p id="filter-servico-name">Serviços</p>
                </div>

                <label class="filter-servico">
                    <select id="select-servico">
                        <option value="todos" marked>Todos</option>
                        <option value="coleta">Coleta</option>
                        <option value="distribuicao">Distribuição</option>
                        <option value="distribuicao_e_coleta">Distribuição e Coleta</option>
                    </select>
                </label>
            </section>

            <!-- Botão de inscrição -->
            <section class="inscricao">
                <a href="cadastro" class="inscrever-btn">Cadastre sua Instituição</a>
            </section>

            <!-- Seção de contato -->
            <address class="contato">
                <p>Contate-nos!</p>
                <div class="contact-icons">
                    <a href="https://www.instagram.com/ui.help/" target="_blank">
                        <img src="assets/img/icons/instagram.png" alt="Instagram" class="icon">
                    </a>
                    <a href="https://wa.me/5548991967983" target="_blank">
                        <img src="assets/img/icons/whatsapp.png" alt="WhatsApp" class="icon">
                    </a>
                </div>
            </address>

            <section class="sobre">
                <a href="sobrenos" >
                    <h4>Sobre Nós</h4> 
                </a>
            </section>

        </nav>
    </header>
    
    <main>
        <section id="map" ></section>
        <div id="image-overlay" class="overlay closed">
            <div class="overlay-content">
                <img id="enlarged-image" src="" alt="Imagem ampliada">
            </div>
        </div>
    </main>

    <footer>
        <div id="logo-palhoca" class="fade-in">
            <a href="https://palhoca.atende.net/"><img src="assets/img/icons/palhoca_logo.png" alt=""></a>    
        </div> 

        <div id="logo-fmp" class="fade-in">
            <a href="https://fmpsc.edu.br"><img src="assets/img/icons/fmp_logo.png" alt=""></a>
        </div> 
    </footer>

</body>
<script src="assets/js/map/map.js"></script>
<script>
window.addEventListener('load', () => {
    document.querySelectorAll('.fade-in').forEach(el => {
    el.classList.add('visible');
    });
});
</script>

</html>