<?php
  // define saldo
  $totalBerasMasuk = 0;
  foreach($data['totalBerasMasuk'] as $berasMasuk) :
    $totalBerasMasuk += $berasMasuk['qty_in'];
  endforeach;

  $totalBerasKeluar = 0;
  foreach($data['totalBerasKeluar'] as $berasKeluar) :
    $totalBerasKeluar += $berasKeluar['qty_out'];
  endforeach;

  $saldo = $totalBerasMasuk - $totalBerasKeluar;
?>

<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/zakat_fitrah/beras_keluar' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
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

          <input type="hidden" name="zakat_type" value="Beras">

          <label for="qty_out" class="form-label" id="labelRupiah">Nilai Zakat</label>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="qty_out" name="qty_out" step="any" autocomplete="off" value="<?= $data['muzakki'][0]['qty_out'] ?>" required>
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
  $('#qty_out').on('keyup', () => {
    const saldo = <?= $saldo + $data['muzakki'][0]['qty_out'] ?>;
    if($('#qty_out').val() > saldo) {
      Swal.fire({
        icon: 'error',
        title: 'Saldo beras zakat tidak cukup !',
        html: 'Sisa saldo : <b style="color: green;">' + saldo + ' Liter</b>',
        showConfirmButton: true,
      });
      $('.btnSave').prop('disabled', true);
    } else {
      $('.btnSave').prop('disabled', false);
    }
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/zakat_fitrah/beras_keluar_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data penyaluran zakat untuk Bapak/Ibu ' + $('#person_name').val(),
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/zakat_fitrah/beras_keluar" ?>'
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