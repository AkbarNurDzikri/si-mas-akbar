<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/zakat" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <select id="chooseZakatType" class="form-select mb-3">
            <option value="" disabled selected>Pilih Jenis Zakat</option>
            <option value="Zakat Fitrah">Zakat Fitrah</option>
            <option value="Zakat Mal">Zakat Mal</option>
          </select>

          <label for="" class="form"></label>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#myForm').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#myForm').serialize();
    
    $.ajax({
      url: '<?= BASEURL . "/budgeting/create" ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menambahkan anggaran baru',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/budgeting" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan anggaran baru !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>