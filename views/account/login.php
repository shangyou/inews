<article class="typo wrapper-padding">
    <h2>Signin:</h2>

    <form action="" method="POST">
        <p><input type="text" autofocus name="name" min="6" required="required" placeholder="User name/email"/></p>

        <p><input type="password" name="password" required="required" placeholder="Password"/></p>
        <input class="btn" type="submit" value="Signin"/>
        <small>don't have an account? <a href="/account/register" class="highlight">Get one &rarr;</a></small>
    </form>

    <?php if ($passport = config('passport')): ?>
        <p>
            Social Login:
            <?php if (isset($passport['weibo'])): ?>
                <a href="/login/weibo" class=""><i class="font font-sina-weibo"></i> Weibo</a>
            <?php endif; ?>
            <?php if (isset($passport['github'])): ?>
                <a href="/login/github" class=""><i class="font font-github"></i> Github</a>
            <?php endif; ?>
        </p>
    <?php endif; ?>
</article>