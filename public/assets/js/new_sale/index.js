import "./addProductButton.js";
import "./new_sale.js";

import { getLocalStorage, initializeLocalStorage } from "./localStorage.js";

if (getLocalStorage() === null) initializeLocalStorage();
