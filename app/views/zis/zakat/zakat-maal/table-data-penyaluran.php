<div class="row">
  <div class="col-12 col-md-12">
    <a href="<?= BASEURL . '/zakat_fitrah/uang' ?>" class="btn btn-light mb-3">Zakat Fitrah</a>
    <a href="<?= BASEURL . '/zakat_maal' ?>" class="btn btn-primary mb-3">Zakat Maal</a>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASEURL . '/zakat_maal' ?>"><i class="bi bi-download"></i> Penerimaan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= BASEURL . '/zakat_maal/pengeluaran' ?>"><i class="bi bi-upload"></i> Pengeluaran</a>
        </li>
      </ul>
    
      <div class="card-body table-responsive mt-3">
        <div class="row mb-3">
          <div class="col">
            <a href="<?= BASEURL . '/zakat_maal/catat_pengeluaran' ?>" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Pengeluaran</a>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#dateRangeReport"><i class="bi bi-filetype-pdf"></i> Laporan</button>
          </div>
        </div>
        <table class="table table-striped display caption-top" id="myTable">
          <caption id="captionTable"></caption>
          <thead>
            <tr>
              <th class="text-center align-middle">No</th>
              <th class="text-center align-middle">Tanggal, Jam</th>
              <th class="text-center align-middle">Nama Muzakki</th>
              <th class="text-center align-middle">Alamat</th>
              <th class="text-center align-middle">Nominal</th>
              <th class="text-center align-middle">Keterangan</th>
              <th class="text-center align-middle">Petugas</th>
              <th class="text-center align-middle">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php $totalUangMasuk = 0; ?>
            <?php foreach($data['zakat_keluar'] as $maal) : ?>
              <?php $totalUangMasuk += $maal['qty_out'] ?>
              <tr>
                <td class="text-center align-middle"><?= $i++ ?></td>
                <td class="text-center align-middle"><?= date('d-M-y, H:i', strtotime($maal['created_at'])) ?></td>
                <td class="text-center align-middle"><?= $maal['person_name'] ?></td>
                <td class="text-center align-middle"><?= $maal['person_address'] ?></td>
                <td class="text-end align-middle">Rp. <?= number_format($maal['qty_out'], 2,',', '.') ?></td>
                <td class="text-center align-middle"><?= $maal['remarks'] ?></td>
                <td class="text-center align-middle"><?= $maal['username'] ?></td>
                <td class="text-center align-middle">
                  <a href="<?= BASEURL . "/zakat_maal/pengeluaran_edit/" . $maal['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                  <a href="javascript:confirmDelete(<?= $maal['id'] ?>, '<?= $maal['person_name'] ?>')" class="btn btn-sm btn-danger btnDelete" data-id="<?= $maal['id'] ?>"><i class="bi bi-trash3"></i></a>
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
        <h1 class="modal-title fs-5" id="dateRangeReportLabel">Laporan Pengeluaran Zakat Maal</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= BASEURL . '/zakat_maal/laporan_pengeluaran' ?>" method="POST">
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
        url: '<?= BASEURL . "/zakat_maal/pengeluaran_delete/" ?>' + id,
        type: 'POST',
        data: 'id=' + id,
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil menghapus data zakat ' + name,
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/zakat_maal/pengeluaran" ?>'
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