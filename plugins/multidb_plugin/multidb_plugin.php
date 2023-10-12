<?php
class multidb_plugin extends rcube_plugin
{
    function init()
    {
        // Register the plugin and load the configuration
        $this->add_hook('render_page', array($this, 'render_test_page'));

        // Add other hooks and initialization code as needed
    }

    function render_test_page($args)
{
    // Get the Roundcube instance
    $rcmail = rcube::get_instance();

    // Get the current user's email address
    $email = $rcmail->user->get_username();
    try {
        $db1 = rcube::get_instance()->config->get('second_db_dsnw');
        // Connect to the databases using PDO or your preferred method
        $pdo1 = new PDO($db1);
        if (!$pdo1) {
            // Database connection failed
            error_log('Database connection failed.');
        } else {
            // Database connection succeeded
            error_log('Database connection succeeded.');
            // Perform database operations as needed
        // Example: Fetch data from database 1
        $query = "SELECT nom, email FROM r_personnel LIMIT 5";
        $result1 = $pdo1->query($query);
        // Fetch and store the results in an array
        $data = $result1->fetchAll(PDO::FETCH_ASSOC);
        $matricule = $this->get_user_matricule('tojo@et.in');

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
            
        // echo var_dump($data);
            // Check if this is the testing page you want to display
        if ($_GET['_page'] == 'test_page') {
            // Load your custom template
            $file_path = __DIR__ . '/template/test_page.php';

        // Start output buffering to capture the output
        ob_start();

        // Include the script, making the variables available to it
        include($file_path);

        // Get the content of the buffer and clean the buffer
        $output = ob_get_clean();
           // Pass the data to the template
            $args['content'] = $output;
        }
        }
    } catch (PDOException $e) {
        // Handle database connection or query errors
        error_log('Database Error: ' . $e->getMessage());
        // Optionally, you can display an error message to the user
        // $args['content'] = 'Database Error: ' . $e->getMessage();
    }
    
    return $args;
}
 /**
     * Getter for matricule user .
     * 
     * @param string $email Email of the user
     * 
     * @return string Matricule user
     */
    public function get_user_matricule($email)
    {
        //DB instance
        $db = rcube::get_instance()->config->get('second_db_dsnw');
        $pdo = new PDO($db);
    
        // Prepare and execute a query to retrieve the matricule
        $query = "SELECT matricule FROM r_personnel WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result && isset($result['matricule'])) {
            return $result['matricule'];
        } else {
            return null; // Matricule not found for the given email
        }
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
    $query = "SELECT id, matricule FROM blacklist";

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
}
