<div class="modal" id="event-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-info">Create Event</h4>
            </div>

            <div class="modal-body">
                <label for="title">Create Title </label> <input type="text" placeholder="title" id="title"
                    class="form-control" value="{{ old('title') }}" />

                <label for="text">Create Text </label> <input type="text" placeholder="text" id="text"
                    class="form-control" value="{{ old('text') }}" /> <br>
                <button class="btn btn btn-primary" id="create-event"> Create </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showEventModal() {
        $('#event-modal').modal('show');
    }
</script>
