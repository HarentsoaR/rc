<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Noire</title>
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
            color: #000000;
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

    <div class="container mt-5">
        <h1 class="text-center">Gestion de la liste noire</h1>
        <!-- Search TextField -->
        <div class="mb-3">
            <input type="text" id="emailSearch" class="form-control" placeholder="Rechercher">
        </div>

        <!-- Blacklist Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Adresse e-mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch blacklisted emails and their IDs
                $blacklistedEmails = $this->fetchBlacklistedEmails();

                // Loop through the blacklisted emails and create table rows
                foreach ($blacklistedEmails as $entry) {
                ?>
                <tr class="email-row">
                    <td><?php echo $entry['id']; ?></td>
                    <td><?php echo $entry['email']; ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="editEmail('<?php echo $entry['id']; ?>', '<?php echo $entry['email']; ?>')"><i class="fa fa-pen"></i> Modifier</button>
                        <a href="?_task=blacklist&_action=remove&id=<?php echo $entry['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Supprimer</a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        
        <!-- Add Blacklist Form -->
        <div class="card mt-3">
            <div class="card-header">
                Ajouter un e-mail dans la liste noire
            </div>
            <div class="card-body">
                <form action="?_task=blacklist&_action=add" method="POST">
                    <div class="form-group">
                        <label for="email">Adresse e-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Edit Modal -->
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
                    <form action="?_task=blacklist&_action=edit" method="POST">
                        <input type="hidden" id="editItemId" name="editItemId">
                        <div class="form-group">
                            <label for="editEmail">Nouveau e-mail:</label>
                            <input type="email" class="form-control" id="editEmail" name="editEmail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="saveEdit">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


    <script>

        //Recherche
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

/**
 * Editing Function
 * 
 * @param integer ID of the email to update
 * 
 * @param string Email to update
 * 
 */
    fun
        function editEmail(id, email) {
            // Set the current email and item ID in the modal
            document.getElementById("editEmail").value = email;
            document.getElementById("editItemId").value = id;

            // Show the edit modal
            $('#editModal').modal('show');
        }

        
    </script>
</body>
</html>
