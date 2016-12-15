var EasyFlagsSelect = Class.create();
EasyFlagsSelect.prototype = {

    initialize: function (select, options = {}) {
        this.chosen = new Chosen(select, options);
        // show easy flags select
        var parent = this.chosen.container.up('.form-language');
        if (parent) {
            parent.removeClassName('easyflags-hidden');
        }
    }

}

document.observe("dom:loaded", function(){
    window.easyFlagsSelect = new EasyFlagsSelect(
        $('select-language'),
        {
            inherit_select_classes: true,
            disable_search_threshold: 10
        }
    );

});
