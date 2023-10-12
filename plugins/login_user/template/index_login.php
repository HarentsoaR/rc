<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebMail-Bienvenue</title>
        <!-- Include Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            width: 600px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-group button {
            background-color: #0073e6;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .login-logo {
            width: 300px;
            height: 200px;
            margin: 0 auto;
            display: block;
            object-fit: contain;
            object-position: center center;
        }       
        input::placeholder {
            text-align: center;
        }
        input[type="text"],
        input[type="password"],
        select.form-control {
        padding-left: 30px;
        position: relative;
        }
        input[type="text"]::before,
        input[type="password"]::before,
        select.form-control::before {
        content: "\f0e0";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translate(-50%, -50%);
        font-family: "Font Awesome 5 Free";
        font-size: 16px;
        color: #ccc;
        }
        .fa
        {
            color: #42a85a;
            margin-left: 10px;
        }
        .alert{
            font-family: Arial, sans-serif;
            font-size: 0.8rem;
            display: block;
        }
        .input-group{
            margin-left: 15px;
            width: 545px;
        }
    </style>
</head>
<body>
    <div class="login-container">
    <img src="skins\elastic\images\beys.png" alt="Logo" class="login-logo">
         <!-- Session Message -->
<?php
if (!empty($_SESSION['login_messages'])) {
    foreach ($_SESSION['login_messages'] as $message) {
        $messageType = $message['type'];
        $messageText = $message['message'];
        $timeout = $message['timeout'];

        echo '<div class="alert alert-' . $messageType . '">' . $messageText . '</div>';

        // Check if a timeout is defined, and add JavaScript to remove the message after the specified time
        if ($timeout) {
            echo '<script>setTimeout(function() { $(".alert").fadeOut(); }, ' . $timeout . ');</script>';
        }
    }
    // Clear the messages after displaying them
    $_SESSION['login_messages'] = array();
}
?>

        <form action="?_task=custom_login&_action=custom_login" method="POST">
            <div class="form-group">
                <input type="text" id="matricule" name="matricule" placeholder="Numero matricule" required><i class="fa fa-user"></i>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Mot de passe" required><i class="fa fa-lock"></i>
            </div>
            <div class="form-group">
    <div class="input-group">
        <select name="email" id="email" class="form-control">
            <option value="">Aucune e-mail</option>
        </select>
               <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
    </div>
</div>

            <div class="form-group">
                <button type="submit" id="submit_btn" style="width: 350px;">Se connecter</button>
            </div>
        </form>
    </div>
</body>
    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    // Get a reference to the <select> element
    var emailSelect = $('#email');
    var form = $('form');

// Listen for the form's submit event
form.on('submit', function (event) {
    // Get the selected email value
    var selectedEmail = emailSelect.val();

    // Add the selected email as a hidden input field to the form
    form.append($('<input>').attr({
        type: 'hidden',
        name: 'selected_email',
        value: selectedEmail
    }));
   
});

// emailSelect.on('change', function () {
//                 // Get the selected email value
//                 var selectedEmail = emailSelect.val();

//                 // Log the selected email to the console
//                 console.log('Selected Email:', selectedEmail);
//             });
    // Reference to the matricule input field
    var matriculeInput = $('#matricule');

    // Listen for keyup events in the matricule input field
    matriculeInput.on('keyup', function () {
        // Get the value of the matricule input field
        var matricule = matriculeInput.val();

        // Make an AJAX request to fetch email data
        $.ajax({
            type: 'POST',
            url: 'http://10.128.130.13:8181/rc/plugins/login_user/template/get_emails.php', // URL of your PHP script
            data: { matricule: matricule }, // Pass the matricule value as a parameter
            dataType: 'json',
            success: function (data) {
                // Clear existing options
                emailSelect.empty();
                // Populate the <select> with retrieved data
                data.forEach(function (entry) {
                    emailSelect.append($('<option>').val(entry.email).text(entry.email));
                });
                console.log(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});
    </script>
</html>