import { createHiddenFields } from "./hiddenFields.js";
import {
    getLocalStorage,
    clearLocalStorage,
} from "../new_sale/localStorage.js";

const form = document.getElementById("form_payment");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    let salesLocalStorage = getLocalStorage();

    const inputsValor = [
        ...document.querySelectorAll("#installment input[type='text']"),
    ];

    let somaParcelas = 0;
    for (let i = 0; i < inputsValor.length; i++) {
        somaParcelas += parseFloat(inputsValor[i].value) || 0;
    }

    const subtotalValue = Math.floor(
        parseFloat(salesLocalStorage.subtotal).toFixed(2)
    );

    const somaParcelasFormatada = Math.floor(
        parseFloat(somaParcelas).toFixed(2)
    );

    if (subtotalValue !== somaParcelasFormatada) {
        alert("A soma das parcelas não corresponde ao valor total.");
        location.reload();
        return;
    }

    createHiddenFields();

    form.submit();
    clearLocalStorage();
});
