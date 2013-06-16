<span class="stamp fontello">Diggs</span>

<?php if(is_array($articles) && !count($articles)) : ?>
    <div class="typo wrapper wrapper-padding">
        <?php echo 'No diggs founded!'; ?>
    </div>
<?php endif; ?>

<ul class="news typo">

    <?php foreach ($articles as $item): ?>
        <?php $author = $item->author()->find_one(); ?>
        <?php // var_dump($item) ?>

        <li class="news-item up">
            <h4>
                <a href="<?php echo $item->link(); ?>"><?php echo $item->title; ?></a>
                <small class="up-content">
                <span class="btn-up fontello <?php echo $user && $item->isDiggBy($user->id) ? 'on' : '' ?>"
                      data-id="<?php echo $item->id ?>"
                      data-user="<?php echo $user ? $user->id : ''; ?>"></span>
                    (<cite class="up-count"><?php echo $item->digg_count ?></cite>)
                </small>
            </h4>
            <small class="meta">
                <a href="/p/<?php echo $item->id; ?>/#respond">discuss (<?php echo $item->comments_count ?>)</a> /
                <?php echo $author ? $author->name : ''; ?> @ <?php echo $item->created_at; ?>
            </small>

        </li>
    <?php endforeach; ?>
</ul>

<?php echo $page ?>