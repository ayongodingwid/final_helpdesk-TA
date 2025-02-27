function selisihHarga(data) {
    const modalBody = document.querySelector('#modal-body');
    let salesMode = JSON.parse(data.sales_mode);
    let menu = JSON.parse(data.menu_name);
    let pricePos = JSON.parse(data.price_pos);
    let pricePlat = JSON.parse(data.price_salesmode);
    let taxStatus = JSON.parse(data.tax_status);
    let hRight = document.querySelector("#header-right");

    const hrData = `<p>Bisnis Unit : ${data.business_unit.name_bu}</p>
                    <p>Verifikasi : -</p>
                    <p>Staff Support : -</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);

    let tableContent = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Platform</th>
                                    <th>Menu</th>
                                    <th>Harga ESB</th>
                                    <th>Harga Platform</th>
                                    <th>Pajak</th>
                                </tr>
                            </thead>
                            <tbody>`
    salesMode.forEach(function(sales, index) {
        tableContent += `<tr>
                            <td>${sales}</td>
                            <td>${menu[index]}</td>
                            <td>${pricePos[index]}</td>
                            <td>${pricePlat[index]}</td>
                            <td><input class="form-check-input" type="checkbox"
                                    id="gridCheck2" ${taxStatus[index] == "on" ? "checked" : ""} disabled></td>
                        </tr>`;
    })


    tableContent += `</tbody>
                        </table>
    `;
    modalBody.innerHTML = tableContent;
    
}