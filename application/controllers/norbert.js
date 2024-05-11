



var dropdowntoedit = $('#txt_regp_appcat').val(); 


if(dropdowntoedit == 11){
        // Set radio button value to "Oo" (Yes)
        $('#txt_regp_existing_neg1').prop('checked', true);
        // Disable both radio buttons
        $('input[name="txt_regp[existing_neg]"]').prop('disabled', true);
}
else 
{

    $('#txt_regp_appcat').change(function() {
        var selectedValue = $(this).val();
    
        // Check if the selected value is "Micro-Entrepreneur"
        if (selectedValue == 11) {
            // Set radio button value to "Oo" (Yes)
            $('#txt_regp_existing_neg1').prop('checked', true);
            // Disable both radio buttons
            $('input[name="txt_regp[existing_neg]"]').prop('disabled', true);
        } else {
            // Enable both radio buttons if the selected value is not "Micro-Entrepreneur"
            $('input[name="txt_regp[existing_neg]"]').prop('disabled', false);
        }
    }); 
    


}


