function discount(data) {
    const modalBody = document.querySelector('#modal-body');
    const salesMode = JSON.parse(data.sales_mode);
    const tipe = JSON.parse(data.tipe);
    const nominal = JSON.parse(data.nominal);
    const taxStatus = JSON.parse(data.tax_status);
    let hRight = document.querySelector("#header-right");

    const hrData = `<p>Bisnis Unit : ${data.business_unit.name_bu}</p>
                    <p>Verifikasi : -</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);

    let tableContent = `<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sales Mode</th>
                                        <th>Potongan</th>
                                        <th>Nominal Diskon</th>
                                        <th>Pajak</th>
                                        <th>Nama Diskon</th>
                                    </tr>
                                </thead>
                                <tbody>`;
    salesMode.forEach(function(sales, index) {
        tableContent += `
                        <tr>
                            <td>${salesMode[index]}</td>
                            <td>${tipe[index]}</td>
                            <td>${nominal[index]}</td>
                            <td><input class="form-check-input" type="checkbox"
                                    id="gridCheck2" ${taxStatus[index] == "on" ? "checked" : ""} disabled></td>
                            <td><input type="text" class="form-control"></td>
                        </tr>`;
    })


    tableContent += `</tbody>
                        </table>`;

    modalBody.innerHTML = tableContent;
}