jQuery(document).ready(function(){

    // Initialize select2
    jQuery("#selUser").select2();

    // Read selected option
    jQuery('#but_read').click(function(){
        var username = $('#selUser option:selected').text();
        var userid = $('#selUser').val();

        jQuery('#result').html("id : " + userid + ", name : " + username);

    });
});