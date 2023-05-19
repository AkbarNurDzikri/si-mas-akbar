<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/event_cash/pengeluaran' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['kas_keluar'][0]['id'] ?>">

          <label for="ref_event" class="form-label mt-3">Referensi Acara</label>
          <select name="ref_event" id="ref_event" class="form-select mb-3" required>
            <option value="<?= $data['kas_keluar'][0]['event_id'] ?>"><?= $data['kas_keluar'][0]['event_name'] ?></option>
            <option value="" disabled>Pilih Acara</option>
            <?php foreach($data['ref_events'] as $ref) : ?>
              <option value="<?= $ref['id'] ?>" data-eventName="<?= $ref['event_name'] ?>"><?= $ref['event_name'] ?></option>
            <?php endforeach; ?>
          </select>

          <label for="remarks" class="form-label">Keterangan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Misal: Dari Hamba Allah" required><?= $data['kas_keluar'][0]['remarks'] ?></textarea>

          <label for="qty_out" class="form-label" id="labelRupiah">Nominal</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_out" name="qty_out" autocomplete="off" value="<?= str_replace('.00', '', $data['kas_keluar'][0]['qty_out']) ?>" required>
          </div>

          <button type="submit" class="btn btn-primary btn-sm float-end btnUpdate">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#qty_out').on('keyup', () => {
    const formData = $('#myForm').serialize();
    let totalKasMasuk = 0;
    let totalKasKeluar = 0;
    let saldo = 0;
    
    $.ajax({
      url: '<?= BASEURL . "/event_cash/getKasMasuk/" ?>' + $('#ref_event').val(),
      type: 'POST',
      data: formData,
      success: function(res) {
        totalKasMasuk = Number(JSON.parse(res)[0].totalKasMasuk);

        $.ajax({
          url: '<?= BASEURL . "/event_cash/getKasKeluar/" ?>' + $('#ref_event').val(),
          type: 'POST',
          data: formData,
          success: function(res) {
            totalKasKeluar = Number(JSON.parse(res)[0].totalKasKeluar);
            saldo = (totalKasMasuk - totalKasKeluar) + <?= $data['kas_keluar'][0]['qty_out'] ?>;

            if($('#qty_out').val() > saldo) {
              Swal.fire({
                icon: 'error',
                title: 'Saldo Kas tidak cukup !',
                html: 'Nama Kas : ' + $('#ref_event').find(':selected').text() + ' <br> Sisa saldo : <b style="color: green;">Rp. ' + saldo.toLocaleString('id-ID') + '</b>',
                showConfirmButton: true,
              });
              $('.btnUpdate').prop('disabled', true);
            } else {
              $('.btnUpdate').prop('disabled', false);
            }
          }
        });
      }
    });
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/event_cash/pengeluaran_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah kas keluar',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/event_cash/pengeluaran" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menyimpan kas keluar',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>