<?php
class whitelist extends rcube_plugin
{
    function init()
    {
        // Register the plugin and load the configuration
        $this->add_hook('render_page', array($this, 'render_whitelist_page'));

        // Add other hooks and initialization code as needed
    }
    /**
     * render_whitelist_page Function .
     * @param array $args
     * @return $args
     */
    function render_whitelist_page($args)
    {
        //Redirecting to the template 
        if ($_GET['_page'] == 'whitelist') {
            // Load your custom template
            $file_path = __DIR__ . '/template/index_whitelist.php';
            ob_start();

        // Include the script, making the variables available to it
        include($file_path);

        // Get the content of the buffer and clean the buffer
        $output = ob_get_clean();
           // Pass the data to the template
            $args['content'] = $output;
        }
        if ($_GET['_task'] == 'whitelist' && $_GET['_action'] == 'add') {
            $whitelistItem = rcube_utils::get_input_value('matricule', rcube_utils::INPUT_POST);

            // Insert the whitelist item into the database table
            $this->insertwhitelistItem($whitelistItem);

            // Add a success message with a 5-second (5000 milliseconds) timeout
            $this->addMessage('Matricule ajouté avec succès', 'success', 3000);
            
            // Redirect back to the whitelist page
            header('Location: ?_page=whitelist');
            exit;
        }
        else if ($_GET['_action'] == 'edit') {
            // Handle the form submission for editing
            $editedItem['id'] = rcube_utils::get_input_value('editItemId', rcube_utils::INPUT_POST);
            $editedItem['matricule'] = rcube_utils::get_input_value('editmatricule', rcube_utils::INPUT_POST);

            // Update the matricule address in the database
            $this->updatewhitelistItem($editedItem['id'], $editedItem['matricule']);
         // Add a success message with a 5-second (5000 milliseconds) timeout
         $this->addMessage('Matricule modifié avec succès', 'success', 3000);
            // Redirect back to the whitelist page
            header('Location: ?_page=whitelist');
            exit;
        }
        else if ($_GET['_action'] == 'remove') {
            $id = rcube_utils::get_input_value('id', rcube_utils::INPUT_GET);
    
            // Remove the whitelisted item from the database
            $this->removewhitelistItem($id);
    
            // Add a success message with a 5-second (5000 milliseconds) timeout
            $this->addMessage('Matricule supprimé avec succès', 'danger', 3000);

            // Redirect back to the whitelist page
            header('Location: ?_page=whitelist');
            exit;
        }
        return $args;
    }
    
    /**
     * Insert a whitelist item into the database.
     *
     * @param string $item The item to whitelist
     */
    private function insertwhitelistItem($item)
    {
        // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database insert
    $query = "INSERT INTO whitelist (matricule) VALUES (?)";
    
    // Execute the SQL query with the matricule item
    $db->query($query, $item);

    }
    /**
 * Fetch all whitelisted matricules and their IDs from the database.
 *
 * @return array An array of whitelisted matricules and their IDs
 */
public function fetchWhiteListedmatricules()
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Fetch all whitelisted matricules and their IDs from the 'whitelist' table
    $query = "SELECT id, matricule FROM whitelist";

    // Execute the SQL query
    $result = $db->query($query);

    // Initialize an empty array to store whitelisted matricules and their IDs
    $whitelistedmatricules = [];

    // Fetch and store each result row in the array
    while ($row = $db->fetch_assoc($result)) {
        $whitelistedmatricules[] = $row;
    }

    return $whitelistedmatricules;
}

/**
 * Remove a whitelisted item from the database.
 *
 * @param int $id The ID of the item to remove
 */
private function removewhitelistItem($id)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database delete
    $query = "DELETE FROM whitelist WHERE id = ?";
    
    // Execute the SQL query with the item ID
    $db->query($query, $id);
}
/**
 * Updating a whitelist matricule
 * 
 * @param integer ID of the matricule
 * @param string The matricule to update
 * 
 * @return string The updated matricule
 * 
 */
private function updatewhitelistItem($id, $newmatricule)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database update
    $query = "UPDATE whitelist SET matricule = ? WHERE id = ?";

    // Execute the SQL query with the new matricule and item ID
    $db->query($query, $newmatricule, $id);
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