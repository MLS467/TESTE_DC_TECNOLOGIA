export const Input = (index) => {
    const div = document.createElement("div");
    div.className = "mb-3 row g-2 align-items-end";

    const label = document.createElement("label");
    label.setAttribute("for", `installment_${index + 1}`);
    label.className = "form-label";
    label.textContent = `Parcela ${index + 1}`;
    div.appendChild(label);

    const colValor = document.createElement("div");
    colValor.className = "col";
    const inputValor = document.createElement("input");
    inputValor.type = "text";
    inputValor.className = "form-control";
    inputValor.id = `installment_${index + 1}`;
    inputValor.name = `installments[${index}][valor]`;
    inputValor.placeholder = "Valor";
    inputValor.dataset.fixo = "false";
    colValor.appendChild(inputValor);

    const colDate = document.createElement("div");
    colDate.className = "col";
    const inputDate = document.createElement("input");
    inputDate.type = "date";
    inputDate.className = "form-control";
    inputDate.name = `installments[${index}][data]`;

    const hoje = new Date();
    let mes = hoje.getMonth() + (index + 1);
    const ano = hoje.getFullYear() + Math.floor(mes / 12);
    mes = mes % 12;
    const mesStr = String(mes + 1).padStart(2, "0");
    inputDate.value = `${ano}-${mesStr}-28`;

    colDate.appendChild(inputDate);

    const colPayment = document.createElement("div");
    colPayment.className = "col";
    const selectPayment = document.createElement("select");
    selectPayment.className = "form-select";
    selectPayment.name = `installments[${index}][tipo_pagamento]`;
    selectPayment.innerHTML = `
        <option value="credit">Cartão de Crédito</option>
        <option value="cash">Dinheiro</option>
    `;
    colPayment.appendChild(selectPayment);

    div.appendChild(colDate);
    div.appendChild(colValor);
    div.appendChild(colPayment);

    installment.appendChild(div);

    return inputValor;
};
