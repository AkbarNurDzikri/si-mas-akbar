<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/zakat_maal' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <input type="hidden" name="person_status" value="Muzakki">

          <label for="person_name" class="form-label mt-3 " id="labelPersonName">Nama Muzakki</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required></textarea>

          <label for="qty_in" class="form-label" id="labelRupiah">Nominal</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_in" name="qty_in" autocomplete="off" required>
          </div>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Misal: Transfer / cash"></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#myForm').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/zakat_maal/penerimaan_store" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menerima zakat maal dari Bapak/Ibu <b>' + $('#person_name').val() + '</b>',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/zakat_maal" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menerima amanah zakat !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>