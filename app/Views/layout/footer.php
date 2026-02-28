</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#">M. Yusril Helmi Setyawan</a>.</strong>
    - PM Lab Riset.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0-PRO
    </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
    function confirmSubmit(type) {
        const form = document.getElementById(type + '-form');
        if (!form) return;

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        let title = 'Kunci Jawaban?';
        let text = "Pastikan semua jawaban sudah sesuai. Setelah disubmit, jawaban akan dikunci.";
        let confirmBtn = 'Ya, Submit Jawaban';

        if (type === 'vark') {
            title = 'Kunci Jawaban VARK?';
            text = "Setelah disubmit, Anda akan diarahkan ke tahap kuesioner MSLQ.";
        } else if (type === 'mslq') {
            title = 'Kunci Evaluasi MSLQ?';
            text = "Setelah disubmit, Anda akan diarahkan ke tahap kuesioner AMS.";
        } else if (type === 'ams') {
            title = 'Selesaikan Kuesioner?';
            text = "Ini adalah tahap terakhir. Jawaban Anda akan diproses untuk profil belajar.";
            confirmBtn = 'Ya, Selesaikan & Kunci!';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmBtn,
            cancelButtonText: 'Tinjau Kembali',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
</body>

</html>