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