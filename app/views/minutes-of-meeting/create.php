<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/mom" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="meeting_date" class="form-label mt-3">Tanggal Rapat</label>
          <input type="date" class="form-control mb-3" id="meeting_date" name="meeting_date" required>

          <label for="meeting_time" class="form-label">Waktu Rapat</label>
          <input type="time" class="form-control mb-3" id="meeting_time" name="meeting_time" required>

          <label for="meeting_room" class="form-label">Tempat Rapat</label>
          <input type="text" class="form-control mb-3" id="meeting_room" name="meeting_room" placeholder="Halaman Masjid" autocomplete="off" required>

          <label for="meeting_participants" class="form-label">Anggota Rapat</label>
          <textarea class="form-control mb-3" name="meeting_participants" id="meeting_participants" placeholder="Bapak Fulan, Ibu Fulan ..." required></textarea>

          <label for="title" class="form-label">Judul Rapat</label>
          <input type="text" class="form-control mb-3" id="title" name="title" placeholder="Pembentukan panitia isra mi'raj" autocomplete="off" required>

          <label for="body" class="form-label">Isi Rapat</label>
          <div id="quillEditor" class="mb-3" required>
            <!-- user write here -->
          </div>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const quill = new Quill('#quillEditor', {
    theme: 'snow',
  });

  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('meeting_date', $('#meeting_date').val());
    formData.append('meeting_time', $('#meeting_time').val());
    formData.append('meeting_room', $('#meeting_room').val());
    formData.append('meeting_participants', $('#meeting_participants').val());
    formData.append('title', $('#title').val());
    formData.append('body', quill.root.innerHTML);
    
    $.ajax({
      url: '<?= BASEURL . "/mom/create" ?>',
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan notulen baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/mom" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan notulen baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>