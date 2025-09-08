import { addLocalStorage } from "./localStorage.js";

const productSelect = document.getElementById("productSelect");
const quantityInput = document.getElementById("quantity");
const unitValueInput = document.getElementById("unit_value");
const subtotalInput = document.getElementById("subtotal");
const addProductButton = document.getElementById("addProductButton");
const productsTableBody = document.getElementById("productsTableBody");

addProductButton.addEventListener("click", (event) => {
    event.preventDefault();

    const td = document.createElement("td");
    td.textContent = productSelect.options[productSelect.selectedIndex].text
        .split("|")[0]
        .trim();
    productsTableBody.appendChild(td);

    const td2 = document.createElement("td");
    td2.textContent = quantityInput.value;
    productsTableBody.appendChild(td2);

    const td3 = document.createElement("td");
    td3.textContent = unitValueInput.value;
    productsTableBody.appendChild(td3);

    const td4 = document.createElement("td");
    td4.textContent = subtotalInput.value;
    productsTableBody.appendChild(td4);

    const btnDelete = document.createElement("button");
    btnDelete.textContent = "Excluir";
    btnDelete.classList.add("btn", "btn-danger", "btn-sm");
    btnDelete.addEventListener("click", () => {
        productsTableBody.removeChild(tr);
    });

    const btnEdit = document.createElement("button");
    btnEdit.textContent = "Editar";
    btnEdit.classList.add("btn", "btn-warning", "btn-sm");

    const td5 = document.createElement("td");
    td5.appendChild(btnDelete);
    td5.appendChild(btnEdit);

    const tr = document.createElement("tr");
    tr.appendChild(td);
    tr.appendChild(td2);
    tr.appendChild(td3);
    tr.appendChild(td4);
    tr.appendChild(td5);

    const sales = {
        id_product: productSelect.value,
        id_client: document.getElementById("clientSelect").value,
        unit_value: unitValueInput.value,
        subtotal: subtotalInput.value,
        products: {
            id: productSelect.value,
            item: productSelect.options[productSelect.selectedIndex].text,
            quantity: quantityInput.value,
            unit_value: unitValueInput.value,
        },
    };

    addLocalStorage(sales);

    productsTableBody.appendChild(tr);
});
