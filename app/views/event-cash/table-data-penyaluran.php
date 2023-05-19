<div class="row">
  <div class="col-12 col-md-12">
    <a href="<?= BASEURL . '/zakat_fitrah/uang' ?>" class="btn btn-light mb-3">Zakat Fitrah</a>
    <a href="<?= BASEURL . '/zakat_maal' ?>" class="btn btn-primary mb-3">Zakat Maal</a>
  </div>
</div>

<?php $i = 1; ?>
<?php $totalUangMasuk = 0; ?>
<?php foreach($data['zakat_keluar'] as $maal) : ?>
  <?php $totalUangMasuk += $maal['qty_out'] ?>
<?php endforeach; ?>

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
              <th class="text-center align-middle">Nama Mustahik</th>
              <th class="text-center align-middle">Alamat</th>
              <th class="text-center align-middle">Nominal</th>
              <th class="text-center align-middle">Keterangan</th>
              <th class="text-center align-middle">Petugas</th>
              <th class="text-center align-middle">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <!-- List data diisi oleh datatable serverside -->
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

  // datatable serverside
  $(function() {
    $('#myTable').dataTable({
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': '<?= BASEURL . "/zakat_maal/zakatMaalKeluarAjax" ?>',
        'dataType': 'json',
        'type': 'POST'
      },
      'columns': [
        {
          'data': 'no',
          'class': 'text-center align-middle',
        },
        {
          'data': 'created_at',
          'class': 'text-center align-middle',
        },
        {
          'data': 'person_name',
          'class': 'text-center align-middle',
        },
        {
          'data': 'person_address',
          'class': 'text-center align-middle',
        },
        {
          'data': 'qty_out',
          'class': 'text-end align-middle',
        },
        {
          'data': 'remarks',
          'class': 'text-center align-middle',
        },
        {
          'data': 'username',
          'class': 'text-center align-middle',
        },
        {
          'data': 'action',
          'class': 'text-center align-middle',
        },
      ],
      'language': {
        'searchPlaceholder': 'Ketik nama Mustahik'
      },
    });
  });
</script>