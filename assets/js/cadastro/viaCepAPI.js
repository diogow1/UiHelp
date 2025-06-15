const urlUF = 'https://viacep.com.br/ws/';

const cep = document.getElementById('cep')


cep.addEventListener('change', async ()=>{
    const urlCep = 'https://viacep.com.br/ws/'+cep.value+'/json';
    const request = await fetch(urlCep);
    const response = await request.json();
    if (response.uf != undefined){
        document.getElementById('uf').value = response.uf;
        document.getElementById('cidade').value = response.localidade;
        document.getElementById('bairro').value = response.bairro;
        document.getElementById('logradouro').value = response.logradouro;
    }


})

cepInput = document.getElementById('cep')

cep.addEventListener('input', function () {
    this.value = formatarCEP(this.value);
})

function formatarCEP(cep) {
    cep = cep.replace(/\D/g, ''); 
    if (cep.length === 8) {
        return cep.replace(/(\d{5})(\d{3})/, '$1-$2');
    }

    return cep; 
}

