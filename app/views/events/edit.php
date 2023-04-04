<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/events" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['event']['id'] ?>" id="id">

          <label for="status" class="form-label mt-3">Status</label>
          <select name="status" id="status" class="form-select mb-3">
            <option value="<?= $data['event']['status'] ?>"><?= strtoupper($data['event']['status']) ?></option>
            <option value="<?= $data['event']['status'] == 'open' ? 'closed' : 'open' ?>"><?= $data['event']['status'] == 'open' ? 'CLOSED' : 'OPEN' ?></option>
          </select>
          
          <label for="ref_meeting" class="form-label">Rujukan Rapat</label>
          <select name="ref_meeting" id="ref_meeting" class="form-select mb-3" required>
            <option value="<?= $data['event']['ref_meeting'] ?>"><?= $data['event']['title'] ?></option>
            <option value="" disabled>Pilih Rapat</option>
            <!-- <option value="NULL">Tanpa Rapat</option> Disiapkan tanpa rapat karena kemungkinan ada acara tanpa rapat terlebih dahulu. Ini dinonaktifkan sementara (asumsi selalu ada rapat). Jika benar-benar ada acara tanpa rapat sebelumnya, harus dibuat minutes_of_meetings dengan judul anonim untuk mengisi acara tanpa rapat. -->
            <?php foreach($data['ref_meeting'] as $ref) : ?>
              <option value="<?= $ref['id'] ?>"><?= $ref['title'] ?></option>
            <?php endforeach; ?>
          </select>

          <label for="event_name" class="form-label">Nama Acara</label>
          <input type="text" class="form-control mb-3" id="event_name" name="event_name" autocomplete="off" value="<?= $data['event']['event_name'] ?>" required>

          <label for="event_date" class="form-label">Tanggal Acara</label>
          <input type="date" class="form-control mb-3" id="event_date" name="event_date" value="<?= $data['event']['event_date'] ?>" required>
          
          <label for="event_time" class="form-label">Tanggal Acara</label>
          <input type="time" class="form-control mb-3" id="event_time" name="event_time" value="<?= $data['event']['event_time'] ?>" required>

          <label for="event_location" class="form-label">Lokasi Acara</label>
          <input type="text" class="form-control mb-3" id="event_location" name="event_location" autocomplete="off" value="<?= $data['event']['event_location'] ?>" required>

          <label for="remarks" class="form-label">Keterangan tambahan</label>
          <textarea name="remarks" id="remarks" class="form-control mb-3" placeholder="Opsional"><?= $data['event']['remarks'] ?></textarea>

          <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#ref_meeting').on('change', () => {
    if($('#ref_meeting option:selected').text() == 'Tanpa Rapat') {
      $('#event_name').val('');
    } else {
      $('#event_name').val($('#ref_meeting option:selected').text());
    }
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formEdit').serialize();

    $.ajax({
      url: '<?= BASEURL . '/events/update/' ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah agenda',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/events" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah agenda !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>