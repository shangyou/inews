<span class="stamp fontello">TOP</span>

<ul class="leaders clearfix typo wrapper-padding">
<?php if ($leaders): foreach ($leaders as $leader): ?>
    <li class="leader">
        <div class="identical">
            <img class="avatar" src="<?php echo \Helper\Html::gravatar($leader->email, 30); ?>" />
            <a href="/u/<?php echo $leader->id; ?>"><?php echo $leader->name ?></a>
            <small><?php echo $leader->posts_count; ?> posts / <?php echo $leader->digged_count; ?> points</small>
        </div>
    </li>
<?php endforeach; else: ?>
    There is no leaders
<?php endif; ?>
</ul>