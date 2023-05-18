<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/infaq' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['muslim'][0]['id'] ?>">
          <input type="hidden" name="person_status" value="Muzakki">

          <label for="person_name" class="form-label mt-3" id="labelPersonName">Nama Donatur</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" value="<?= $data['muslim'][0]['person_name'] ?>" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required><?= $data['muslim'][0]['person_address'] ?></textarea>

          <label for="qty" class="form-label" id="labelRupiah">Nominal</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_in" name="qty_in" autocomplete="off" value="<?= str_replace('.00', '',$data['muslim'][0]['qty_in']) ?>" required>
          </div>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Opsional"><?= $data['muslim'][0]['remarks'] ?></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/infaq/penerimaan_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data infaq ' + $('#person_name').val(),
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/infaq/uang" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah data infaq ' + $('#person_name').val(),
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>