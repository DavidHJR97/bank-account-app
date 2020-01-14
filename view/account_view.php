<?php include 'header.php'; ?>
<?php
$customer_id = $_SESSION['user']['CustomerID'];
$checking_id = $_SESSION['checkingAccount']['CheckingAccountID'];
$savings_id = $_SESSION['savingsAccount']['SavingsAccountID'];
$firstName = $_SESSION['user']['FirstName'];
$lastName = $_SESSION['user']['LastName'];
$email = $_SESSION['user']['EmailAddress'];
$checkingAccountAmount = (float) getCheckingAmount($checking_id, $customer_id);
$savingsAccountAmount = (float) getSavingsAmount($savings_id, $customer_id);
$transactions = getTransactions($customer_id);
?>
<main>
    <div id="accountInfo">
        <div id="customerInfo">
            <h1 class="h1Border">Account Information</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Checking Account</th>
                        <th scope="col">Savings Account</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $firstName; ?></td>
                        <td><?php echo $lastName; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo '$' . number_format($checkingAccountAmount, 2); ?></td>
                        <td><?php echo '$' . number_format($savingsAccountAmount, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="transactions">
            <h1 class="h1Border">Recent Transactions</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Transaction Description</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <?php foreach ($transactions as $transaction) {
                    $date = $transaction['Date'];
                    $date = date('Y-m-d', strtotime($date));
                    $description = $transaction['Description'];
                    $amount = $transaction['Amount'];
                    echo
                        "
                            <tr>
                                <td>$date</td>
                                <td>$description</td>
                                <td>" . '$' . number_format($amount, 2) . "</td>
                            </tr>
                        ";
                }
                ?>
            </table>
        </div>
    </div>
    <h1 class="h1Border">ATM:</h1>
    <div id="atm">
        <div id="checking">
            <h3>Deposit or Withdraw for Checking Account</h3>
            <form action="." method="post">
                <div class="form-group row">
                    <label for="checkingDeposit" class="col-sm-3 col-form-label">Deposit</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="checkingDeposit" name="checkingDeposit">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="checkingWithdraw" class="col-sm-3 col-form-label">Withdraw</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="checkingWithdraw" name="checkingWithdraw">
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary" name="action" value="btnChecking">Submit</button>
            </form>
        </div>
        <div id="savings">
            <h3>Deposit or Withdraw for Savings Account</h3>
            <form action="." method="post">
                <div class="form-group row">
                    <label for="savingsDeposit" class="col-sm-3 col-form-label">Deposit</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="savingsDeposit" name="savingsDeposit">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="savingsWithdraw" class="col-sm-3 col-form-label">Withdraw</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="savingsWithdraw" name="savingsWithdraw">
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary" name="action" value="btnSavings">Submit</button>

            </form>
        </div>
    </div>
    <br />
    <h3>Logout</h3>
    <form action="." method="post">
        <button type="submit" class="btn btn-secondary" name="action" value="logout">Logout</button>
    </form>
</main>
<?php include 'footer.php'; ?>