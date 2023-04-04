<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/budgeting" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <div id="boxBudget">
            <div class="inputBudget">
              <h6 class="text-muted mt-3" id="titleBudget1">Budget #1</h6>
              
              <label for="budgetName1" class="form-label mt-3" id="labelbudgetName1">Item Anggaran</label>
              <input type="text" class="form-control mb-3" id="budgetName1" name="budgets[budget_name][1]" placeholder="Sewa Sound System" autocomplete="off" required>
              
              <label for="budgetPrice1" class="form-label" id="labelbudgetPrice1">Dana Anggaran</label>
              <div class="input-group mb-3">
                <span class="input-group-text" id="budgetPrice1">Rp.</span>
                <input type="number" class="form-control" id="budgetPrice1" name="budgets[budget_price][1]" required>
              </div>

              <label for="remarks1" class="form-label" id="labelremarks1">Keterangan</label>
              <textarea class="form-control mb-3" name="budgets[remarks][1]" id="remarks1" placeholder="Opsional" required></textarea>
            </div>
          </div>

          <button type="button" class="btn btn-sm btn-primary" onclick="addBudget()">+ Anggaran</button>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#titleBudget1').hide();

  const addBudget = () => {
    let itemNum = document.querySelectorAll('#boxBudget>.inputBudget').length + 1;
    
    if(itemNum > 1) {
      $('#titleBudget1').show();
    }

    const html = `
    <div class="inputBudget" id="budgetInput${itemNum}">
      <h6 class="text-muted" id="titleBudget${itemNum}">Budget #${itemNum} | <a href="javascript:deleteBudget(${itemNum})" class="text-danger"><i class="bi bi-trash3"></i> Hapus</a></h6>
      
      <label for="budgetName${itemNum}" class="form-label" id="labelbudgetName${itemNum}">Item Anggaran</label>
      <input type="text" class="form-control mb-3" id="budgetName${itemNum}" name="budgets[budget_name][${itemNum}]" placeholder="Sewa Sound System" autocomplete="off" required>
      
      <label for="budgetPrice${itemNum}" class="form-label" id="labelbudgetPrice${itemNum}">Dana Anggaran</label>
      <div class="input-group mb-3">
        <span class="input-group-text" id="budgetPrice${itemNum}">Rp.</span>
        <input type="number" class="form-control" id="budgetPrice${itemNum}" name="budgets[budget_price][${itemNum}]">
      </div>

      <label for="remarks${itemNum}" class="form-label" id="labelremarks${itemNum}">Keterangan</label>
      <textarea class="form-control mb-3" name="budgets[remarks][${itemNum}]" id="remarks${itemNum}" placeholder="Opsional" required></textarea>
    </div>
    `;
    $('#boxBudget').append(html);
  };

  const deleteBudget = (id) => {
    let itemNum = document.querySelectorAll('#boxPanitia>.inputPanitia').length;
    $('#budgetInput' + id).remove();
  };

  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#myForm').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/budgeting/create/" . $data['eventId'] ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan anggaran baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/budgeting" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan anggaran baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>