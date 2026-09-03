
$(document).ready(function () {

    // Get login token from localStorage
    let token = localStorage.getItem("loginToken");

    // If no token, go back to login
    if (!token) {
        window.location.href = "login.html";
        return;
    }

    // Load profile when page opens
    loadProfile();


    // Update profile
    $("#updateBtn").click(function () {

        let age = $("#age").val().trim();
        let dob = $("#dob").val();
        let contact = $("#contact").val().trim();
        let city = $("#city").val().trim();
        let address = $("#address").val().trim();


        // Check required fields
        if (
            age === "" ||
            dob === "" ||
            contact === ""
        ) {
            showMessage(
                "Please fill in age, date of birth and contact number.",
                "danger"
            );
            return;
        }


        // Validate age
        let ageNumber = Number(age);

        if (
            !Number.isInteger(ageNumber) ||
            ageNumber < 1 ||
            ageNumber > 120
        ) {
            showMessage(
                "Please enter a valid age between 1 and 120.",
                "danger"
            );
            return;
        }


        // Validate contact number
        let contactPattern = /^[0-9]{10}$/;

        if (!contactPattern.test(contact)) {
            showMessage(
                "Contact number must contain exactly 10 digits.",
                "danger"
            );
            return;
        }


        // Validate date of birth
        let selectedDate = new Date(dob);
        let today = new Date();

        today.setHours(0, 0, 0, 0);

        if (
            isNaN(selectedDate.getTime()) ||
            selectedDate > today
        ) {
            showMessage(
                "Please enter a valid date of birth.",
                "danger"
            );
            return;
        }


        // Send profile data using jQuery AJAX
        $.ajax({
            url: "php/profile.php",
            type: "POST",
            dataType: "json",

            data: {
                action: "update",
                token: token,
                age: age,
                dob: dob,
                contact: contact,
                city: city,
                address: address
            },

            success: function (response) {

                if (response.success) {

                    showMessage(
                        response.message,
                        "success"
                    );

                } else {

                    showMessage(
                        response.message,
                        "danger"
                    );

                    // Invalid or expired token
                    if (response.logout) {

                        localStorage.removeItem(
                            "loginToken"
                        );

                        window.location.href =
                            "login.html";
                    }
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


    // Logout
    $("#logoutBtn").click(function () {

        $.ajax({
            url: "php/logout.php",
            type: "POST",
            dataType: "json",

            data: {
                token: token
            },

            complete: function () {

                // Remove login token from browser
                localStorage.removeItem(
                    "loginToken"
                );

                // Redirect to login
                window.location.href =
                    "login.html";
            }
        });
    });


    // Load profile details
    function loadProfile() {

        $.ajax({
            url: "php/profile.php",
            type: "POST",
            dataType: "json",

            data: {
                action: "get",
                token: token
            },

            success: function (response) {

                if (response.success) {

                    let profile =
                        response.profile;

                    $("#name").val(
                        profile.name || ""
                    );

                    $("#email").val(
                        profile.email || ""
                    );

                    $("#age").val(
                        profile.age || ""
                    );

                    $("#dob").val(
                        profile.dob || ""
                    );

                    $("#contact").val(
                        profile.contact || ""
                    );

                    $("#city").val(
                        profile.city || ""
                    );

                    $("#address").val(
                        profile.address || ""
                    );

                } else {

                    showMessage(
                        response.message,
                        "danger"
                    );

                    // Invalid or expired token
                    if (response.logout) {

                        localStorage.removeItem(
                            "loginToken"
                        );

                        setTimeout(function () {

                            window.location.href =
                                "login.html";

                        }, 1000);
                    }
                }
            },

            error: function () {

                showMessage(
                    "Unable to load profile.",
                    "danger"
                );
            }
        });
    }


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

