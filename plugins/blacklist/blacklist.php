<?php
class blacklist extends rcube_plugin
{
    function init()
    {
        // Register the plugin and load the configuration
        $this->add_hook('render_page', array($this, 'render_blacklist_page'));
        
        // Fetch blacklisted emails and store them
        $blacklistedEmails = $this->fetchBlacklistedEmails();

        // Check if the user's email is in the blacklist
        // Get the Roundcube instance
        $rcmail = rcube::get_instance();

         // Get the current user's email address
         $email = $rcmail->user->get_username();

         
        $blacklistedEmails = $this->fetchBlacklistedEmails();

        if (is_array($blacklistedEmails)) {
    foreach ($blacklistedEmails as $blacklistedEmail) {
        if ($email === $blacklistedEmail['email']) {
            // Disable the "SEND MESSAGE" section or take other actions as needed
            // You can use JavaScript to hide the section
            $args['content'] .= '<script>document.getElementById("rcmbtn100").style.display = "none";</script>';
            $args['content'] .= '<script>document.getElementById("rcmbtn103").style.display = "none";</script>';
            $args['content'] .= '<script>document.getElementById("blacklist_nav").style.display = "none";</script>';
            $args['content'] .= '<script>document.getElementById("whitelist_nav").style.display = "none";</script>';
            break; // Exit the loop if a match is found
        }
    }
}

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
            $blacklistItem = rcube_utils::get_input_value('email', rcube_utils::INPUT_POST);

            // Insert the blacklist item into the database table
            $this->insertBlacklistItem($blacklistItem);

            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
        }
        else if ($_GET['_task'] == 'blacklist' && $_GET['_action'] == 'edit') {
            // Handle the form submission for editing
            $editedItem['id'] = rcube_utils::get_input_value('editItemId', rcube_utils::INPUT_POST);
            $editedItem['email'] = rcube_utils::get_input_value('editEmail', rcube_utils::INPUT_POST);

            // Update the email address in the database
            $this->updateBlacklistItem($editedItem['id'], $editedItem['email']);

            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
        }
        else if ($_GET['_task'] == 'blacklist' && $_GET['_action'] == 'remove') {
            $id = rcube_utils::get_input_value('id', rcube_utils::INPUT_GET);
    
            // Remove the blacklisted item from the database
            $this->removeBlacklistItem($id);
    
            // Redirect back to the blacklist page
            header('Location: ?_page=blacklist');
            exit;
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
    $query = "INSERT INTO blacklist (email) VALUES (?)";
    
    // Execute the SQL query with the email item
    $db->query($query, $item);

    }
    /**
 * Fetch all blacklisted emails and their IDs from the database.
 *
 * @return array An array of blacklisted emails and their IDs
 */
public function fetchBlacklistedEmails()
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Fetch all blacklisted emails and their IDs from the 'blacklist' table
    $query = "SELECT id, email FROM blacklist";

    // Execute the SQL query
    $result = $db->query($query);

    // Initialize an empty array to store blacklisted emails and their IDs
    $blacklistedEmails = [];

    // Fetch and store each result row in the array
    while ($row = $db->fetch_assoc($result)) {
        $blacklistedEmails[] = $row;
    }

    return $blacklistedEmails;
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
 * Updating a blacklist email
 * 
 * @param integer ID of the email
 * @param string The email to update
 * 
 * @return string The updated email
 * 
 */
private function updateBlacklistItem($id, $newEmail)
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Perform the database update
    $query = "UPDATE blacklist SET email = ? WHERE id = ?";

    // Execute the SQL query with the new email and item ID
    $db->query($query, $newEmail, $id);
}

}