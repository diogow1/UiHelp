document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('cnpjForm');
    const cnpjInput = document.getElementById('cnpjInput');
    const statusCadastro = document.getElementById('status-cadastro');

    function formatarCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
        cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
        cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
        return cnpj;
    }

    function validarCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, ''); //Retorna só os numéricos

        if (cnpj.length !== 14) return false; //Se tem 14 dig
        if (/^(\d)\1+$/.test(cnpj)) return false; // Se não são todos iguais

        // Cálculo do primeiro dígito verificador
        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
            if (pos < 2) pos = 9;
        }

        let resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        if (resultado !== parseInt(digitos.charAt(0))) return false;

        // Mesmo processo, mas agora com os 13 primeiros números
        tamanho += 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
            if (pos < 2) pos = 9;
        }

        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        return resultado === parseInt(digitos.charAt(1));
    }

    // Formata o cnpj e remove caracteres não numéricos.
    if (cnpjInput && statusCadastro) {
        cnpjInput.addEventListener('input', function () {
            this.value = formatarCNPJ(this.value);
            const cnpjNumeros = this.value.replace(/\D/g, '');
        });
    }


    if (form && cnpjInput && statusCadastro) {
        form.addEventListener('submit', function (event) {
            const cnpjNumeros = cnpjInput.value.replace(/\D/g, '');
            // Se os dois dígitos batem, o CNPJ é válido
            if (!validarCNPJ(cnpjNumeros)) {
                event.preventDefault();
                alert('❌ CNPJ inválido!');
            }
        });
    }
});

function formatarTelefone(valor) {
    valor = valor.replace(/\D/g, ''); // remove tudo que não for número

    if (valor.length > 11) valor = valor.slice(0, 11); // limita a 11 dígitos

    if (valor.length === 11) {
        return valor.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (valor.length === 10) {
        return valor.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    } else {
        return valor;
    }
}

// Aplica ao digitar
document.getElementById("telefone").addEventListener("input", function (e) {
    this.value = formatarTelefone(this.value);
});

document.getElementById("whatsapp").addEventListener("input", function (e) {
    this.value = formatarTelefone(this.value);
});

