document.addEventListener("DOMContentLoaded", function () {
    const filterInput = document.getElementById("tableFilter");
    const table = document.getElementById("dataTable");
    const tbody = table.querySelector("tbody");
    const rows = tbody.querySelectorAll("tr");

    filterInput.addEventListener("input", function () {
        const filterValue = this.value.toLowerCase().trim();

        rows.forEach((row) => {
            if (row.querySelector("td[colspan]")) {
                return;
            }

            const cells = row.querySelectorAll("td");
            let found = false;

            cells.forEach((cell) => {
                if (cell.textContent.toLowerCase().includes(filterValue)) {
                    found = true;
                }
            });

            if (found || filterValue === "") {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        checkNoResults();
    });

    function checkNoResults() {
        const visibleRows = Array.from(rows).filter(
            (row) =>
                row.style.display !== "none" &&
                !row.querySelector("td[colspan]")
        );

        let noResultsRow = tbody.querySelector(".no-results-row");

        if (visibleRows.length === 0 && filterInput.value.trim() !== "") {
            if (!noResultsRow) {
                noResultsRow = document.createElement("tr");
                noResultsRow.className = "no-results-row text-center";
                noResultsRow.innerHTML = `<td colspan="{{ count($columns) }}">Nenhum resultado encontrado</td>`;
                tbody.appendChild(noResultsRow);
            }
        } else {
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }
    }
});
