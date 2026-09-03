
$(document).ready(function () {

    // Prevent normal form submission
    $("#loginForm").on("submit", function (event) {
        event.preventDefault();
    });


    // Login button
    $("#loginBtn").click(function () {

        let email = $("#email").val().trim();
        let password = $("#password").val();


        // Check empty fields
        if (email === "" || password === "") {

            showMessage(
                "Please enter email and password.",
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


        // Send login data using jQuery AJAX
        $.ajax({

            url: "php/login.php",

            type: "POST",

            dataType: "json",

            data: {
                email: email,
                password: password
            },


            success: function (response) {

                if (response.success) {

                    // Store login token in browser LocalStorage
                    localStorage.setItem(
                        "loginToken",
                        response.token
                    );


                    showMessage(
                        response.message,
                        "success"
                    );


                    // Redirect to profile page
                    setTimeout(function () {

                        window.location.href =
                            "profile.html";

                    }, 1000);

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

