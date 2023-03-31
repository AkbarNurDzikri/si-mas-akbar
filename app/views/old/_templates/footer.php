        </div>
    </div>
</div>

    <!-- Modal Logout -->
    <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Yakin ingin keluar dari aplikasi?</h3>
                </div>
                <div class="modal-footer">
                    <a href="<?= BASEURL ?>/auth/logout" class="btn btn-primary">Logout</a>
                    <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?= BASEURL; ?>/assets/js/bootstrap.js"></script>
    <script src="<?= BASEURL; ?>/assets/js/app.js"></script>
    <script src="<?= BASEURL ?>/assets/package/dist/sweetalert2.min.js"></script>
</body>
</html>