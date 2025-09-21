jQuery(function ($) {
    $('body').on('click', '.np-add-coupon span', function (e) {
        e.preventDefault();

        let couponCode = $('#custom-coupon').val();
        let $notice = $('.custom-coupon-error-notice');

        if (!couponCode) {
            $notice.text('Bitte gib einen Gutscheincode ein.');
            return;
        }

        $notice.text('Gutschein wird überprüft...');

        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajax_url,
            data: {
                action: 'apply_custom_coupon',
                coupon_code: couponCode,
                security: my_ajax_object.nonce
            },
            success: function (response) {
                if (response && response.success) {
                    $notice.text('Gutschein erfolgreich angewendet.');

                    $(document.body).trigger('update_checkout'); 
                } else {
                    $notice.text(response.data.message || 'Ungültiger Gutschein.');
                }
            },

            error: function () {
                $notice.text('Ein Fehler ist aufgetreten.');
            }
        });
    });
});
