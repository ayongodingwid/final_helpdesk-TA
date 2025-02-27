function voidMenu(data) {
    const modalBody = document.querySelector('#modal-body');
    let hRight = document.querySelector("#header-right");

    const hrData = `<p>Bisnis Unit : ${data.business_unit.name_bu}</p>
                    <p>Verifikasi : -</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);

    modalBody.innerHTML = `<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sales Mode</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Alasan Void</th>
                                        <th>PIN Void</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>${data.sales_mode.sales_name}</td>
                                        <td>${data.transaction_no}</td>
                                        <td>${data.reason_void}</td>
                                        <td><input type="text" class="form-control"></td>
                                    </tr>
                                </tbody>
                            </table>`;
    
}