<?php
// A function to create a 6 character account number
function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// A function to redirect a page to the desired place 
function redirect($url) {
    session_write_close();
    header("Location: " . $url);
    exit;
}

// Start the session to store information
session_start();

?>