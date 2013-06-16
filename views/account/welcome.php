<div class="typo wrapper-padding">
    <?php if(isset($_GET['success'])) : ?>
        <div class="alert alert-info"><i class="font font-arrows-ccw"></i> Email sent!</div>
    <?php endif; ?>
    <p>A verify email has send to your mail!
    The mail is not lying in the inbox? Please try to find it in the spam box. Otherwise, you can: </p>
    <a class="btn" href="/account/resend?success=1">resend mail</a>
</div>