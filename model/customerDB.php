<?php 
include('database.php');

/*
 * Function to validate if the email that was 
 * enterted to register is in the database already
 */
function isValidCustomerEmail($email){
    global $db;
    $query = 'Select CustomerID From Customers 
              Where EmailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
}

// Function to get the email and password from database to verify login 
function isValidCustomerLogin($email, $password) {
    global $db;
    $password = sha1($email . $password);
    $query = '
        Select * From customers
        Where emailAddress = :email And password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
}

// Function to add the user to the database 
function addCustomer($firstName, $lastName, $email, $password_1){
    global $db;
    $password = sha1($email . $password_1);
    $query = '
            Insert into customers (firstName, lastName, emailAddress, password)
            Values (:firstName, :lastName, :email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $customerID = $db->lastInsertId();
    $statement->closeCursor();
    return $customerID;
}

// function to get the users info by email 
function getCustomerByEmail($email) {
    global $db;
    $query = 'Select * from customers where emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $customer = $statement->fetch();
    $statement->closeCursor();
    return $customer;
}
?>

