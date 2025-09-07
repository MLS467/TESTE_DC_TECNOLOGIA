const productSelect = document.getElementById("productSelect");
const quantityInput = document.getElementById("quantity");
const unitValueInput = document.getElementById("unit_value");
const subtotalInput = document.getElementById("subtotal");

const clearFields = () => {
    quantityInput.value = "";
    unitValueInput.value = "";
    subtotalInput.value = "";
};

productSelect.addEventListener("change", () => {
    clearFields();
    const selectedText =
        productSelect.options[productSelect.selectedIndex].text;

    const valueText = selectedText.split("|")[1].trim();

    const numericValue = parseFloat(
        valueText.replace("R$", "").replace(".", "").replace(",", ".")
    );

    unitValueInput.value = numericValue;
});

quantityInput.addEventListener("blur", () => {
    const newValue =
        parseFloat(quantityInput.value) * parseFloat(unitValueInput.value);
    subtotalInput.value = newValue.toFixed(2);
});
