<div class="modal" id="userInfoModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title text-info">Detailed Information About The User</h4>
            </div>

            <div class="modal-body">
                <p class="text-primary" id="info"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function showUserInfo(...info) {
        $('#info').text(info);
        $('#userInfoModal').modal('show');
    }
</script>
