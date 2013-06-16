<article class="typo wrapper-padding" xmlns="http://www.w3.org/1999/html">
    <h2>Edit Profile:</h2>
    <?php if (isset($alert)): ?>
        <div class="alert"><?php echo $alert; ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <p><input type="text" autofocus name="name" value="<?php echo $user->name; ?>" disabled="disabled"/></p>

        <p>
            <input type="email" name="email" value="<?php echo $user->email; ?>" required="required"/>
            <span class="alert alert-info">Need re-active if change!</span>
        </p>

        <p><input type="password" name="password" placeholder="Password! (Leave empty if no change)"/></p>

        <p><input type="password" name="re_password" placeholder="Repeat Password!"/></p>
        <textarea name="bio" class="typo-p" placeholder="BIO [optional!]"><?php echo $user->bio; ?></textarea>

        <input class="btn" type="submit" value="Done!"/>
    </form>
</article>