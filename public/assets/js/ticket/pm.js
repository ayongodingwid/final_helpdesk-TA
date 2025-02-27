function penangananMasalah(data, permission) {
    console.log(permission);
    
    const modalBody = document.querySelector('#modal-body');
    const modalFooter = document.querySelector('#modal-footer');
    
    let hRight = document.querySelector("#header-right");
    
    const hrData = `<p>Verifikasi : -</p>
                    <p>Staff Support : -</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);
    
    modalBody.innerHTML = `<div class="py-1">
                            <p class="h6"><strong>Permintaan Perbaikan</strong></p>
                            <p>${data.ticket.subcategory.name}</p>
                        </div>
                        <div class="py-1">
                            <p class="h6"><strong>Detail</strong></p>
                            <p>${data.description}</p>
                        </div>
                        <div class="py-1">
                            <p class="h6"><strong>Laporan Perbaikan</strong></p>
                            <p>-</p>
                        </div>`;

    if (permission) {
        modalFooter.innerHTML = `<button type="button" class="btn btn-warning">Disetujui</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-penolakan">Tolak</button>`;
    }
}
