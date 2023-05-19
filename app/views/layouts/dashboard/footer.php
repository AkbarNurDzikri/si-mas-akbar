</section>
</main><!-- End #main -->

<!-- Vendor JS Files -->
<script src="<?= BASEURL ?>/assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASEURL ?>/assets/dashboard/vendor/datatables/datatables.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= BASEURL ?>/assets/dashboard/js/main.js"></script>

  <script>
    const noteRelease = () => {
      Swal.fire({
        icon: 'info',
        title: 'Fitur sedang dalam tahap pengembangan',
        text: 'Info lebih lanjut, hubungi Kang Dzikri ya ..',
        showConfirmButton: true,
      })
    };
  </script>

</body>

</html>