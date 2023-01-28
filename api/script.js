// aciona modal de finalizar com tecla de atalho

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "F2") {
        var element = document.getElementById("modal");
        element.classList.add("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "F2") {
        var element = document.getElementById("modal");
        element.classList.add("show-modal");
        document.getElementById("troco").focus();
    }
});

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        var element = document.getElementById("modal");
        element.classList.remove("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "Escape") {
        var element = document.getElementById("modal");
        element.classList.remove("show-modal");
    }
});


///////////////////////////////////////////////////////////////////
// aciona modal de excluir produto grid com tecla de atalho

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "F9") {
        var element = document.getElementById("modals");
        element.classList.add("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "F9") {
        var element = document.getElementById("modals");
        element.classList.add("show-modal");
        document.getElementById("id_produto").focus();
    }
});

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        var element = document.getElementById("modals");
        element.classList.remove("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "Escape") {
        var element = document.getElementById("modals");
        element.classList.remove("show-modal");
    }
});

///////////////////////////////////////////////////////////
// modal para excluir produto
//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "F4") {
        var element = document.getElementById("modalss");
        element.classList.add("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "F4") {
        var element = document.getElementById("modalss");
        element.classList.add("show-modal");
        document.getElementById("pesquisa").focus();
    }
});

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        var element = document.getElementById("modalss");
        element.classList.remove("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "Escape") {
        var element = document.getElementById("modalss");
        element.classList.remove("show-modal");
    }
});
/////////////////////////////////////////////////

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "F8") {
        var element = document.getElementById("modalsss");
        element.classList.add("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "F8") {
        var element = document.getElementById("modalsss");
        element.classList.add("show-modal");
        document.getElementById("pesquisa_emitente").focus();
    }
});

//keydown
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        var element = document.getElementById("modalsss");
        element.classList.remove("show-modal");
    }
});
//keydown
document.addEventListener("keyup", function(e) {
    if (e.key === "Escape") {
        var element = document.getElementById("modalsss");
        element.classList.remove("show-modal");
    }
});













// evento para usuario usar mouse
// botaõ pagar
function showModal() {
    var element = document.getElementById("modal");
    element.classList.add("show-modal");
}

function closeModal() {
    var element = document.getElementById("modal");
    element.classList.remove("show-modal");
}
// Botão Menu de opções
function abreModal() {
    var element = document.getElementById("modals");
    element.classList.add("show-modal");
}

function fechaModal() {
    var element = document.getElementById("modals");
    element.classList.remove("show-modal");

}
// Evento para abrir modal de produtos

function abreModalProduto() {
    var element = document.getElementById("modalss");
    element.classList.add("show-modal");
}

function fechaModalProduto() {
    var element = document.getElementById("modalss");
    element.classList.remove("show-modal");
}

// Evento para abrir modal de clientes

function abreModalClientes() {
    var element = document.getElementById("modalsss");
    element.classList.add("show-modal");
}

function fechaModalClientes() {
    var element = document.getElementById("modalsss");
    element.classList.remove("show-modal");
}