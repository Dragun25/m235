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
                template: 'Donin_OrderAttrs/checkout/display-attr'
            },
            selectors: {
                field: '[name="don_custom_text"]'
            },
            config: config(),
            initialize: function () {
                this._super();

                this.elem = $(this.selectors.field);
                $(document).on('change',this.selectors.field,function () {
                   // quote.setAttribute('don_custom_text',$(this).val())
                   quote.don_custom_text = $(this).val();
                });
                return this;
            }
        });
    }
);
