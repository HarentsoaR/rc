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
    </style>
</head>
<body>

<!-- Back Button -->
<a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
    <i class="fas fa-arrow-left"></i> Retour
</a>

<div class="container">
    <h1>Historique des E-mails Bloqués</h1>
    <div class="mb-3">
        <!-- Search TextField -->
    <div class="input-group">
        <select id="searchCriteria" class="form-select">
            <option value="expediteur">Expediteur</option>
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
                <th>#</th>
                <th>Expéditeur</th>
                <th>Destinataire</th>
                <th>Date</th>
                <th>Objet</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $blockedEmails = $this->fetchBlockedEmails();
            // Fetch email history data and populate the table
            foreach ($blockedEmails as $entry) {
            ?>
            <tr class="email-row">
                <td><?php echo $entry['id']; ?></td>
                <td><?php echo $entry['expediteur']; ?></td>
                <td><?php echo $entry['destinataire']; ?></td>
                <td><?php echo $entry['date']; ?></td>
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
</script>


</body>
</html>
