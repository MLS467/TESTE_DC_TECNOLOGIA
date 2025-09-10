import { Input } from "./structFieldIputs.js";

const btn_add_installments = document.getElementById("btn_add_installments");
const quantity_installments = document.getElementById("quantity_installments");
const installment = document.getElementById("installment");
const subtotalInput = document.getElementById("subtotal");

let subtotal = parseFloat(document.getElementById("subtotal").value) || 0;

if (subtotal === 0) {
    const sales = JSON.parse(localStorage.getItem("sales"));
    subtotal = parseFloat(sales?.subtotal) || 0;
}

subtotalInput.value = `R$ ${subtotal.toFixed(2)}`;

btn_add_installments.addEventListener("click", function (e) {
    e.preventDefault();
    const quantity = parseInt(quantity_installments.value);
    installment.innerHTML = "";

    const inputs = [];
    for (let i = 0; i < quantity; i++) {
        inputs.push(Input(i));
    }

    const valorInicial = subtotal / inputs.length;
    inputs.forEach((input) => {
        input.value = valorInicial.toFixed(2);
    });

    inputs.forEach((input) => {
        input.addEventListener("input", () => {
            input.dataset.fixo = "true";

            const fixos = inputs.map((inp) =>
                inp.dataset.fixo === "true" ? parseFloat(inp.value) || 0 : null
            );
            const totalFixos = fixos.reduce((acc, val) => acc + (val || 0), 0);
            const restante = subtotal - totalFixos;

            const naoFixos = inputs.filter(
                (inp) => inp.dataset.fixo === "false"
            );

            naoFixos.forEach((inp) => {
                inp.value = (restante / naoFixos.length).toFixed(2);
            });
        });
    });
});
