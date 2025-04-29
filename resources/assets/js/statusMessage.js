


let toastBox = document.getElementById("toastBox");

let successMsg = '<i class="fa-solid fa-circle-check"></i>Sucesso! ';
let duplicatedMsg = '<i class="fa-solid fa-circle-xmark"></i>Erro: Dado(s) duplicado(s)!';
let invalidCpfMsg = '<i class="fa-solid fa-circle-xmark"></i> Erro: CPF Inválido!';
let errorMsg = '<i class="fa-solid fa-circle-xmark"></i> Erro!';
let errorUser = '<i class="fa-solid fa-circle-xmark"></i> Erro: Usuário e/ou senha inválido(s)!';
let errorPassword = '<i class="fa-solid fa-circle-xmark"></i> Erro: Usuário e/ou senha inválido(s)!';
let invalidMsg = '<i class="fa-solid fa-circle-exclamation"></i> Atenção: {{statusMessage}} ';
let alertDuplicatedCpfMsg = '<i class="fa-solid fa-circle-exclamation"></i> Atenção: CPF já Cadastrado ';
let infoMsg = '<i class="fa-solid fa-circle-info"></i> Info: {{statusMessage}}';

function showToast(msg) {
   
    let toast = document.createElement("div");
    toast.classList.add("toast");
    toast.innerHTML = msg;
    toastBox.appendChild(toast);

    if (msg.includes('Erro')) {
        toast.classList.add("Erro")
    }

    if (msg.includes("Atenção")) {
        toast.classList.add("Atenção")
    }

    if (msg.includes("info")) {
        toast.classList.add("info")
    }

    setTimeout(() => {
        toast.remove();
    }, 5000)
}



const searchParams = new URLSearchParams(window.location.search);

const mensagem = searchParams.get('statusMessage');

switch(mensagem) {
    case "duplicated":
		showToast(duplicatedMsg);
        break;
    case "created":
        showToast(successMsg);
        break;
    case "updated":
        
        showToast(successMsg);
        break;
    case "deleted":
        showToast(successMsg);
        break;
    case "invalidCpf":
        showToast(invalidCpfMsg);
        break;
    case "alertDuplicatedCpf":
        showToast(alertDuplicatedCpfMsg);
        break;
    case "errorUser":
        showToast(errorUser);
        break;
    case "errorPassword":
        showToast(errorPassword);
        break;
 
}  