<span class="stamp fontello">Said</span>

<article class="typo wrapper-padding wrapper-page">

    <?php if(is_array($comments) && !count($comments)) echo 'No comment founded!'; ?>

    <div id="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <?php $article = $comment->article()->find_one(); ?>
                <div class="typo-small">
                    <a href="/p/<?php echo $article->id; ?>"><?php echo $article->title; ?></a>
                    <small>@ <?php echo $comment->created_at; ?></small>
                </div>
                <div class="typo-small"><?php echo Helper\Html::fromMarkdown($comment->text); ?></div>
            </div>
        <?php endforeach;?>
    </div>
</article>

<?php echo $page; ?>