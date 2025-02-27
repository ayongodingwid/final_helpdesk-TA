function programPromo(data) {
    const modalBody = document.querySelector('#modal-body');
    let hRight = document.querySelector("#header-right");

    const hrData = `<p>Bisnis Unit : ${data.business_unit.name_bu}</p>`;
    let newElement = document.createElement('div');
    newElement.className = "optional-data";
    newElement.innerHTML = hrData;
    hRight.appendChild(newElement);

    modalBody.innerHTML = ` <div class="py-1">
                            <p class="h6"><strong>Subjek</strong></p>
                            <p>${data.ticket.subcategory.name}</p>
                        </div>
                        <div class="py-1">
                            <p class="h6"><strong>Detail</strong></p>
                            <p>${data.description}</p>
                        </div>
                        <div class="py-1">
                            <p class="h6"><strong>File Pendukung</strong></p>
                            <a type="button" class="btn btn-warning"
                                href="../../dashboard/form/reqasset.html"><i
                                    class="bi bi-file-earmark-pdf me-1"></i>Lihat</a>
                        </div>`;
    
}