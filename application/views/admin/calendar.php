<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Calendar</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="modalTitle"></span></p>
                <p><strong>Date:</strong> <span id="modalDate"></span></p>
                <p><strong>Harga:</strong> <span id="modalJumlah"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>

    $(document).ready(function () {
        var Calendar = FullCalendar.Calendar;
        var calendarEl = $('#calendar')[0];

        var calendar = new Calendar(calendarEl, {
            timeFormat: 'hh:mm a',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            editable: true,
            droppable: true,
            timeZone: 'Asia/Jakarta',
            events: {
                url: '<?= base_url('calendar/dataCalendar'); ?>',
                method: 'GET',
                failure: function () {
                    alert('There was an error while fetching events!');
                }
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();

                var eventId = info.event.id;

                $.ajax({
                    url: '<?= base_url('calendar/getEventDetails'); ?>', // Replace with your controller's method
                    method: 'POST',
                    data: { id: eventId },
                    success: function (response) {
                        var obj = JSON.parse(response);

                        console.log(obj);
                        $('#modalTitle').text(obj.keterangan);
                        $('#modalDate').text(obj.tanggal);
                        $('#modalJumlah').text(formatRupiah(obj.jumlah) + `-(${obj.waktu})`);

                        $('#eventDetailsModal').modal('show');
                    },
                    error: function () {
                        alert('Failed to fetch event details!');
                    }
                });
            }
        });

        calendar.render();
    });

</script>