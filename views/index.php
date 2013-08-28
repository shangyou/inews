<span class="stamp fontello">TOP</span>

<ul class="news typo">
  <?php if(isset($kw)) { ?>
    <li class="news-item news-item-cap"><strong>Search result for: <span class="highlight"><?php echo e($kw); ?></span></strong></li>
  <?php } ?>
<?php if ($articles): foreach ($articles as $item): ?>
    <?php $author = $item->author()->find_one(); ?>

    <li class="news-item up">
        <h4>
            <a href="<?php echo $item->link(); ?>" <?php echo !$item->content ? 'target="_blank"' : '' ?>>
              <?php echo !$item->content ? '<sup class="font font-export"></sup>' : '' ?><?php echo $item->title; ?>
            </a>
            <small class="up-content">
                <span class="btn-up font font-thumbs-up <?php echo $user && $item->isDiggBy($user->id) ? 'on' : '' ?>"
                      data-id="<?php echo $item->id ?>"
                      data-user="<?php echo $user ? $user->id : ''; ?>"></span>
                (<cite class="up-count"><?php echo $item->digg_count ?></cite>)
            </small>
        </h4>
        <small class="meta">
            <a href="/p/<?php echo $item->id; ?>/#respond">discuss (<?php echo $item->comments_count ?>)</a> /
            <a href="/u/<?php echo $author->id; ?>"><?php echo $author->name; ?></a> @ <?php echo $item->created_at; ?>
            <?php if($user && ($user->name == $author->name || $user->isAdmin())): ?>
                / <a class="highlight" href="/p/<?php echo $item->id ?>/destroy">delete</a>
                / <a class="highlight-ok" href="/p/<?php echo $item->id ?>/edit">edit</a>
            <?php endif; ?>
        </small>

        <?php if(false): ?>
        <div class="share">
            <a href="javascript:''" class="twitter">Twitter</a> |
            <a href="javascript:''" class="weibo">Weibo</a> |
            <a href="javascript:''" class="fav font font-heart"></a>
        </div>
        <?php endif; ?>

    </li>
<?php endforeach; else: ?>
    <li class="news-item">
        No contents found!
    </li>
<?php endif; ?>
</ul>

<?php if ($articles) echo $page; ?>