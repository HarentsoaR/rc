<?php
class email_historique extends rcube_plugin
{
    function init()
    {
     // Register the plugin and load the configuration
         $this->add_hook('render_page', array($this, 'render_email_history_page'));
    }

    /**
     * render_email_history_page
     * 
     * @param array $args
     * 
     * @return array $args
     */
    function render_email_history_page($args)
    {
        //Redirecting to the template
        if ($_GET['_page'] == 'history') {
            // Load your custom template
            $file_path = __DIR__ . '/template/index_email_historique.php';
            ob_start();


        // Include the script, making the variables available to it
        include($file_path);

        // Get the content of the buffer and clean the buffer
        $output = ob_get_clean();
           // Pass the data to the template
            $args['content'] = $output;
        }
        return $args;
    }
    /**
 * Fetch all emails blocked from the database.
 *
 * @return array An array of emails 
 */
public function fetchBlockedEmails()
{
    // Get the database connection
    $db = rcube::get_instance()->db;

    // Fetch all blacklisted emails and their IDs from the 'blacklist' table
    $query = "SELECT matricule, expediteur, destinataire, date, objet, status FROM email_historique";

    // Execute the SQL query
    $result = $db->query($query);

    // Initialize an empty array to store blacklisted emails and their IDs
    $blockedEmails = [];

    // Fetch and store each result row in the array
    while ($row = $db->fetch_assoc($result)) {
        $blockedEmails[] = $row;
    }
    return $blockedEmails;
}
/**
 * Function for the counting the emails valide and blocked
 * @param array $emailEntries array of the history
 * 
 * @param int count of the status
 */
function countBlockedEmails($emailEntries, $statusToCount) {
    $count = 0;

    foreach ($emailEntries as $entry) {
        if ($entry['status'] === $statusToCount) {
            $count++;
        }
    }

    return $count;
}

}