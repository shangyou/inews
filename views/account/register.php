<article class="typo wrapper-padding" xmlns="http://www.w3.org/1999/html">
    <h2>Signup as a user:</h2>
    <?php if(isset($alert)): ?>
        <div class="alert"><?php echo $alert; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <p><input type="text" autofocus name="name" placeholder="User name ( 6-20 characters )" required="required" /></p>
        <p><input type="email" name="email" placeholder="Email" required="required"/></p>
        <p><input type="password" name="password" placeholder="Password" required="required"/></p>
        <textarea name="bio" class="typo-p" placeholder="[Optional] bio"></textarea>
        <input class="btn" type="submit" value="Register" />
    </form>
 </article>