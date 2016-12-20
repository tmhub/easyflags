;(function(){

    var attrSrc = 'data-image-url';
    var optionTemplate = new Template(
        '<img src="#{flag}"/> <i>#{value}</i>'
    );

    function _assignOptionFlag (option, html) {
        if (typeof option !== 'undefined' && option.hasAttribute(attrSrc)) {
            var tempElement = new Element('div').update(html);
            var li = tempElement.down('li');
            if (li) {
                var data = {};
                data.value = li.innerHTML;
                data.flag = option.getAttribute(attrSrc);
                if (data.flag) {
                    li.addClassName('image-nowrap');
                    li.innerHTML = optionTemplate.evaluate(data);
                    html = tempElement.innerHTML;
                }
            }
        }
        return html;
    }

    function _assignValueFlag (option, html) {
        if (typeof option === 'undefined' || typeof html === 'undefined') {
            return html;
        }
        if (option.hasAttribute(attrSrc)) {
            var data = {};
            data.value = html;
            data.flag = option.getAttribute(attrSrc);
            if (data.flag) {
                html = optionTemplate.evaluate(data);
            }
        }
        return html;
    }

    Chosen.prototype.result_add_option = Chosen.prototype.result_add_option.wrap(
        function (originalMethod, option) {
            var html = originalMethod(option);
            return _assignOptionFlag(
                this.form_field.options[option.array_index],
                html
            );
        }
    );

    Chosen.prototype.single_set_selected_text =
        Chosen.prototype.single_set_selected_text.wrap(
            function (originalMethod, text) {
                html = _assignValueFlag(
                        this.form_field[this.form_field.selectedIndex],
                        text
                    );
                return originalMethod(html);
            }
        );

})();
