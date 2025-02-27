function permintaanAset(data) {
    const modalBody = document.querySelector('#modal-body');

    const assetName = JSON.parse(data.asset_name);
    const qty = JSON.parse(data.quantity);
    const receiver = JSON.parse(data.asset_receiver);
    const receiverPosition = JSON.parse(data.asset_receiver_position);
    const position = JSON.parse(data.position);
    let sumQty = qty.reduce((accumulator, currentValue) => accumulator + Number(currentValue), 0);

    let hRight = document.querySelector("#header-right");

    const hrData = `<p>Bisnis Unit : ${data.business_unit.name_bu}</p>
                    <p>Total Aset : ${sumQty}</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);

    let tableContent = `
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Aset</th>
                                        <th>Qty</th>
                                        <th>Nama Penerima</th>
                                        <th>Departemen/Divisi</th>
                                        <th>Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>`;

    assetName.forEach(function(asset, index) {
        tableContent += `
                        <tr>
                            <td>${assetName[index]}</td>
                            <td>${qty[index]}</td>
                            <td>${receiver[index]}</td>
                            <td>${receiverPosition[index]}</td>
                            <td>${position[index]}</td>
                        </tr>`;
    });

    tableContent += `
                    </tbody>
                </table>
            </div>
            <div class="py-1">
                <p class="h6">Harapan Aset Diterima : <strong>${data.expectation}</strong></p>
            </div>
            <div class="py-1">
                <p class="h6"><strong>Form Permintaan</strong></p>
                <a class="btn btn-primary"
                    href="/permintaan-aset/form/${data.id}"><i
                        class="bi bi-file-earmark-pdf me-1"></i>Cetak</a>
            </div>
            <div class="py-1">
                <p style="color: red; font-size: 12px;">**Catatan: Proses masih perlu
                    memberikan form fisik yang sudah di cetak/print dan di tanda tangani
                    pihak yang mengajukan untuk diserahkan ke tim ICT</p>
            </div>`;

    modalBody.innerHTML = tableContent;
    
}