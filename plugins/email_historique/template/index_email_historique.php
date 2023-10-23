<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    
    <!-- Add custom CSS for styling -->
    <style>
        .container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #FF0000;
        }
        .btn-back {
            margin-bottom: 20px;
        }
        .alert {
    display: inline-block;
        }
        .alert alert-danger{
            background-color: blue;
        }
        strong, h5{
            font-size: 22px; /* Adjust the font size as needed */
            font-family: "Tahoma", sans-serif; /* Replace with your preferred font-family */
            font-weight: lighter; 
        }
        .date-input-container {
    display: flex;
    justify-content: flex-end;
    margin: 10px;
}
    </style>
</head>
<body>

<!-- Back Button -->
<a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
    <i class="fas fa-arrow-left"></i> Retour
</a>

<div class="container">
    <h1>Historique des e-mails</h1>
    <div class="mb-3">
    <div class="alert alert-primary">
        <strong class="text-primary">Total des e-mails:</strong>
        <h5 class="text-primary"><?php echo count($this->fetchBlockedEmails()); ?></h5>
    </div>
    <div class="alert alert-success">
        <strong class="text-success">E-mail validé:</strong>
        <h5 class="text-success"><?php echo $this->countBlockedEmails($this->fetchBlockedEmails(), 'Validé'); ?></h5>
    </div>
    <div class="alert alert-danger">
        <strong class="text-danger">E-mail bloqué:</strong>
        <h5 class="text-danger"><?php echo $this->countBlockedEmails($this->fetchBlockedEmails(), 'Bloqué'); ?></h5>
    </div>
    <div class="row">
    <div class="date-input-container col-md-6">
        <input type="date" id="startDate" class="form-control" placeholder="Start Date">
        <input type="date" id="endDate" class="form-control" placeholder="End Date">
        <button type="button" class="btn btn-info" style="width:4em;height:2.5em;">
        <i class="fa fa-search"></i>
    </button>
    </div>
</div>
 
        <!-- Search TextField -->
    <div class="input-group">
        <select id="searchCriteria" class="form-select">
        <option value="expediteur">Matricule</option>
            <option value="expediteur">Expéditeur</option>
            <option value="destinataire">Destinataire</option>
            <option value="date">Date</option>
            <option value="objet">Objet</option>
        </select>
        <input type="text" id="emailSearch" class="form-control" placeholder="Rechercher">
    </div>
</div>




    <!-- Email History Table -->
    <table id="emailHistoryTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Matricule</th>
            <th>Expéditeur</th>
            <th>Destinataire</th>
            <th>Date</th>
            <th>Time</th> <!-- New column for time -->
            <th>Objet</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $blockedEmails = $this->fetchBlockedEmails();
        // Fetch email history data and populate the table
        foreach ($blockedEmails as $entry) {
            // Split the 'date' column into date and time
            $dateTime = explode(' ', $entry['date']);
            $date = $dateTime[0];
            $time = $dateTime[1];

            // Determine the background color class based on the status
            $rowColorClass = ($entry['status'] === 'Bloqué') ? 'table-danger' : 'table-info';
        ?>
        <tr class="email-row <?php echo $rowColorClass; ?>">
            <td><?php echo $entry['matricule']; ?></td>
            <td><?php echo $entry['expediteur']; ?></td>
            <td><?php echo $entry['destinataire']; ?></td>
            <td><?php echo $date; ?></td> <!-- Display the date -->
            <td><?php echo $time; ?></td> <!-- Display the time -->
            <td><?php echo $entry['objet']; ?></td>
            <td><?php echo $entry['status']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>

</div>

<!-- Include Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("emailSearch");
    var emailRows = document.querySelectorAll(".email-row");

    searchInput.addEventListener("input", function () {
        var searchTerm = this.value.toLowerCase();

        emailRows.forEach(function (row) {
            var rowContent = row.textContent.toLowerCase();

            if (rowContent.includes(searchTerm)) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });
});
document.querySelector('.btn-info').addEventListener('click', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    console.log(startDate);
    console.log(endDate);

    // Send a GET request to the PHP file
    $.ajax({
        type: 'GET',
        url: 'http://10.128.130.13:8181/rc/plugins/email_historique/template/api_date.php',
        data: { startDate: startDate, endDate: endDate },
        dataType: 'json',
        success: function(data) {
            // Update the table with the fetched data
            var table = document.getElementById('emailHistoryTable');
            table.innerHTML = ''; // Clear the table
            for (var i = 0; i < data.length; i++) {
                // Add a row to the table for each email
                var row = table.insertRow();
                // Add cells to the row for each email property
                row.insertCell().innerText = data[i]['matricule'];
                row.insertCell().innerText = data[i]['expediteur'];
                row.insertCell().innerText = data[i]['destinataire'];
                row.insertCell().innerText = data[i]['date'];
                row.insertCell().innerText = data[i]['time'];
                row.insertCell().innerText = data[i]['objet'];
                row.insertCell().innerText = data[i]['status'];
            }

            // Update the reporting with the fetched data
            document.querySelector('.alert-primary h5').innerText = data.length;
            document.querySelector('.alert-success h5').innerText = data.filter(function(email) { return email['status'] == 'Validé'; }).length;
            document.querySelector('.alert-danger h5').innerText = data.filter(function(email) { return email['status'] == 'Bloqué'; }).length;
            console.log("TEST");
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
</script>


</body>
</html>
