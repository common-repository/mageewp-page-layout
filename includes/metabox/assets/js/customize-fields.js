
/*
 * Customize fields js functions  
 
 */
wp.customize.controlConstructor['pf_select'] = wp.customize.Control.extend({
    // When we're finished loading continue processing
    ready: function () {

        'use strict';

        var control = this,
                element = this.container.find('select'),
                multiple = element.data('multiple'),
                selectValue;

        // If this is a multi-select control,
        // then we'll need to initialize selectize using the appropriate arguments.
        // If this is a single-select, then we can initialize selectize without any arguments.

        if (multiple) {
            jQuery(element).selectize({
                plugins: ['remove_button', 'drag_drop']
            });
        }

        // Change value
        this.container.on('change', 'select', function () {

            selectValue = jQuery(this).val();

            // If this is a multi-select, then we need to convert the value to an object.
            if (multiple) {
                selectValue = _.extend({}, jQuery(this).val());
            }

            control.setting.set(selectValue);

        });

    }

});

jQuery(function ($) {

    if (document.getElementsByClassName('mpl-icon_picker').length) {
        $('.customize-control .mpl-icon_picker:not(.child-field) select').fontIconPicker();
    }

    if (document.getElementsByClassName('mpl-repeater').length) {
        $('.mpl-repeater').qfRepeater();
    }

    if (document.getElementsByClassName('mpl-map').length) {
        $('.mpl-map').qfMap();
    }

    if (document.getElementsByClassName('mpl-datetime').length) {
        $('.mpl-datetime input').each(function () {
            var data = $(this).data();
            $(this).datetimepicker(data);
        });
    }

    $('.accordion-section').on('expanded', function () {
        if ($(this).find('.mpl-map:not(.child-field)').length) {
            $(this).find('.mpl-map:not(.child-field)').qfMap();
        }
    });
});

