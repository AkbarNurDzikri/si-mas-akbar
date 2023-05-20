<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASEURL . '/event_cash' ?>"><i class="bi bi-download"></i> Penerimaan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= BASEURL . '/event_cash/pengeluaran' ?>"><i class="bi bi-upload"></i> Pengeluaran</a>
        </li>
      </ul>
    
      <div class="card-body table-responsive mt-3">
        <div class="row mb-3">
          <div class="col">
            <a href="<?= BASEURL . '/event_cash/catat_pengeluaran' ?>" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Pengeluaran</a>
            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#dateRangeReport"><i class="bi bi-filetype-pdf"></i> Laporan</button>
          </div>
        </div>
        <table class="table table-striped display caption-top" id="myTable">
          <caption id="captionTable">Pengeluaran Semua Acara</caption>
          <thead>
            <tr>
              <th class="text-center align-middle">No</th>
              <th class="text-center align-middle">Tanggal, Jam</th>
              <th class="text-center align-middle">Acara</th>
              <th class="text-center align-middle">Keterangan</th>
              <th class="text-center align-middle">Nominal</th>
              <th class="text-center align-middle">Diinput Oleh</th>
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
        <h1 class="modal-title fs-5" id="dateRangeReportLabel">Laporan Kas Keluar Acara</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formReport" method="POST">
          <label for="ref_event" class="form-label">Pilih Acara</label>
          <select name="ref_event" id="ref_event" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Acara</option>
            <?php foreach($data['ref_events'] as $event) : ?>
              <option value="<?= $event['id'] ?>"><?= $event['event_name'] ?></option>
            <?php endforeach; ?>
          </select>

          <script>
            $('#ref_event').on('change', () => {
              $('#formReport').attr('action', '<?= BASEURL . '/event_cash/laporan_pengeluaran/' ?>' + $('#ref_event').val());
            });
          </script>

          <label for="start_date" class="form-label">Mulai tanggal</label>
          <input type="date" class="form-control mb-3" name="start_date" required>

          <label for="end_date" class="form-label">Sampai tanggal</label>
          <input type="date" class="form-control mb-3" name="end_date" required>
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
  function confirmDelete(id) {
    if(confirm(`Yakin hapus data ini ?`)) {
      $.ajax({
        url: '<?= BASEURL . "/event_cash/pengeluaran_delete/" ?>' + id,
        type: 'POST',
        data: 'id=' + id,
        success: function(res) {
          if(res == 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil menghapus kas keluar',
              showConfirmButton: true,
            }).then(() => {
              window.location = '<?= BASEURL . "/event_cash/pengeluaran" ?>'
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal menghapus kas keluar !',
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
        'url': '<?= BASEURL . "/event_cash/kasKeluarAjax" ?>',
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
          'data': 'event_name',
          'class': 'text-center align-middle',
        },
        {
          'data': 'remarks',
          'class': 'text-center align-middle',
        },
        {
          'data': 'qty_out',
          'class': 'text-end align-middle',
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
        'searchPlaceholder': 'Ketik Acara'
      },
    });
  });
</script>