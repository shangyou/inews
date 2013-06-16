<?php

$embed = \Helper\Url::parseEmbed($article->link);

if (!$embed) return;

?>
<div class="typo-p"><?php echo $embed['html']; ?></div>
