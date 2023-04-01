<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/mom" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        <a href="<?= BASEURL ?>/mom/pdf/<?= $data['mom']['id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['mom']['id'] ?>" id="id">
          
          <label for="meeting_date" class="form-label">Tanggal Rapat</label>
          <input type="date" class="form-control mb-3" id="meeting_date" name="meeting_date" value="<?= $data['mom']['meeting_date'] ?>">

          <label for="meeting_time" class="form-label">Waktu Rapat</label>
          <input type="time" class="form-control mb-3" id="meeting_time" name="meeting_time" value="<?= $data['mom']['meeting_time'] ?>">

          <label for="meeting_room" class="form-label">Tempat Rapat</label>
          <input type="text" class="form-control mb-3" id="meeting_room" name="meeting_room" autocomplete="off" value="<?= $data['mom']['meeting_room'] ?>">

          <label for="meeting_participants" class="form-label">Anggota Rapat</label>
          <textarea class="form-control mb-3" name="meeting_participants" id="meeting_participants" required><?= $data['mom']['meeting_participants'] ?></textarea>

          <label for="title" class="form-label">Judul Rapat</label>
          <input type="text" class="form-control mb-3" id="title" name="title" autocomplete="off" value="<?= $data['mom']['title'] ?>">

          <label for="body" class="form-label">Isi Rapat</label>
          <div id="quillEditor" class="mb-3" required>
            <?= $data['mom']['body'] ?>
          </div>

          <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const quill = new Quill('#quillEditor', {
    theme: 'snow',
  });
  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('id', $('#id').val());
    formData.append('meeting_date', $('#meeting_date').val());
    formData.append('meeting_time', $('#meeting_time').val());
    formData.append('meeting_room', $('#meeting_room').val());
    formData.append('meeting_participants', $('#meeting_participants').val());
    formData.append('title', $('#title').val());
    formData.append('body', quill.root.innerHTML);

    $.ajax({
      url: '<?= BASEURL . '/mom/update/' ?>',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah notulen',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/mom" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah notulen !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>