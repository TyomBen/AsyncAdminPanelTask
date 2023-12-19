@include('auth.login')
@include('auth.modal.registerCheckModal')
<script>
    $(document).ready(function() {
        $(document).on("click", ".register-btn", function() {
            let email = $("#email").val();
            let password = $("#password").val();
            let remember = $("#remember").prop("checked");
            if (email != "" && password != "") {
                $.ajax({
                    type: "POST",
                    url: "/login",
                    data: {
                        email,
                        password,
                        remember,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function(response) {
                        window.location.href = "/admin/event";
                    },
                    error: function(errors) {
                        const errorResponse = errors.responseJSON;
                        const emailErrors = errorResponse.errors.email || [];
                        const passwordErrors = errorResponse.errors.password || [];
                        const allErrors = [...emailErrors, ...passwordErrors];
                        showErrorModal(allErrors);
                    },
                });
            } else {
                showErrorModal("All fields are required");
            }
        });
    });
</script>
