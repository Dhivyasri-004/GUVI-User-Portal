
$(document).ready(function () {

    // Prevent normal form submission
    $("#registerForm").on("submit", function (event) {
        event.preventDefault();
    });


    // Register button
    $("#registerBtn").click(function () {

        let name = $("#name").val().trim();
        let email = $("#email").val().trim();
        let password = $("#password").val();
        let confirmPassword = $("#confirmPassword").val();


        // Check empty fields
        if (
            name === "" ||
            email === "" ||
            password === "" ||
            confirmPassword === ""
        ) {
            showMessage(
                "Please fill in all fields.",
                "danger"
            );
            return;
        }


        // Check email format
        let emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            showMessage(
                "Please enter a valid email address.",
                "danger"
            );
            return;
        }


        // Check password length
        if (password.length < 6) {
            showMessage(
                "Password must contain at least 6 characters.",
                "danger"
            );
            return;
        }


        // Check password confirmation
        if (password !== confirmPassword) {
            showMessage(
                "Passwords do not match.",
                "danger"
            );
            return;
        }


        // Send data using jQuery AJAX
        $.ajax({

            url: "php/register.php",

            type: "POST",

            dataType: "json",

            data: {
                name: name,
                email: email,
                password: password
            },

            success: function (response) {

                if (response.success) {

                    showMessage(
                        response.message,
                        "success"
                    );

                    $("#registerForm")[0].reset();

                    setTimeout(function () {

                        window.location.href =
                            "login.html";

                    }, 1500);

                } else {

                    showMessage(
                        response.message,
                        "danger"
                    );
                }
            },

            error: function () {

                showMessage(
                    "Unable to connect to the server.",
                    "danger"
                );
            }
        });

    });


    // Display message
    function showMessage(message, type) {

        $("#message").html(
            '<div class="alert alert-' +
            type +
            '">' +
            message +
            "</div>"
        );
    }

});

