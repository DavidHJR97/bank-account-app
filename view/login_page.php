<?php include 'header.php'; ?>
<main>
    <h1>Home</h1>
    <form form action="." method="post">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-secondary" name="action" value="login">Login</button>
    </form><br>
    <form action="." method="post">
        <button type="submit" class="btn btn-secondary" name="action" value="view_register">Register</button>
    </form>
</main>
<?php include 'footer.php'; ?>