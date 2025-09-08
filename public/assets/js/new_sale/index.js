import "./addProductButton.js";
import "./new_sale.js";

import {
    clearLocalStorage,
    getLocalStorage,
    initializeLocalStorage,
} from "./localStorage.js";

if (getLocalStorage() === null) initializeLocalStorage();

clearProductsButton.addEventListener("click", () => {
    clearLocalStorage();
    location.reload();
});
