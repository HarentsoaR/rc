<?php
class custom_auth
{
    function authenticate($user, $pass)
    {
        // Your custom authentication logic here
        // Return true if authentication is successful, false otherwise
        // You may validate the "matricule" and "mdp" against your user database
        
        if ($user === 'example_matricule' && $pass === 'example_password') {
            return true; // Authentication successful
        } else {
            return false; // Authentication failed
        }
    }
}
