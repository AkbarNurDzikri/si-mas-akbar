<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/zakat_fitrah/beras' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#kalkulatorModal"><i class="bi bi-calculator"></i> Kalkulator</button>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['muzakki'][0]['id'] ?>">
          <input type="hidden" name="person_status" value="Muzakki">

          <label for="person_name" class="form-label mt-3" id="labelPersonName">Nama Muzakki</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" value="<?= $data['muzakki'][0]['person_name'] ?>" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required><?= $data['muzakki'][0]['person_address'] ?></textarea>

          <input type="hidden" name="zakat_type" value="Beras">

          <label for="nilai_zakat" class="form">Nilai Zakat</label>
          <span class="spinner-grow spinner-grow-sm text-primary float-end" role="status"></span>
          <small class="text-muted float-end me-1"><i class="bi bi-info-circle"></i> 1 Kg = 0.753 Liter</small>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="nilai_zakat" step="any" autocomplete="off" value="<?= $data['muzakki'][0]['qty_in'] ?>" required>
            <span class="input-group-text" id="labelBeras">
              <input class="form-check-input" type="radio" name="satuan" id="kilogram"> &nbsp;
              <label class="form-check-label" for="kilogram">Kg</label>
            </span>
            <span class="input-group-text" id="labelBeras">
              <input class="form-check-input" type="radio" name="satuan" id="liter" checked> &nbsp;
              <label class="form-check-label" for="liter">Liter</label>
            </span>
          </div>

          <!-- untuk menampung nilai dari input nilai_zakat -->
          <input type="hidden" name="qty_in" id="qty_in">

          <label for="jumlah_jiwa" class="form-label" id="labelJumlahJiwa">Jumlah Jiwa</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="jumlah_jiwa" autocomplete="off" required>
            <span class="input-group-text" id="jumlah_jiwa">Orang</span>
          </div>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Opsional"><?= $data['muzakki'][0]['remarks'] ?></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Kalkulator -->
<div class="modal fade bg-dark" id="kalkulatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="kalkulatorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="kalkulatorModalLabel">Kalkulator Zakat Fitrah (Beras)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header text-center bg-dark text-white countResult"></div>
          <div class="card-body bg-dark text-white">
            <label for="besaranZakatKalkulator" class="form-label mt-3">Besaran Zakat</label>
            <div class="input-group mb-3">
              <input type="number" class="form-control" id="besaranZakatKalkulator" step="any" autocomplete="off" placeholder="Sesuaikan dengan pemerintah" required>
              <span class="input-group-text" id="labelBeras">Liter</span>
          </div>

          <label for="jumlah_jiwa_kalkulator" class="form-label">Jumlah Jiwa</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="jumlah_jiwa_kalkulator" autocomplete="off" required>
            <span class="input-group-text" id="labelBeras">Orang</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#jumlah_jiwa').on('keyup', () => {
    $('#jumlah_jiwa').val() == '' ? $('#remarks').val('') : $('#remarks').val($('#jumlah_jiwa').val() + ' Orang');
  });

  $('input[name="satuan"]').on('change', () => {
    if($('#kilogram').is(':checked')) {
      $('#qty_in').val($('#nilai_zakat').val() * 0.753);
    } else {
      $('#qty_in').val($('#nilai_zakat').val());
    }
  });

  $('#nilai_zakat').on('keyup', () => {
    if($('#kilogram').is(':checked')) {
      $('#qty_in').val($('#nilai_zakat').val() * 0.753);
    } else {
      $('#qty_in').val($('#nilai_zakat').val());
    }
  });

  if($('#kilogram').is(':checked')) {
    $('#qty_in').val($('#nilai_zakat').val() * 0.753);
  } else {
    $('#qty_in').val($('#nilai_zakat').val());
  }

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