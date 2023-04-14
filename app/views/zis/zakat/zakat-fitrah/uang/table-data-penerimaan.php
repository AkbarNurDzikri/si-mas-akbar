<div class="row">
  <div class="col-12 col-md-12">
    <!-- Navigasi Zakat Fitrah Zakat Mal -->
    <a href="<?= BASEURL . '/zakat_fitrah/uang' ?>" class="btn btn-primary mb-3">Zakat Fitrah</a>
    <a href="<?= BASEURL . '/zakat_mal/uang' ?>" class="btn btn-light mb-3">Zakat Mal</a>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <ul class="nav nav-tabs">
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="bi bi-cash-coin"></i> Uang</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-primary" href="<?= BASEURL . '/zakat_fitrah/uang' ?>"><i class="bi bi-download"></i> Penerimaan</a></li>
            <li><a class="dropdown-item" href="<?= BASEURL . '/zakat_fitrah/uang_keluar' ?>"><i class="bi bi-upload"></i> Pengeluaran</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#dateRangeReport"><i class="bi bi-filetype-pdf"></i> Laporan</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="bi bi-slack"></i> Beras</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= BASEURL . '/zakat_fitrah/beras' ?>"><i class="bi bi-download"></i> Penerimaan</a></li>
            <li><a class="dropdown-item" href="<?= BASEURL . '/zakat_fitrah/beras_keluar' ?>"><i class="bi bi-upload"></i> Pengeluaran</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf"></i> Laporan</a></li>
          </ul>
        </li>
      </ul>
    
      <div class="card-body table-responsive mt-3">
        <a href="<?= BASEURL . '/zakat_fitrah/catat_uang_masuk' ?>" class="btn btn-success btn-sm mb-3"><i class="bi bi-plus-circle"></i> Zakat Masuk</a>
        <table class="table table-striped display caption-top" id="myTable">
          <caption id="captionTable"></caption>
          <thead>
            <tr>
              <th class="text-center align-middle">No</th>
              <th class="text-center align-middle">Tanggal, Jam</th>
              <th class="text-center align-middle">Nama Muzakki</th>
              <th class="text-center align-middle">Alamat</th>
              <th class="text-center align-middle">Nilai Zakat</th>
              <th class="text-center align-middle">Keterangan</th>
              <th class="text-center align-middle">Petugas</th>
              <th class="text-center align-middle">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php $totalUangMasuk = 0; ?>
            <?php foreach($data['zakat_fitrah_uang_masuk'] as $fitrah) : ?>
              <?php $totalUangMasuk += $fitrah['qty_in'] ?>
              <tr>
                <td class="text-center align-middle"><?= $i++ ?></td>
                <td class="text-center align-middle"><?= date('d-M-y, H:i', strtotime($fitrah['created_at'])) ?></td>
                <td class="text-center align-middle"><?= $fitrah['person_name'] ?></td>
                <td class="text-center align-middle"><?= $fitrah['person_address'] ?></td>
                <td class="text-end align-middle">Rp. <?= number_format($fitrah['qty_in'], 2,',', '.') ?></td>
                <td class="text-center align-middle"><?= $fitrah['remarks'] ?></td>
                <td class="text-center align-middle"><?= $fitrah['username'] ?></td>
                <td class="text-center align-middle">
                  <a href="<?= BASEURL . "/zakat_fitrah/uang_masuk_edit/" . $fitrah['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                  <a href="javascript:confirmDelete(<?= $fitrah['id'] ?>, '<?= $fitrah['person_name'] ?>')" class="btn btn-sm btn-danger btnDelete" data-id="<?= $fitrah['id'] ?>"><i class="bi bi-trash3"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Date Range Report -->
<div class="modal fade" id="dateRangeReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dateRangeReportLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="dateRangeReportLabel">Laporan Penerimaan Zakat Fitrah (Uang)</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL . '/zakat_fitrah/laporan_uang_masuk' ?>" method="POST">
          <label for="start_date" class="form-label">Mulai tanggal</label>
          <input type="date" class="form-control mb-3" name="start_date">

          <label for="end_date" class="form-label">Sampai tanggal</label>
          <input type="date" class="form-control mb-3" name="end_date">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><i class="bi bi-cloud-arrow-down"></i> Download</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#captionTable').html(`<b>Total : Rp. <?= number_format($totalUangMasuk, 2, ',', '.') ?></b>`);

  function confirmDelete(id, name) {
    if(confirm(`Yakin hapus data ${name} ?`)) {
      $.ajax({
        url: '<?= BASEURL . "/zakat_fitrah/uang_masuk_delete/" ?>' + id,
        type: 'POST',
        data: 'id=' + id,
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil menghapus data zakat ' + name,
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/zakat_fitrah/uang" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal menghapus data zakat ' + name + ' !',
              text: res,
              showConfirmButton: true,
            })
          }
        }
      });
    }
  }
</script>