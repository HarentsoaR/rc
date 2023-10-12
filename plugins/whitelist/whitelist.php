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
            $whitelistItem = rcube_utils::get_input_value('email', rcube_utils::INPUT_POST);

            // Insert the whitelist item into the database table
            $this->insertwhitelistItem($whitelistItem);

            // Redirect back to the whitelist page
            header('Location: ?_page=whitelist');
            exit;
        }
        else if ($_GET['_action'] == 'edit') {
            // Handle the form submission for editing
            $editedItem['id'] = rcube_utils::get_input_value('editItemId', rcube_utils::INPUT_POST);
            $editedItem['email'] = rcube_utils::get_input_value('editEmail', rcube_utils::INPUT_POST);

            // Update the email address in the database
            $this->updatewhitelistItem($editedItem['id'], $editedItem['email']);

            // Redirect back to the whitelist page
            header('Location: ?_page=whitelist');
            exit;
        }
        else if ($_GET['_action'] == 'remove') {
            $id = rcube_utils::get_input_value('id', rcube_utils::INPUT_GET);
    
            // Remove the whitelisted item from the database
            $this->removewhitelistItem($id);
    
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
    $query = "INSERT INTO whitelist (email) VALUES (?)";
    
    // Execute the SQL query with the email item
    $db->query($query, $item);

    }
    /**
 * Fetch all whitelisted emails and their IDs from the database.
 *
 * @return array An array of whitelisted emails and their IDs
 */
public function fetchWhiteListedEmails()
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Fetch all whitelisted emails and their IDs from the 'whitelist' table
    $query = "SELECT id, email FROM whitelist";

    // Execute the SQL query
    $result = $db->query($query);

    // Initialize an empty array to store whitelisted emails and their IDs
    $whitelistedEmails = [];

    // Fetch and store each result row in the array
    while ($row = $db->fetch_assoc($result)) {
        $whitelistedEmails[] = $row;
    }

    return $whitelistedEmails;
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
 * Updating a whitelist email
 * 
 * @param integer ID of the email
 * @param string The email to update
 * 
 * @return string The updated email
 * 
 */
private function updatewhitelistItem($id, $newEmail)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database update
    $query = "UPDATE whitelist SET email = ? WHERE id = ?";

    // Execute the SQL query with the new email and item ID
    $db->query($query, $newEmail, $id);
}

}