<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/budgeting" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        <a href="<?= BASEURL ?>/budgeting/pdf/<?= $data['budgets'][0]['event_id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
      </div>
      <div class="card-body">
        <input type="hidden" name="id" value="<?= $data['budgets'][0]['id'] ?>" id="id">
        <h5 class="mt-3"><?= isset($data['budgets'][0]['event_name']) ? $data['budgets'][0]['event_name'] : 'Anggaran Belum Dibuat' ?></h5>
        
        <div id="boxAnggaran">
          <div class="inputAnggaran mt-3">
            <?php $no = 1; $titleBudget = 1; $textTitleBudget = 1;?>
            <?php foreach($data['budgets'] as $budget) : ?>
              <h6 class="text-muted d-inline" id="titleBudget<?= $titleBudget++ ?>">Budget #<?= $textTitleBudget++ ?></h6> | 
              <a href="#" class="text-primary updateBudget" data-id="<?= $budget['id'] ?>" data-event-id="<?= $budget['event_id'] ?>"><b><i class="bi bi-send-check"></i> Update</b></a> | 
              <a href="#" class="text-danger confirmDeleteBudget" data-bs-toggle="modal" data-bs-target="#modalDeleteBudget" data-id="<?= $budget['id'] ?>" data-name="<?= $budget['budget_name'] ?>"><b><i class="bi bi-trash3"></i> Hapus</b></a> <br>

              <label for="budgetName" class="form-label mt-3" id="labelbudgetName">Item Anggaran</label>
              <input type="text" class="form-control mb-3 budgetNames" name="budget_name" value="<?= $budget['budget_name'] ?>" placeholder="Sewa Sound System" autocomplete="off" required>

              <label for="budgetPrice" class="form-label" id="labelbudgetPrice">Dana Anggaran</label>
              <div class="input-group mb-3">
                <span class="input-group-text" id="budgetPrice">Rp.</span>
                <input type="number" class="form-control budgetPrices" name="budget_price" value="<?= $budget['budget_price'] ?>" required>
              </div>

              <label for="remarks" class="form-label" id="labelremarks">Keterangan</label>
              <textarea class="form-control mb-3 remarks" name="remarks" placeholder="Opsional"><?= $budget['remarks'] ?></textarea>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Form Update -->
<form id="formUpdate" action="<?= BASEURL . '/budgeting/update' ?>" method="POST">
  <input type="hidden" name="event_id" id="inputEventId">
  <input type="hidden" name="id" id="inputIdUpdate">
  <input type="hidden" name="budget_name" id="inputBudgetName">
  <input type="hidden" name="budget_price" id="inputBudgetPrice">
  <input type="hidden" name="remarks" id="inputRemarks">
</form>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="modalDeleteBudget" tabindex="-1" aria-labelledby="modalDeleteBudgetLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDeleteBudgetLabel">Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formDelete">
          <input type="hidden" id="inputId" name="id">
          <h4 class="text-center" id="confirmText"></h4>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const btnUpdate = $('.updateBudget');
  for(let i = 0; i < btnUpdate.length; i++) {
    btnUpdate[i].addEventListener('click', () => {
      $('#inputIdUpdate').val(btnUpdate[i].getAttribute('data-id'));
      const inputBudgetName = $('.budgetNames');
      const inputBudgetPrice = $('.budgetPrices');
      const inputRemarks = $('.remarks');
      $('#inputEventId').val(btnUpdate[i].getAttribute('data-event-id'));
      $('#inputBudgetName').val(inputBudgetName[i].value);
      $('#inputBudgetPrice').val(inputBudgetPrice[i].value);
      $('#inputRemarks').val(inputRemarks[i].value);
      $('#formUpdate').submit();
    });
  }

  const btnDelete = $('.confirmDeleteBudget');
  for(let i = 0; i < btnDelete.length; i++) {
    btnDelete[i].addEventListener('click', () => {
      $('#inputId').val(btnDelete[i].getAttribute('data-id'));
      $('#confirmText').html('Yakin hapus panitia <span class="text-danger">' + btnDelete[i].getAttribute('data-name') + '</span> ?');
    });
  }

  $('#formDelete').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formDelete').serialize();

    $.ajax({
      url: '<?= BASEURL . '/budgeting/delete' ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menghapus panitia',
            showConfirmButton: true,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus panitia !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>