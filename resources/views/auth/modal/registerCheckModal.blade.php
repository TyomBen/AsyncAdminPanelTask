<div class="modal" id="errorModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-danger">Error</h4>
            </div>

            <div class="modal-body">
                <p class="text-danger" id="errorText"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function showErrorModal(errorMessage) {
        $('#errorText').text(errorMessage);
        $('#errorModal').modal('show');
    }
</script>
