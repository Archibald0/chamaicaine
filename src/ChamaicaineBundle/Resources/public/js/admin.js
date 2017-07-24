$(document).ready(function () {
    $('ul.tabs').tabs();
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        autoclose: true, // automatic close timepicker
    });

    $('.timepicker').pickatime({
        default: 'now', // Set default time
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: true, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        vibrate: true,
    });

    $('#add_date').click( function (e) {
        e.preventDefault();

        $('.date_form').slideToggle(200);
    });
});