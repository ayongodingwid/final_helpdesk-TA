$(document).ready(function() {
      // Add a new row to the table
      $("#add-menu-category").on("click", function() {
        const newRow = `
          <tr>
            <td><input type="text" class="form-control" placeholder="Enter Name"></td>
            <td><input type="text" class="form-control" placeholder="Enter Detail on ESO"></td>
            <td><input type="text" class="form-control" placeholder="Enter Code"></td>
            <td><input type="text" class="form-control" placeholder="Enter Description"></td>
            <td><input type="number" class="form-control" value="0"></td>
            <td>
              <input type="color" class="form-control form-control-color">
            </td>
            <td>
              <input type="file" class="form-control">
            </td>
            <td>
              <button class="btn btn-danger btn-sm remove-row">Remove</button>
            </td>
          </tr>`;
        $("#menu-category-table tbody").append(newRow);
      });

      $("#add-table-asset").on("click", function() {
        const newRow = `
        <tr>
            <td><input type="text" class="form-control"></td>                        
            <td><input type="number" class="form-control" value="0"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td>
                <button class="btn btn-danger btn-sm remove-row"><i class="bi bi-x-circle"></i></button>
            </td>
        </tr>`;
        $("#asset-table tbody").append(newRow);
      });

      $("#add-table-discount").on("click", function() {
        const newRow = `
        <tr>
                        <td>
                          <select class="form-select" id="Sales Mode">
                            <option selected></option>
                            <option value="1">Grab Food</option>
                            <option value="2">Go Food</option>
                            <option value="3">Shopee Food</option>
                            <option value="4">Dine In</option>
                            <option value="4">Take Away</option>
                        </select>
                        </td>                     
                        <td>
                          <select class="form-select" id="Sales Mode">
                            <option selected></option>
                            <option value="1">Rp.</option>
                            <option value="2">%</option>
                        </select>
                        </td> 
                        <td><input type="text" class="form-control"></td>
                        <td><input class="form-check-input" type="checkbox" id="gridCheck2"></td>   
                        <td>
                          <button class="btn btn-danger btn-sm remove-row"><i class="bi bi-x-circle"></i></button>
                        </td>
                      </tr>`;
        $("#discount-table tbody").append(newRow);
      });

      $("#add-table-price").on("click", function() {
        const newRow = `
        <tr>
          <td>
            <select class="form-select" id="Sales Mode">
              <option selected></option>
              <option value="1">Grab Food</option>
              <option value="2">Go Food</option>
              <option value="3">Shopee Food</option>
              <option value="4">Dine In</option>
              <option value="4">Take Away</option>
            </select>
          </td>                     
          <td><input type="text" class="form-control"></td>
          <td><input type="text" class="form-control"></td>
          <td><input type="text" class="form-control"></td>
          <td><input class="form-check-input" type="checkbox" id="gridCheck2"></td>   
          <td>
            <button class="btn btn-danger btn-sm remove-row"><i class="bi bi-x-circle"></i></button>
          </td>
        </tr>
        `;
        $("#price-table tbody").append(newRow);
      });

      $("#add-table-coa").on("click", function() {
        const newRow = `
        <tr>
                        <td>
                          <select class="form-select" id="Sales Mode">
                            <option selected></option>
                            <option value="1">Penambahan</option>
                            <option value="2">Perubahan</option>
                            <option value="3">Penghapusan</option>
                        </select>
                        </td>                     
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td>
                          <button class="btn btn-danger btn-sm remove-row"><i class="bi bi-x-circle"></i></button>
                        </td>
                      </tr>
        `;
        $("#coa-table tbody").append(newRow);
      });

      $("#add-table-subticket").on("click", function() {
        const newRow = `
        <tr>                
          <td><input type="text" class="form-control"></td>
          <td><input type="text" class="form-control"></td>
          <td>
            <button class="btn btn-danger btn-sm remove-row"><i class="bi bi-x-circle"></i></button>
          </td>
        </tr>
        `;
        $("#subticket-table tbody").append(newRow);
      });

      // Remove a row from the table
      $(document).on("click", ".remove-row", function() {
        $(this).closest("tr").remove();
      });
    });
