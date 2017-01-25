(function() {
    tinymce.create("tinymce.plugins.adproduct_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {
            //add new button     
            ed.addButton("adproduct", {
                title : "Add ad Product",
                cmd : "add_adproduct",
                image : url + "/icons/adProduct.png"
            });

            
            ed.addCommand( 'add_adproduct', function() {
                    // Calls the pop-up modal
                    ed.windowManager.open({
                            // Modal settings
                            file: url + '/popup.php',
                            title: 'Embed Quiz and Polls',
                            width: window.innerWidth * 0.80,
                            height: window.innerHeight * 0.80,
                            inline: 1,
                            id: 'plugin-slug-insert-dialog',
                            buttons: [
                            {
                                    text: 'Cancel',
                                    id: 'plugin-slug-button-cancel',
                                    onclick: 'close'
                            }],
                    });

            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "Pranita",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("adproduct_button_plugin", tinymce.plugins.adproduct_button_plugin);
})();