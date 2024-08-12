<!-- Bootstrap core JavaScript-->
<script src="<?= staticPath() ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= staticPath() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= staticPath() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= staticPath() ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= staticPath() ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= staticPath() ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= staticPath() ?>js/demo/datatables-demo.js"></script>

<!-- notif -->
<script src="<?= staticPath() ?>js/notify.min.js"></script>

<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    base_url = '<?= base_url() ?>'
</script>

<script>
    const formatRupiah = (angka) => {
        let rupiah = '';
        let angkarev = angka.toString().split('').reverse().join('');
        for (let i = 0; i < angkarev.length; i++) {
            if (i % 3 === 0) rupiah += angkarev.substr(i, 3) + '.';
        }
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    };
    var currentDate = new Date();

    var monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var formattedDate = currentDate.getDate() + ' ' +
        monthNames[currentDate.getMonth()] + ' ' +
        currentDate.getFullYear();
</script>