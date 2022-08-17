<?php settings_errors(); ?>
<div class="alebooking_content">
    <form id="form_time_zone" method="post" action="<?php echo plugin_dir_url(__DIR__) . 'rest-api/update.php'; ?>">

        <?php
        settings_fields('time_zone_settings');
        do_settings_sections('time_zone_settings');
        submit_button();
        ?>
    </form>
</div>