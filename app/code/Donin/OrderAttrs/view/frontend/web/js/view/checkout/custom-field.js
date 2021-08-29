define(
    [
        'jquery',
        'uiComponent',
        'Magento_Shipping/js/model/config',
        'Magento_Checkout/js/model/quote'
    ],
    function ($, Component, config, quote) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Donin_OrderAttrs/checkout/custom-field'
            },
            selectors: {
                field: '[name="don_custom_field"]'
            },
            config: config(),
            initialize: function () {
                this._super();

                this.elem = $(this.selectors.field);
                $(document).on('change',this.selectors.field,function () {
                   console.log($(this));
                });
                return this;
            }
        });
    }
);
