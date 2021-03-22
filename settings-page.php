<h1><?= __('Switcheroo Settings') ?></h1>
<form action="options.php" method="post">
    <?php
    settings_fields( 'switcheroo_settings' );
    do_settings_sections('switcheroo_settings');
    ?>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?= __('Save Changes') ?>"></p>
</form>