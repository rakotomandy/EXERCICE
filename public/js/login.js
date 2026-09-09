$(document).ready(function() {
    $(window).on("pageshow", function(event) {
        if (event.originalEvent.persisted) {
            // Page was loaded from the browser cache (back button used)
            window.location.reload();
        }
    });

    // Handle login form submission
    $("#login").submit(function(e) {
        e.preventDefault();
        const email = $("#email").val();
        const password = $("#password").val();
        $.ajax({
            url: "Login/login",
            type: "POST",
            data: {
                email: email,
                password: password,
            },
            dataType: "json",
        }).done(function(data) {
            if (data.success) {
                window.location.href = "Home";
            } else {
                alert(data.message);
            }
        });
    });
});

// Handle signup form submission
$("#signup").submit(function(e) {
    e.preventDefault();
    const username = $("#username").val();
    const email = $("#email").val();
    const password = $("#password").val();
    const password_confirm = $("#password_confirm").val();
    $.ajax({
            url: "Signup/signup",
            type: "POST",
            data: {
                username: username,
                email: email,
                password: password,
                password_confirm: password_confirm,
            },
            dataType: "json",
        })
        .done(function(data) {
            if (data.success) {
                window.location.href = "Login";
            } else {
                alert(data.message);
            }
        })
        .fail(function() {
            alert("An error occurred while processing your request.");
        });

    $("#logout").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "Login/logout",
            type: "POST",
            dataType: "json"
        }).done(function(data) {
            if (data.success) {
                window.location.href = "login"
            }
        }).fail(function() {
            alert("An error occured")
        })
    })
});