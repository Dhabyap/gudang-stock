<table id="example" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, 'asc']],
            "ajax": {
                "url": "<?= base_url('stock/datatables'); ?>",
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [[5, 10, 50], [5, 10, 50]],
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "created_at" }
            ]
        });
    });
</script>