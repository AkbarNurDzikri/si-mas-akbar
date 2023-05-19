<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/event_cash' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['kas_masuk'][0]['id'] ?>">
          
          <label for="ref_event" class="form-label mt-3">Referensi Acara</label>
          <select name="ref_event" id="ref_event" class="form-select mb-3" required>
            <option value="<?= $data['kas_masuk'][0]['event_id'] ?>"><?= $data['kas_masuk'][0]['event_name'] ?></option>
            <option value="" disabled>Pilih Rapat</option>
            <?php foreach($data['ref_events'] as $ref) : ?>
              <option value="<?= $ref['id'] ?>"><?= $ref['event_name'] ?></option>
            <?php endforeach; ?>
          </select>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Misal: Dari Hamba Allah" required><?= $data['kas_masuk'][0]['remarks'] ?></textarea>

          <label for="qty_in" class="form-label" id="labelRupiah">Nominal</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_in" name="qty_in" autocomplete="off" required value="<?= str_replace('.00', '', $data['kas_masuk'][0]['qty_in']) ?>">
          </div>

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
      url: '<?= BASEURL . "/event_cash/pemasukan_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/event_cash" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah data',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>