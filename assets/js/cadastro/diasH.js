let diasAdicionados = [];
adicionarDia();

function adicionarDia() {
    
    const container = document.getElementById("horarios-container");

    const idUnico = Date.now(); //Uso a biblioteca Date pra criar um ID único pra cada conjunto de campo (dias e horas)

    const div = document.createElement("div");
    div.className = "dia-bloco";
    div.dataset.id = idUnico;

    div.innerHTML = `
        <div class="input-row" style="gap: 10px; align-items: center;">
            <div class="input-group">
                <label>De</label>
                <select name="horarios[${idUnico}][dia_inicio]" onchange="verificaDuplicado(this)" required>
                    <option value="">-- Selecione --</option>
                    <option value="Segunda-Feira">Segunda-feira</option>
                    <option value="Terça-Feira">Terça-feira</option>
                    <option value="Quarta-Feira">Quarta-feira</option>
                    <option value="Quinta-Feira">Quinta-feira</option>
                    <option value="Sexta-Feira">Sexta-feira</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>                
                </select>

                <label>das</label>
                <input type="time" name="horarios[${idUnico}][abertura]" required>
            </div>
            <div class="input-group">

                <label>à</label>
                <select name="horarios[${idUnico}][dia_fim]" onchange="verificaDuplicado(this)" required>
                    <option value="">-- Selecione --</option>
                    <option value="Segunda-Feira">Segunda-feira</option>
                    <option value="Terça-Feira">Terça-feira</option>
                    <option value="Quarta-Feira">Quarta-feira</option>
                    <option value="Quinta-Feira">Quinta-feira</option>
                    <option value="Sexta-Feira">Sexta-feira</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>

                <label>às</label>
                <input type="time" name="horarios[${idUnico}][fechamento]" required>
            </div>
        </div>
        <button class="btn-remover" type="button" onclick="removerDia(this)">Remover</button>
        <span id="erroHorario">
            * Deve haver pelo menos um horário definido!
        </span>
    `;
    
    container.appendChild(div);
    document.getElementById('erroHorario').style.display = 'none';
}


function removerDia(botao) {
    const bloco = botao.closest(".dia-bloco");
    const totalBlocos = document.querySelectorAll('.dia-bloco').length;

    if (totalBlocos > 1) {
        bloco.remove();
        document.getElementById('erroHorario').style.display = 'none';
    } else{
        document.getElementById('erroHorario').style.display = 'inline';
    }

    atualizarDiasAdicionados();
}


function atualizarDiasAdicionados() {
    // Converte o NodeList em um Array
    diasAdicionados = Array.from(document.querySelectorAll('select[name$="[dia_inicio]"], select[name$="[dia_fim]"]'))
        .map(select => select.value) // Pega os valores
        .filter(val => val !== ""); // Remove os valores vazios
}

function verificaDuplicado(selectElement) {
    atualizarDiasAdicionados();
    const valor = selectElement.value;

    const repeticoes = diasAdicionados.filter(dia => dia === valor).length;

    if (repeticoes > 2) { // até 2 repetições são permitidas (ex: segunda à sexta)
        alert("Esse dia já foi adicionado mais de uma vez.");
        selectElement.value = "";
        atualizarDiasAdicionados();
    }
}
