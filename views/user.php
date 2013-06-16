<?php
// 让 bio 里的链接可以点出去
function make_url($text) {
    // cc http://css-tricks.com/snippets/php/find-urls-in-text-make-links/
    $reg = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    return preg_match($reg, $text, $url) ?
        preg_replace($reg, "<a href='{$url[0]}' rel='nofollow'>{$url[0]}</a>", $text) : $text;
}
?>

<div class="typo wrapper-padding my">

    <?php if($user && $user->isUnVerified()): ?><span class="alert">Please verify your email!</span><?php endif; ?>

    <img class="avatar" src="<?php echo \Helper\Html::gravatar($author->email); ?>"/>
    <ul>
        <li>Username: <?php echo $author->name; ?></li>
        <li>Posts: <?php echo $author->articles()->count();?></li>
        <li>Comments: <?php echo $author->comments()->count();?></li>
        <li>Diggs: <?php echo $author->diggs()->count();?></li>
        <li>Created at: <small><?php echo $author->created_at;?></small></li>
        <li>Bio: <?php echo make_url($author->bio); ?></li>
    </ul>

    <?php if ($user && $user->id == $author->id): ?>
        <a class="btn" href="/account/edit">Edit Profile</a>
    <?php endif; ?>
</div>

