jQuery( document ).ready(function() {

    function getSelectedElement(){
        return jQuery('#zone').find(":selected").text()
    }
        setInterval(function () {
            let timeZoneSelected = getSelectedElement()
            let chicago_datetime_str = new Date().toLocaleString("en-US", { timeZone: timeZoneSelected })
           jQuery("#time").text(chicago_datetime_str)
       }, 1000)

    jQuery('#submit').on('click', function(event) {
        event.preventDefault()

        let form = jQuery("#form_time_zone")
        let actionUrl = form.attr('action')

        let timeZoneSelected = getSelectedElement()

        jQuery.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function(data)
            {
                jQuery("#TZ").text(timeZoneSelected)
            }
        })
    })

    jQuery('#zone').on('change', function() {
        jQuery("#TZ").text(this.value)
    })

})