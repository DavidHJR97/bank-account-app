<?php
require_once('model/helper.php');
require_once('model/customerDB.php');
require_once('model/accountsDB.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'view_login';
        if (isset($_SESSION['user'])) {
            $action = 'login';
        }
    }
}

switch ($action) {
    case 'view_login':
        include 'view/login_page.php';
        break;
    case 'view_register':
        include 'view/register.php';
        break;
    case 'login':
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        // Check email and password in database
        if (isValidCustomerLogin($email, $password)) {
            $_SESSION['user'] = getCustomerByEmail($email);
            $customerID = $_SESSION['user']['CustomerID'];
            $_SESSION['checkingAccount'] = getCheckingsAccount($customerID);
            $_SESSION['savingsAccount'] = getSavingsAccount($customerID);
            include 'view/account_view.php';
        } else {
            include 'view/login_page.php';
        }
        break;
    case 'logout':
        unset($_SESSION['user']);
        unset($_SESSION['checkingAccount']);
        unset($_SESSION['savingsAccount']);
        include 'view/login_page.php';
        break;
    case 'register':
        // Store user data in local variables
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $firstName = filter_input(INPUT_POST, 'firstName');
        $lastName = filter_input(INPUT_POST, 'lastName');

        if ($email == '' || $password == '' || $firstName == '' || $lastName == '') {
            include("view/register.php");
        } else if (!isValidCustomerEmail($email)) {
            // Add the customer data to the database
            $customer_id = addCustomer($firstName, $lastName, $email, $password);
            $checkingAccountNumber = generateRandomString();
            $savingsAccountNumber = generateRandomString();
            $amount = 0.00;
            $checkingAccount_id = addCheckingAccount($customer_id, $amount, $amount, $amount, $checkingAccountNumber);
            $savingsAccount_id =  addSavingsAccount($customer_id, $amount, $amount, $amount, $savingsAccountNumber);
            $checkingAccountAmount = (float) getCheckingAmount($checkingAccount_id, $customer_id);
            $savingsAccountAmount = (float) getSavingsAmount($savingsAccount_id, $customer_id);
            $transactions = getTransactions($customer_id);
            include 'view/login_page.php';
        }
        break;
    case 'btnChecking':
        $deposit = filter_input(INPUT_POST, 'checkingDeposit');
        $withdraw = filter_input(INPUT_POST, 'checkingWithdraw');
        $customer_id = (int) $_SESSION['user']['CustomerID'];
        $checkingAccount_id = (int) $_SESSION['checkingAccount']['CheckingAccountID'];
        $savingsAccount_id = (int) $_SESSION['savingsAccount']['SavingsAccountID'];
        $firstName = $_SESSION['user']['FirstName'];
        $lastName = $_SESSION['user']['LastName'];
        $email = $_SESSION['user']['EmailAddress'];
        $checkingAccountAmount = (float) getCheckingAmount($checkingAccount_id, $customer_id);
        $savingsAccountAmount = (float) getSavingsAmount($savingsAccount_id, $customer_id);

        if ($deposit != '' && $deposit > 0) {
            $newAmount = $deposit + $checkingAccountAmount;
            updateCheckingAccountAmount($checkingAccount_id, $customer_id, $newAmount);
            addCheckingTransaction($customer_id, $checkingAccount_id, date("Y/m/d"), 'Checking deposit', $deposit);
            redirect('.');
            break;
        } else if ($withdraw != '' && is_numeric($withdraw)) {
            $newAmount = $checkingAccountAmount - $withdraw;
            updateCheckingAccountAmount($checkingAccount_id, $customer_id, $newAmount);
            addCheckingTransaction($customer_id, $checkingAccount_id, date("Y/m/d"), 'Checking withdraw', $withdraw);
            redirect('.');
            break;
        }

    case 'btnSavings':
        $deposit = filter_input(INPUT_POST, 'savingsDeposit');
        $withdraw = filter_input(INPUT_POST, 'savingsWithdraw');
        $customer_id = (int) $_SESSION['user']['CustomerID'];
        $checkingAccount_id = (int) $_SESSION['checkingAccount']['CheckingAccountID'];
        $savingsAccount_id = (int) $_SESSION['savingsAccount']['SavingsAccountID'];
        $firstName = $_SESSION['user']['FirstName'];
        $lastName = $_SESSION['user']['LastName'];
        $email = $_SESSION['user']['EmailAddress'];
        $checkingAccountAmount = (float) getCheckingAmount($checkingAccount_id, $customer_id);
        $savingsAccountAmount = (float) getSavingsAmount($savingsAccount_id, $customer_id);
        print($deposit);
        if ($deposit != '' && $deposit > 0) {
            print('I am deposit in checing accont');
            $newAmount = $deposit + $savingsAccountAmount;
            updateSavingsAccountAmount($savingsAccount_id, $customer_id, $newAmount);
            addSavingTransaction($customer_id, $savingsAccount_id, date("Y/m/d"), 'Savings deposit', $deposit);
            redirect('.');
            break;
        } else if ($withdraw != '' && is_numeric($withdraw)) {
            $newAmount = $savingsAccountAmount - $withdraw;
            updateSavingsAccountAmount($savingsAccount_id, $customer_id, $newAmount);
            addCheckingTransaction($customer_id, $savingsAccount_id, date("Y/m/d"), 'Savings withdraw', $withdraw);
            redirect('.');
            break;
        }
    default:
        include 'view/login_page.php';
        break;
}
