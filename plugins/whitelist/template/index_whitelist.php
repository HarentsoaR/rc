<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Blanche</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for styling */
        .container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333333;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<!-- Back Button -->
<a href="javascript:history.back()" class="btn btn-outline-primary mb-3">
    <i class="fas fa-arrow-left"></i> Retour
</a>
<!-- Session Message -->
<?php
if (!empty($_SESSION['blacklist_messages'])) {
    foreach ($_SESSION['blacklist_messages'] as $message) {
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
    $_SESSION['blacklist_messages'] = array();
}

//var_dump($_SESSION['matricule']);
?>


    <div class="container mt-5">

        <h1 class="text-center">Gestion de la liste blanche</h1>
        
        <!-- Whitelist Search Form -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="Matriculesearch" placeholder="Rechercher">
        </div>

        <!-- Whitelist Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Matricule</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch Whitelisted Matricules and their IDs
                $WhitelistedMatricules = $this->fetchWhitelistedMatricules();

                // Loop through the Whitelisted Matricules and create table rows
                foreach ($WhitelistedMatricules as $entry) {
                ?>
                <tr class="matricule-row">
                    <td><?php echo $entry['id']; ?></td>
                    <td><?php echo $entry['matricule']; ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="editmatricule('<?php echo $entry['id']; ?>', '<?php echo $entry['matricule']; ?>')"><i class="fa fa-pen"></i>Modifier</button>
                        <a href="?_task=whitelist&_action=remove&id=<?php echo $entry['id']; ?>" class="btn btn-danger" onclick="matriculeRemoved()"><i class="fa fa-trash"></i>Supprimer</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        
        <!-- Add Whitelist Form -->
        <div class="card mt-3">
            <div class="card-header">
                Ajouter un matricule dans la liste blanche
            </div>
            <div class="card-body">
                <form action="?_task=whitelist&_action=add" method="POST">
                    <div class="form-group">
                        <label for="matricule">Numéro matricule</label>
                        <input type="matricule" class="form-control" id="matricule" name="matricule" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus" onclick="matriculeAdded()"></i>Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modification</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="?_task=Whitelist&_action=edit" method="POST">
                <input type="hidden" id="editItemId" name="editItemId">
                <div class="form-group">
                    <label for="editmatricule">Nouveau matricule</label>
                    <input type="matricule" class="form-control" id="editmatricule" name="editmatricule">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary" id="saveEdit" onclick="matriculeUpdated()">Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>


    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        //RECHERCHE
        document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("Matriculesearch");
    var matriculeRows = document.querySelectorAll(".matricule-row");

    searchInput.addEventListener("input", function () {
        var searchTerm = this.value.toLowerCase();

        matriculeRows.forEach(function (row) {
            var rowContent = row.textContent.toLowerCase();

            if (rowContent.includes(searchTerm)) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });
});

/**
 * Editing Function
 * 
 * @param integer ID of the matricule to update
 * 
 * @param string matricule to update
 * 
 */
    function editmatricule(id, matricule) {
        // Set the current matricule and item ID in the modal
        document.getElementById("editmatricule").value = matricule;
        document.getElementById("editItemId").value = id;

        // Show the edit modal
        $('#editModal').modal('show');
    }
</script>

    
    
</body>
</html>
