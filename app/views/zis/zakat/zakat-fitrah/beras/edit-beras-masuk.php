<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/zakat_fitrah/beras' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['muzakki'][0]['id'] ?>">
          <input type="hidden" name="person_status" value="Muzakki">

          <label for="besaran_zakat" class="form-label mt-3">Besaran Zakat / Jiwa</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="besaran_zakat" placeholder="Sesuaikan dengan pemerintah" value="3.5" step="any" autocomplete="off" required>
            <span class="input-group-text" id="labelRupiah">Liter</span>
          </div>

          <label for="person_name" class="form-label" id="labelPersonName">Nama Muzakki</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" value="<?= $data['muzakki'][0]['person_name'] ?>" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required><?= $data['muzakki'][0]['person_address'] ?></textarea>

          <input type="hidden" name="zakat_type" value="Beras">
          
          <label for="qty" class="form-label" id="labelJumlahJiwa">Jumlah Jiwa</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="jumlah_jiwa" autocomplete="off">
            <span class="input-group-text" id="jumlah_jiwa">Orang</span>
          </div>

          <label for="qty" class="form-label" id="labelRupiah">Nilai Zakat Standar</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="qty_in" name="qty_in" step="any" autocomplete="off" value="<?= $data['muzakki'][0]['qty_in'] ?>" required>
            <span class="input-group-text" id="labelRupiah">Liter</span>
          </div>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Opsional"><?= $data['muzakki'][0]['remarks'] ?></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#jumlah_jiwa').on('keyup', () => {
    const nilaiZakat = $('#besaran_zakat').val() * $('#jumlah_jiwa').val();
    $('#qty_in').val(nilaiZakat);
    $('#jumlah_jiwa').val() == '' ? $('#remarks').val('') : $('#remarks').val($('#jumlah_jiwa').val() + ' Orang');
  });

  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/zakat_fitrah/beras_masuk_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data zakat ' + $('#person_name').val(),
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/zakat_fitrah/beras" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah data zakat ' + $('#person_name').val(),
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>