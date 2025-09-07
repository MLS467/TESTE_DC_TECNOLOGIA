export const initializeLocalStorage = () => {
    const salesInitial = {
        id_product: 0,
        id_client: 0,
        subtotal: 0,
        products: [],
    };

    localStorage.setItem("sales", JSON.stringify(salesInitial));
};

export const addLocalStorage = (values) => {
    let salesLocalStorage = getLocalStorage();

    if (salesLocalStorage === null) {
        initializeLocalStorage();
    }

    salesLocalStorage = getLocalStorage();

    let products = [...(salesLocalStorage.products || []), values.products];

    values.products = products;

    const total =
        (salesLocalStorage.subtotal || 0) + (parseFloat(values.subtotal) || 0);

    salesLocalStorage = {
        ...salesLocalStorage,
        ...values,
        subtotal: total,
    };

    localStorage.setItem("sales", JSON.stringify(salesLocalStorage));
};

export const getLocalStorage = () => {
    const sales = JSON.parse(localStorage.getItem("sales"));
    return sales;
};

export const clearLocalStorage = () => {
    localStorage.removeItem("sales");
};
