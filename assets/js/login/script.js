document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll('.input_form_sign');
    const tabs = document.querySelectorAll('.ul_tabs > li');
    const forgotPassLink = document.querySelector('.link_forgot_pass');
    const terms = document.querySelector('.terms_and_cons');
    const btnSign = document.querySelector('.btn_sign');
    const container = document.querySelector('.cont_centrar');

    function showInputs(isSignUp) {
        inputs.forEach((input, index) => {
            const shouldShow = isSignUp || index === 1 || index === 2; 
            input.classList.remove('d_block', 'active_inp');
            if (shouldShow) {
                input.classList.add('d_block');
                setTimeout(() => input.classList.add('active_inp'), 100);
            }
        });
    }

    function sign_up() {
        document.getElementById("modo_form").value = "cadastro";

        tabs[0].classList.remove("active");
        tabs[1].classList.add("active");

        // Mostra campos do cadastro
        showInputs(true);

        // Esconde link de "esqueci senha"
        forgotPassLink.style.opacity = "0";
        forgotPassLink.style.top = "-5px";

        // Muda botão
        btnSign.innerHTML = "CRIAR CONTA";

        // Exibe termos
        setTimeout(() => {
            forgotPassLink.classList.add("d_none");
            terms.classList.replace("d_none", "d_block");
        }, 450);

        setTimeout(() => {
            terms.style.opacity = "1";
            terms.style.top = "5px";
        }, 500);
    }

    function sign_in() {
        document.getElementById("modo_form").value = "login";

        tabs[0].classList.add("active");
        tabs[1].classList.remove("active");

        // Mostra apenas email e senha
        showInputs(false);

        // Esconde termos
        terms.style.opacity = "0";
        terms.style.top = "-5px";

        setTimeout(() => {
            terms.classList.replace("d_block", "d_none");
            forgotPassLink.classList.replace("d_none", "d_block");
        }, 500);

        setTimeout(() => {
            forgotPassLink.style.opacity = "1";
            forgotPassLink.style.top = "5px";
        }, 700);

        // Muda botão
        btnSign.innerHTML = "ENTRAR";
    }

    // Ativação da animação inicial
    container.classList.add("cent_active");

    // Vincula funções aos cliques
    window.sign_up = sign_up;
    window.sign_in = sign_in;
});

