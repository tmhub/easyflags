var EasyFlagsSelect = Class.create();
EasyFlagsSelect.prototype = {

    initialize: function (select, options = {}) {
        this.chosen = new Chosen(select, options);
        this.chosen.result_add_option = this.wrapResultAddOption();
    },

    wrapResultAddOption: function () {
        return this.chosen.result_add_option.wrap(
            function (originalMethod, option) {
                this.assignFlag(option);
                return originalMethod(option);
            }.bind(this)
        );
    },

    assignFlag: function (opt) {
        // assign flag image to dropdown item
        var options = this.chosen.form_field.options;
        if (typeof options[opt.array_index] !== 'undefined') {
            var imgUrl = options[opt.array_index].getAttribute('data-flag-url');
            opt.search_text = '<img src="' + imgUrl + '">'
                + '<span>' + opt.search_text + '</span>';
        }
    }

};

document.observe("dom:loaded", function(){
    window.easyFlags = new EasyFlagsSelect(
        $('select-language'),
        {width: "100px", disable_search_threshold: 10}
    );
});
