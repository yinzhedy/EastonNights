// contact form - handle AJAX form submission
jQuery(document).ready(function($) {
    console.log('Script loaded successfully');
    var contactForm = $('#form');
    console.log(contactForm);

    if (contactForm.length) {
        contactForm.submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = contactForm.serialize() + '&action=custom_contact_form&custom_contact_form_nonce=' + encodeURIComponent(contactForm.find('[name="custom_contact_form_nonce"]').val());
            console.log(formData);

            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response.data);
                    console.log("Success AJAX Post");
                },
                error: function(error) {
                    // Handle error response
                    console.log('Error:', error.responseText);
                    console.log("Error AJAX POST");
                }
            });
        });
    }
});

console.log('ajax_object:', ajax_object);