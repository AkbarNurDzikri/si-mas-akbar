<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/zakat_fitrah/uang_keluar' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['muzakki'][0]['id'] ?>">

          <label for="person_name" class="form-label mt-3" id="labelPersonName">Nama Mustahik</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" value="<?= $data['muzakki'][0]['person_name'] ?>" required>

          <label for="person_status" class="form-label">Status Mustahik</label>
          <select name="person_status" id="person_status" class="form-select mb-3">
            <option value="<?= $data['muzakki'][0]['person_status'] ?>">Exist : <?= $data['muzakki'][0]['person_status'] ?></option>
            <option value="" disabled>Pilih Status</option>
            <option value="Fakir">1. Fakir [Hampir tidak punya apa-apa]</option>
            <option value="Miskin">2. Miskin [Punya harta tapi tidak cukup untuk kebutuhan hidup]</option>
            <option value="Amil">3. Amil [Panitia penerima & penyalur zakat]</option>
            <option value="Mualaf">4. Mu'alaf [Orang yang baru masuk Islam]</option>
            <option value="Riqab">5. Hamba Sahaya [Budak yang ingin memerdekakan dirinya]</option>
            <option value="Gharimin">6. Gharimin [Orang yang berhutang untuk kebutuhan hidupnya]</option>
            <option value="Fisabilillah">7. Fisabilillah [Orang yang berjuang dijalan Allah: Dakwah, Jihad, dsb.]</option>
            <option value="Ibnu Sabil">8. Ibnus Sabil [Orang kehabisan biaya di perjalanan dalam ketaatan Allah]</option>
          </select>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required><?= $data['muzakki'][0]['person_address'] ?></textarea>

          <input type="hidden" name="zakat_type" value="Uang">

          <label for="qty_out" class="form-label" id="labelRupiah">Nominal Zakat</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_out" name="qty_out" autocomplete="off" value="<?= str_replace('.00', '', $data['muzakki'][0]['qty_out']) ?>" required>
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
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/zakat_fitrah/uang_keluar_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data penyaluran zakat untuk Bapak/Ibu ' + $('#person_name').val(),
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/zakat_fitrah/uang_keluar" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah data penyaluran zakat ' + $('#person_name').val(),
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>