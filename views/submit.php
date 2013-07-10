<article class="typo wrapper-padding smt">
    <?php if($this->user->isUnVerified()): ?>
        <?php if($user->isUnVerified()): ?>Please check your email and follow the link to verify your account!<?php endif; ?>
    <?php else: ?>
        <?php $title = isset($article) && $article->title ? 'Edit the' : 'Share a'; ?>
        <h2><?php echo $title; ?> news:</h2>

        <?php // Edit
        if(isset($alert)): ?>
            <div class="alert"><?php echo $alert ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <p><input type="text" autofocus name="title" placeholder="Title" value="<?php echo isset($article) ? $article->title : ''; ?>" required="required"/></p>
            <p><input type="url" data-aorb="a" name="link" placeholder="URL" required="required" value="<?php echo isset($article) ? $article->link : ''; ?>"/> <cite>or</cite></p>
            <textarea name="content" class="typo-p" data-aorb="b" placeholder="Content" required="required"><?php echo isset($article) ? $article->content : ''; ?></textarea>
            <input type="submit" class="btn" value="Send it"/> <small><a href="http://wowubuntu.com/markdown/" target="_blank">Markdown syntax is supported</a></small>
        </form>
    <?php endif; ?>
</article>