@include('auth.register')
@include('auth.modal.registerCheckModal')
<script>
    $(document).ready(function() {
        $(document).on("click", ".register-btn", function() {
            let login = $("#login").val();
            let lastName = $("#last_name").val();
            let birthDate = $("#birth_date").val();
            let name = $("#name").val();
            let email = $("#email").val();
            let password = $("#password").val();
            let passwordConfirm = $("#password-confirm").val();
            if (login != "" && lastName != "" && name != "" && email != "" && password != "") {
                $.ajax({
                    type: "POST",
                    url: "/register",
                    data: {
                        login,
                        last_name: lastName,
                        birth_date: birthDate,
                        name,
                        email,
                        password,
                        password_confirmation: passwordConfirm,
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
                        const loginErrors = errorResponse.errors.login || [];
                        const last_nameErrors = errorResponse.errors.last_name || [];
                        const nameErrors = errorResponse.errors.name || [];
                        const allErrors = [...loginErrors, ...last_nameErrors, ...
                            nameErrors, ...emailErrors, ...passwordErrors
                        ];
                        showErrorModal(allErrors);
                    },
                });
            } else {
                showErrorModal("All fields are required");
            }
        });
    });
</script>
