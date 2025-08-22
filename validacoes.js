function validarFornecedor(){
    document.getElementById("formCadastro").addEventListener ("submit", function(e) {
        const nome = document.getElementById("nome").value;
        const telefone = document.getElementById("telefone").value;
        const email = document.getElementById("email").value;

        if (nome.length < 3) {
            alert("O usuário deve ter pelo menos 3 caracteres");
            e.preventDefault();

            return false;
        }

        if(telefone.length > 17 || telefone.length < 8){
            alert("Telefone inválido")
            e.preventDefault();

            return false;
        }

        if(!email.includes("@")){
            alert ("Digite um email válido");
            e.preventDefault();

            return false;
        }
    });
}
function validanome(){
    document.getElementById("nome").addEventListener('input', function(){
        this.value = this.value.replace(/[0-9]/g, '');
    });
}
function validacontato(){
    document.getElementById("contato").addEventListener('input', function(){
        this.value = this.value.replace(/[0-9]/g, '');
    });
}

function mascaratelefone(input){
    let valor = input.value.replace(/\D/g, '');

    if (valor.length <= 10) {

        input.value = valor.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        input.value = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
    const InputTelefone = document.getElementById('telefone');
    
    if (InputTelefone) {
        InputTelefone.addEventListener('input', function() {
            mascaratelefone(this);
        });
    }
}
