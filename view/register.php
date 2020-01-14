<?php include 'header.php'; ?>
<main>
    <h1>Register</h1>
    <form form action="." method="post">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-secondary" name="action" value="register">Register</button>
    </form>&nbsp;
    <form action="." method="post"><button type="submit" class="btn btn-secondary" value="Cancel">Cancel</button></form>
    
</main>
<?php include 'footer.php'; ?>