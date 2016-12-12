var EasyFlagsSelect = Class.create();
EasyFlagsSelect.prototype = {

    initialize: function (select, options = {}) {
        this.valTemplate = new Template(
            '<img src="#{flag}" class="flag"/>#{value}'
        );
        this.optTemplate = new Template(
            '<img src="#{flag}" class="flag"/><span>#{value}</span>'
        );
        this.chosen = new Chosen(select, options);
        this.assignValueFlag();
        this.wrapResultAddOption();
    },

    wrapResultAddOption: function () {
        this.chosen.result_add_option = this.chosen.result_add_option.wrap(
            function (originalMethod, option) {
                var html = originalMethod(option);
                if (html) {
                    html = this.assignOptionFlag(option, html);
                }
                return html;
            }.bind(this)
        );
    },

    assignValueFlag: function () {
        var selectedOptions = this.chosen.form_field.selectedOptions;
        if (selectedOptions.length > 0) {
            var data = {
                value: selectedOptions[0].innerHTML,
                flag: selectedOptions[0].getAttribute('data-flag-url')
            };
            this.chosen.container.down('.chosen-single span').innerHTML =
                this.valTemplate.evaluate(data);
        }
    },

    assignOptionFlag: function (opt, html) {
        var tempElement = new Element('div').update(html);
        var li = tempElement.down('li');
        var data = {
            value: li.innerHTML
        }
        // assign flag image to dropdown item
        var options = this.chosen.form_field.options;
        if (typeof options[opt.array_index] !== 'undefined') {
            data.flag = options[opt.array_index].getAttribute('data-flag-url');
        }
        li.innerHTML = this.optTemplate.evaluate(data);
        return tempElement.innerHTML;
    }

};

document.observe("dom:loaded", function(){
    window.easyFlags = new EasyFlagsSelect(
        $('select-language'),
        {width: "150px", disable_search_threshold: 10}
    );
});
