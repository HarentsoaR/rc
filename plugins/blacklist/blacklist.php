<?php
class blacklist extends rcube_plugin
{
    function init()
    {
        // Register the plugin and load the configuration
        $this->add_hook('render_page', array($this, 'render_blacklist_page'));

        // Add other hooks and initialization code as needed
    }
    /**
     * render_blacklist_page Function .
     * 
     * @param array $args
     * 
     * @return $args
     */
    function render_blacklist_page($args)
    {
        //Redirecting to the template 
        if ($_GET['_page'] == 'blacklist') {
            // Load your custom template
            $file_path = __DIR__ . '/template/index_blacklist.php';
            ob_start();


        // Include the script, making the variables available to it
        include($file_path);

        // Get the content of the buffer and clean the buffer
        $output = ob_get_clean();
           // Pass the data to the template
            $args['content'] = $output;
        }
        if ($_GET['_task'] == 'blacklist' && $_GET['_action'] == 'add') {
            $blacklistItem = rcube_utils::get_input_value('matricule', rcube_utils::INPUT_POST);

            // Insert the blacklist item into the database table
            $this->insertBlacklistItem($blacklistItem);

            // Add a success message with a 5-second (5000 milliseconds) timeout
            $this->addMessage('Matricule ajouté avec succès', 'success', 3000);

            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
        }
        else if ($_GET['_task'] == 'blacklist' && $_GET['_action'] == 'edit') {
            // Handle the form submission for editing
            $editedItem['id'] = rcube_utils::get_input_value('editItemId', rcube_utils::INPUT_POST);
            $editedItem['matricule'] = rcube_utils::get_input_value('editmatricule', rcube_utils::INPUT_POST);

            // Update the matricule address in the database
            $this->updateBlacklistItem($editedItem['id'], $editedItem['matricule']);

            // Add a success message with a 5-second (5000 milliseconds) timeout
            $this->addMessage('Matricule modifié avec succès', 'success', 3000);

            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
        }
        else if ($_GET['_task'] == 'blacklist' && $_GET['_action'] == 'remove') {
            $id = rcube_utils::get_input_value('id', rcube_utils::INPUT_GET);
    
            // Remove the blacklisted item from the database
            $this->removeBlacklistItem($id);

            // Add a success message with a 5-second (5000 milliseconds) timeout
            $this->addMessage('Matricule supprimé avec succès', 'danger', 3000);
    
            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
        }
                // Fetch blacklisted matricules and store them
                $blacklistedmatricules = $this->fetchBlacklistedmatricules();

  
                $matricule = $_SESSION['matricule'];
        
                
        
                $blacklistedmatricules = $this->fetchBlacklistedmatricules();
                //var_dump($blacklistedmatricules);
                if (is_array($blacklistedmatricules)) {
                    foreach ($blacklistedmatricules as $blacklistedmatricule) {
                        if ($matricule === $blacklistedmatricule['matricule']) {
                            //error_log('Inside the loop');
                            // Disable the "Rédiger" link by hiding it with JavaScript
                            $args['content'] .= '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("whitelist_nav").style.display = "none";
                                document.getElementById("blacklist_nav").style.display = "none";
                                document.getElementById("email_blocked").style.display = "none";
                                document.getElementById("rcmbtn103").style.display = "none";
                                document.getElementById("rcmbtn100").style.display = "none";
                                document.getElementById("rcmbtn105").style.display = "none";
                            });
                        </script>';
        //                 $args['content'] .= '<style>
        //     #whitelist_nav, #blacklist_nav, #email_blocked, #rcmbtn103, #rcmbtn100 {
        //         display: none !important;
        //     }
        // </style>';
                            break; // Exit the loop if a match is found
                        }
                    }
        }
        return $args;
    }
    
    /**
     * Insert a blacklist item into the database.
     *
     * @param string $item The item to blacklist
     */
    private function insertBlacklistItem($item)
    {
        // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database insert
    $query = "INSERT INTO blacklist (matricule) VALUES (?)";
    
    // Execute the SQL query with the matricule item
    $db->query($query, $item);

    }
    /**
 * Fetch all blacklisted matricules and their IDs from the database.
 *
 * @return array An array of blacklisted matricules and their IDs
 */
public function fetchBlacklistedmatricules()
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Fetch all blacklisted matricules and their IDs from the 'blacklist' table
    $query = "SELECT id, matricule FROM blacklist";

    // Execute the SQL query
    $result = $db->query($query);

    // Initialize an empty array to store blacklisted matricules and their IDs
    $blacklistedmatricules = [];

    // Fetch and store each result row in the array
    while ($row = $db->fetch_assoc($result)) {
        $blacklistedmatricules[] = $row;
    }

    return $blacklistedmatricules;
}

/**
 * Remove a blacklisted item from the database.
 *
 * @param int $id The ID of the item to remove
 */
private function removeBlacklistItem($id)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database delete
    $query = "DELETE FROM blacklist WHERE id = ?";
    
    // Execute the SQL query with the item ID
    $db->query($query, $id);
}
/**
 * Updating a blacklist matricule
 * 
 * @param integer ID of the matricule
 * @param string The matricule to update
 * 
 * @return string The updated matricule
 * 
 */
private function updateBlacklistItem($id, $newMatricule)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database update
    $query = "UPDATE blacklist SET matricule = ? WHERE id = ?";

    // Execute the SQL query with the new matricule and item ID
    $db->query($query, $newMatricule, $id);
}
/**
 * Function for the message add
 * 
 * @param string Message
 * 
 * @param string Type of the message
 * 
 * @param int Time of the message
 */
function addMessage($message, $type, $timeout = null)
{
    if (!isset($_SESSION['blacklist_messages'])) {
        $_SESSION['blacklist_messages'] = array();
    }

    $_SESSION['blacklist_messages'][] = array(
        'type' => $type,
        'message' => $message,
        'timeout' => $timeout,
    );
}



}