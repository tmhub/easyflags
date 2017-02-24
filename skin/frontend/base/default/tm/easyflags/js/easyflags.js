var EasyFlagsSelect = Class.create();
EasyFlagsSelect.prototype = {
    initialize: function (select, options) {
        this.chosen = new Chosen(select, options);
        // show easy flags select
        var parent = select.up('.eflags-hidden');
        if (parent) {
            parent.removeClassName('eflags-hidden');
        }
    }
};

document.observe("dom:loaded", function(){
    $$(".eflags-select").each(function(select){
        if (typeof window.easyFlags === 'undefined') {
            window.easyFlags = [];
        }
        window.easyFlags.push(
            new EasyFlagsSelect(
                select,
                {
                    inherit_select_classes: true,
                    disable_search_threshold: 10,
                    width: 'auto'
                }
            )
        );
    });
});
