jQuery( document ).ready(function() {
    jQuery('#submit').on('click', function(event) {
        event.preventDefault();


        var form = jQuery("#form_time_zone");
        var actionUrl = form.attr('action');

        var timeZoneSelected = jQuery('#zone').find(":selected").text();

        jQuery.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function(data)
            {
                let chicago_datetime_str = new Date().toLocaleString("en-US", { timeZone: timeZoneSelected });
                console.log(chicago_datetime_str);
                jQuery("#TZ").text(timeZoneSelected)
                jQuery("#time").text(chicago_datetime_str)
            }
        });


    });
});