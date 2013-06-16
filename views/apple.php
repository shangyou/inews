<style type="text/css">
    .thumb-custom img {width: 16px; height: 10px;}
</style>
<!-- BEGIN Timeline Embed -->
<div id="timeline-embed" class="clearfix">
</div>
<div style="text-align: center; font-size: 10px!important; padding: 10px 0;color:#ddd;">
    <a href="/timeline"<?php if (empty($_GET['type'])): ?> style="color: grey<?php endif; ?>">All</a>
    <?php foreach ($tags as $tag): ?>
        | <a href="?type=<?php echo urlencode($tag); ?>"<?php if (!empty($_GET['type']) && $_GET['type'] == $tag): ?> style="color: grey"<?php endif; ?>><?php echo $tag;?></a>
    <?php endforeach; ?>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    var timeline_config = {
        width: "930",
        height: "600",
        start_at_end: true,
        start_zoom_adjust: 1,
        source: <?php echo json_encode($timeline); ?>,
        embed_id: 'timeline-embed'
    }
</script>
<script type="text/javascript" src="/static/timeline/js/storyjs-embed.js"></script>
