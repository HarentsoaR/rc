<?php 
class login_user extends rcube_plugin
{
    function init()
    {
        // Register the plugin and load the configuration
        // $this->add_hook('authenticate', array($this, 'custom_authenticate'));
        $this->add_hook('render_page', array($this, 'render_login_page'));
    }
    /**
     * Function for authentification
     * 
     * @param string Username
     * 
     * @param string Password
     * 
     * @return bool True or False
     */
    function custom_authenticate($username, $password)
{
    try {
        // Create a new PDO database connection
        $db = new PDO('pgsql:host=localhost;dbname=datamining;user=postgres;password=admin');
        
        // Set PDO to throw exceptions on errors
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query the "r_personnel" table to authenticate the user
        $query = "SELECT * FROM r_personnel WHERE matricule = ? AND mdp = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$username, $password]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // User authenticated successfully
            return true;
        } else {
            // Authentication failed
            return false;
        }
    } catch (PDOException $e) {
        // Handle any database connection errors here
        // You can log the error or take other appropriate actions
        error_log('Database connection error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Function render_login_page
 * 
 * @param array Args
 * 
 * @return array Args
 */
function render_login_page($args)
    {
        if ($_GET['_page'] == 'login') {
        // Load your custom template for the login page
        $file_path = __DIR__ . '/template/index_login.php';
        ob_start();

        // Include the script, making the variables available to it
        include($file_path);

        // Get the content of the buffer and clean the buffer
        $output = ob_get_clean();

        // Pass the data to the template
        $args['content'] = $output;
        }
        session_start();
                // Check if the user is accessing the login page
                if ($_GET['_task'] == 'custom_login' && $_GET['_action'] == 'custom_login') {
                    // Get the username and password from the form
                    $matricule = rcube_utils::get_input_value('matricule', rcube_utils::INPUT_POST);
                    $password = rcube_utils::get_input_value('password', rcube_utils::INPUT_POST);
                
                    // Call the custom_authenticate function to authenticate the user
                    $authenticated = $this->custom_authenticate($matricule, $password);
                
                    if ($authenticated) {
                        // User authenticated successfully
                        // Redirect to the main landing page or perform other actions
                        $email_password = $this->get_email_and_password_by_matricule($matricule);
                        $_SESSION['matricule'] = $matricule;
                        $test = $matricule;
                        echo var_dump($test);
                        if (count($email_password) === 1) {
                            // User found
                            $selectedEmail = $_POST['selected_email'];
                            $email_pwd = $this->get_email_and_password_by_email($selectedEmail);
                            $email = $email_pwd['email'];
                            $mdp = $email_pwd['password'];
                        } 
                        else if(count($email_password) >= 2)
                        {    
                            $selectedEmail2 = $_POST['selected_email'];
                            $email_pwd2 = $this->get_email_and_password_by_email($selectedEmail2);
                            $email = $email_pwd2['email'];
                            $mdp = $email_pwd2['password'];
                            // var_dump($email_pwd2);
                        }
                        // Check if the user is authenticated before calling the login_roundcube_mail_storage() function
                        if (!$this->login_roundcube_mail_storage($email, $mdp)) {
                            // Authentication failed in Roundcube
                            // Handle the error or redirect to an error page
                            $this->addMessage('<i class="fa fa-exclamation-circle"></i> Erreur, E-mail incorrect ', 'danger', 3000);
                            header('Location: ?_page=login');
                        } else {
                            // User is logged into the Roundcube mail storage
                            // You can now redirect the user to the desired Roundcube route
                            header('Location: ?_task=mail&_mbox=INBOX');
                        }
                    } else {
                        // Authentication failed, show an error message or handle it as needed
                        // For example, you can set an error message in the session and display it in the login template
                        $this->addMessage('<i class="fa fa-exclamation-circle"></i> Erreur, Matricule ou mot de passe incorrect', 'danger', 3000);
                        header('Location: ?_page=login');
                    }
                }
        return $args;
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
    if (!isset($_SESSION['login_messages'])) {
        $_SESSION['login_messages'] = array();
    }

    $_SESSION['login_messages'][] = array(
        'type' => $type,
        'message' => $message,
        'timeout' => $timeout,
    );
}
// This function should be part of your Roundcube plugin
function login_roundcube_mail_storage($email, $password) {
    // Initialize Roundcube application
    $rcmail = rcube::get_instance();

    // Check if the provided credentials are valid and log in
    if ($rcmail->login($email, $password)) {
        // User authenticated successfully in Roundcube

        // Get the Roundcube session ID
        $rcmail_sid = $rcmail->session->sid;

        // Generate a new random token
        $rcmail_token = bin2hex(random_bytes(16));

        // Set the Roundcube session cookie
        setcookie('roundcube_sid', $rcmail_sid, 0, '/');

        // Set the Roundcube token cookie
        setcookie('roundcube_sessauth', $rcmail_token, 0, '/');

        $rcmail->session->set_auth_cookie();

        // Return the Roundcube session ID and token
        return [
            'sid' => $rcmail_sid,
            'token' => $rcmail_token,
        ];
    } else {
        // Authentication failed in Roundcube
        return false;
    }
}
/**
 * Function for getting the email and password
 * 
 * @param string Matricule
 * 
 * @return boolean False
 * 
 * @return array If an email and password has found
 */
function get_email_and_password_by_matricule($matricule) {
    try {
        // Create a new PDO database connection
        $db = new PDO('pgsql:host=localhost;dbname=roundcubemail;user=postgres;password=admin');

        // Set PDO to throw exceptions on errors
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query the "eole_personnel" table to get all email-password pairs for the user with the specified matricule
        $query = "SELECT email, password FROM eole_personnel WHERE matricule = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$matricule]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // User found with multiple email-password pairs
            return $results;
        } else {
            // User not found
            return false;
        }   
    } catch (PDOException $e) {
        // Handle any database connection errors here
        // You can log the error or take other appropriate actions
        error_log('Database connection error: ' . $e->getMessage());
        return false;
    }
}
/**
 * Function for getting the email and password according to the email
 * 
 * @param string Email
 * 
 * @return boolean False
 * 
 * @return array If an email and password has found
 */
function get_email_and_password_by_email($email) {
    try {
        // Create a new PDO database connection
        $db = new PDO('pgsql:host=localhost;dbname=roundcubemail;user=postgres;password=admin');

        // Set PDO to throw exceptions on errors
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query the "eole_personnel" table to get all email-password pairs for the user with the specified matricule
        $query = "SELECT email, password FROM eole_personnel WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($results) {
            // User found with multiple email-password pairs
            return $results;
        } else {
            // User not found
            return false;
        }
    } catch (PDOException $e) {
        // Handle any database connection errors here
        // You can log the error or take other appropriate actions
        error_log('Database connection error: ' . $e->getMessage());
        return false;
    }
}
}