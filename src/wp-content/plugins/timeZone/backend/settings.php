<?php settings_errors(); ?>
<div class="alebooking_content">
    <form id="form_time_zone" method="post" action="<?php echo '/wp-content/plugins/timeZone/rest-api/main.php'?>">

        <?php
        settings_fields('booking_settings');
        do_settings_sections('time_zone_settings');
        submit_button();
        ?>
    </form>
</div>