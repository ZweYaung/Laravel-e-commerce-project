(function ($) {
    "use strict";

    // Product Quantity
    $('.quantity button').on('click', function () {
    var button = $(this);
    var input = button.closest('.quantity').find('input');
    var oldValue = parseInt(input.val(), 10);

    if (button.hasClass('btn-plus')) {
        var newVal = oldValue + 1;
    } else {
        var newVal = oldValue > 1 ? oldValue - 1 : 1;
    }

    input.val(newVal);
});

})(jQuery);

