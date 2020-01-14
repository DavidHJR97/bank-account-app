<?php
function addCheckingAccount($customerID, $accountAmount, $accountWithdraw, $accountAdd, $accountNumber)
{
    global $db;
    $query = 'Insert into checkingaccount(customerID,accountAmount,accountWithdraw,accountAdd,accountNumber)
              Values(:customerID,:accountAmount,:accountWithdraw,:accountAdd,:accountNumber)';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':accountAmount', $accountAmount);
    $statement->bindValue(':accountWithdraw', $accountWithdraw);
    $statement->bindValue(':accountAdd', $accountAdd);
    $statement->bindValue(':accountNumber', $accountNumber);
    $statement->execute();
    $checkingAccountID = $db->lastInsertId();
    $statement->closeCursor();
    return $checkingAccountID;
}

function addSavingsAccount($customerID, $accountAmount, $accountWithdraw, $accountAdd, $accountNumber)
{
    global $db;
    $query = 'Insert into savingsAccount(customerID,accountAmount,accountWithdraw,accountAdd,accountNumber)
              Values(:customerID,:accountAmount,:accountWithdraw,:accountAdd,:accountNumber)';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':accountAmount', $accountAmount);
    $statement->bindValue(':accountWithdraw', $accountWithdraw);
    $statement->bindValue(':accountAdd', $accountAdd);
    $statement->bindValue(':accountNumber', $accountNumber);
    $statement->execute();
    $savingsAccountID = $db->lastInsertId();
    $statement->closeCursor();
    return $savingsAccountID;
}

function addCheckingTransaction($customerID, $checkingAccountID, $date, $description, $amount)
{
    global $db;
    $query = 'Insert into transactions(customerID,checkingAccountID, date, description, amount)
              Values(:customerID, :checkingAccountID, :date, :description, :amount)';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':checkingAccountID', $checkingAccountID);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':amount', $amount);
    $statement->execute();
    $transactionID = $db->lastInsertId();
    $statement->closeCursor();
    return $transactionID;
}

function addSavingTransaction($customerID, $savingsAccountID, $date, $description, $amount)
{
    global $db;
    $query = 'Insert into transactions(customerID,savingsAccountID, date, description, amount)
              Values(:customerID, :savingsAccountID, :date, :description, :amount)';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':savingsAccountID', $savingsAccountID);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':amount', $amount);
    $statement->execute();
    $transactionID = $db->lastInsertId();
    $statement->closeCursor();
    return $transactionID;
}

function getCheckingsAccount($id)
{
    global $db;
    $query = 'Select * from CheckingAccount where customerID = :id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function getSavingsAccount($id)
{
    global $db;
    $query = 'Select * from SavingsAccount where customerID = :id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function getCheckingAmount($checking_id, $customer_id)
{
    global $db;
    $query = 'Select AccountAmount 
              From CheckingAccount
              Where CheckingAccountID = :checking_id and CustomerID = :customer_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':checking_id', $checking_id);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->execute();
        $account = $statement->fetch();
        $amount = $account['AccountAmount'];
        $statement->closeCursor();
        return $amount;
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function getSavingsAmount($savings_id, $customer_id)
{
    global $db;
    $query = 'Select AccountAmount 
              From SavingsAccount
              Where SavingsAccountID = :savings_id and CustomerID = :customer_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':savings_id', $savings_id);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->execute();
        $account = $statement->fetch();
        $amount = $account['AccountAmount'];
        $statement->closeCursor();
        return $amount;
    } catch (PDOException $ex) {
        throw $ex;
    }
}


function getTransactions($id)
{
    global $db;
    $query = 'Select * from Transactions where customerID = :id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $transaction = $statement->fetchAll();
        $statement->closeCursor();
        return $transaction;
    } catch (PDOException $ex) {
        throw $ex;
    }
}

function updateCheckingAccountAmount($checking_id, $customer_id, $amount)
{
    global $db;
    $query = '
        Update checkingaccount
        Set AccountAmount = :amount
        Where CheckingAccountID = :checking_id And CustomerID = :customer_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':checking_id', $checking_id);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $ex) {
        throw  $ex;
    }
}

function updateSavingsAccountAmount($savings_id, $customer_id, $amount)
{
    global $db;
    $query = '
        Update savingsaccount
        Set AccountAmount = :amount
        Where SavingsAccountID = :savings_id And CustomerID = :customer_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':savings_id', $savings_id);
        $statement->bindValue(':customer_id', $customer_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $ex) {
        throw  $ex;
    }
}
