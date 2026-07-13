function confirmarEliminar() {
    return confirm("¿Estás seguro de que quieres eliminar este auto?");
}

// Formatea el precio con puntos de miles mientras el usuario escribe
function formatearPrecio(input) {
    let valor = input.value.replace(/\D/g, ''); // deja solo números
    if (valor) {
        valor = parseInt(valor, 10).toLocaleString('es-CL');
    }
    input.value = valor;
}

function validarFormulario() {
    prepararMarcaModelo();

    const precioInput = document.querySelector('input[name="precio"]');
    const stock = document.querySelector('input[name="stock"]');

    if (precioInput) {
        precioInput.value = precioInput.value.replace(/\./g, '');
    }

    if (precioInput && precioInput.value < 0) {
        alert("El precio no puede ser negativo");
        return false;
    }
    if (stock && stock.value < 0) {
        alert("El stock no puede ser negativo");
        return false;
    }
    return true;
}

function filtrarAutos() {
    const input = document.getElementById("buscador");
    const filtro = input.value.toLowerCase();
    const filas = document.querySelectorAll("table tbody tr");

    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? "" : "none";
    });
}

function resaltarStockBajo() {
    const filas = document.querySelectorAll("table tbody tr");
    filas.forEach(fila => {
        const stockCelda = fila.querySelector('[data-label="Stock"]');
        if (stockCelda && parseInt(stockCelda.textContent) < 2) {
            fila.style.backgroundColor = "#ffe5e5";
        }
    });
}

// Muestra/oculta el campo de texto según si eligieron "Otra" en el select
function mostrarCampoOtro(selectId, inputId) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    if (select.value === "otro") {
        input.style.display = "block";
        input.required = true;
    } else {
        input.style.display = "none";
        input.required = false;
        input.value = "";
    }
}

// Antes de enviar el formulario, si eligieron "Otra", copia el texto escrito al select
function prepararMarcaModelo() {
    const marcaSelect = document.getElementById("marca_select");
    const marcaOtro = document.getElementById("marca_otro");
    const modeloSelect = document.getElementById("modelo_select");
    const modeloOtro = document.getElementById("modelo_otro");

    if (marcaSelect.value === "otro" && marcaOtro.value.trim() !== "") {
        const opcion = new Option(marcaOtro.value, marcaOtro.value, true, true);
        marcaSelect.add(opcion);
        marcaSelect.value = marcaOtro.value;
    }
    if (modeloSelect.value === "otro" && modeloOtro.value.trim() !== "") {
        const opcion = new Option(modeloOtro.value, modeloOtro.value, true, true);
        modeloSelect.add(opcion);
        modeloSelect.value = modeloOtro.value;
    }
}

window.addEventListener("DOMContentLoaded", resaltarStockBajo);