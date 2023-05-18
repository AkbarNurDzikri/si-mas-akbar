<?php
  // define saldo
  $totalUangMasuk = 0;
  foreach($data['totalUangMasuk'] as $uangMasuk) :
    $totalUangMasuk += $uangMasuk['qty_in'];
  endforeach;

  $totalUangKeluar = 0;
  foreach($data['totalUangKeluar'] as $uangKeluar) :
    $totalUangKeluar += $uangKeluar['qty_out'];
  endforeach;

  $saldo = $totalUangMasuk - $totalUangKeluar;
?>

<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL . '/infaq/pengeluaran' ?>/" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['muslim'][0]['id'] ?>">

          <label for="person_name" class="form-label mt-3" id="labelPersonName">Nama Penerima</label>
          <input type="text" class="form-control mb-3" name="person_name" id="person_name" autocomplete="off" value="<?= $data['muslim'][0]['person_name'] ?>" required>

          <label for="person_address" class="form-label">Alamat</label>
          <textarea name="person_address" id="person_address" class="form-control mb-3" placeholder="Perum MAP Blok UU No. 20" required><?= $data['muslim'][0]['person_address'] ?></textarea>

          <label for="qty_out" class="form-label" id="labelRupiah">Nominal</label>
          <div class="input-group mb-3">
            <span class="input-group-text" id="labelRupiah">Rp.</span>
            <input type="number" class="form-control" id="qty_out" name="qty_out" autocomplete="off" value="<?= str_replace('.00', '', $data['muslim'][0]['qty_out']) ?>" required>
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
  $('#qty_out').on('keyup', () => {
    const saldo = <?= $saldo + $data['muslim'][0]['qty_out'] ?>;
    if($('#qty_out').val() > saldo) {
      Swal.fire({
        icon: 'error',
        title: 'Saldo infaq tidak cukup !',
        html: 'Sisa saldo : <b style="color: green;">Rp. ' + saldo.toLocaleString('id-ID') + '</b>',
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
      url: '<?= BASEURL . "/infaq/pengeluaran_update" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah data penyaluran infaq untuk Bapak/Ibu ' + $('#person_name').val(),
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/infaq/pengeluaran" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah data penyaluran infaq ' + $('#person_name').val(),
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>