const container = document.getElementById("hiddenFields");

export const createHiddenFields = () => {
    container.innerHTML = "";

    const sales = JSON.parse(localStorage.getItem("sales"));

    const simpleFields = ["id_client", "subtotal", "unit_value"];
    simpleFields.forEach((key) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = sales[key];
        container.appendChild(input);
    });

    sales.products.forEach((prod, index) => {
        const inputItem = document.createElement("input");
        inputItem.type = "hidden";
        inputItem.name = `products[${index}][item]`;
        inputItem.value = prod.item;
        container.appendChild(inputItem);

        const inputQty = document.createElement("input");
        inputQty.type = "hidden";
        inputQty.name = `products[${index}][quantity]`;
        inputQty.value = prod.quantity;
        container.appendChild(inputQty);

        const inputUnitValue = document.createElement("input");
        inputUnitValue.type = "hidden";
        inputUnitValue.name = `products[${index}][unit_value]`;
        inputUnitValue.value = prod.unit_value;
        container.appendChild(inputUnitValue);

        const inputId = document.createElement("input");
        inputId.type = "hidden";
        inputId.name = `products[${index}][id]`;
        inputId.value = prod.id;
        container.appendChild(inputId);
    });
};
