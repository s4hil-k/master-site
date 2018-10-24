// Register the following element definition with the builder
Builder.types.nr_modal = {

    // Label in the interface
    title: 'NR - Modal',

    // Icon in `New element` dialog
    icon: '{+$theme}-child/builder/nr-link-modal/icon.svg',

    // Icon in builder overview
    iconSmall: '{+$theme}-child/builder/nr-link-modal/icon-small.svg',

    // Show in `New element` dialog
    element: true,

    // Includes required functionality from the Builder
    mixins: [Builder.entity, Builder.element, Builder.container],

    // A function that returns a JS object which is then used to render the interface
    // Params are the currently stored parameters for this element
    params: function (params) {

        // Just for easier access later on
        var element = params.element;

        return {

            width: 500,

            tabs: [

                // The 1st tab usually contains all fields to fill in the actual content
                {
                    'title': 'Content',
                    'fields': {

                        // Content items
                        field_content: {
                            label: 'Text',
                            type: 'text',
                            //item: 'nr_modal_item',
                            title: 'content'
                        },
                        unique_id: {
                            label: 'Modal Target ID',
                            type: 'text',
                            //item: 'nr_modal_item',
                            description: 'Define your modal with a unique ID'
                        },
               body: {
                    label: 'Modal body code',
                    type: 'editor',
                    editor: 'code',
                    mode: 'text/html',
                    attrs: {
                        debounce: 500
                    }
                },

                style:{
                    label: 'Button Style',
                    type: 'select',
                    options: {
                        'Default': 'default',
                        'Primary': 'primary',
                        'Secondary': 'secondary',
                        'Text': 'text'
                    }
                }
                    }
                },

                // The 2nd tab usually includes fields with settings HOW to display the content
                {
                    title: 'Settings',
                    fields: {



                    }
                },


                // The 3rd tab usually contains the same fields that are rendered on the element container
                {
                    title: 'Advanced',
                    fields: {

                        // Using fields predefined in `yootheme/vendor/yootheme/theme/modules/builder/app/elements/params.js`
                        name: element.name,
                        id: element.id,
                        class: element.cls

                    }
                }
            ]
        }
    },

    // Set default values for fields
    data: function () {
        return {
            props: {
                style: 'default'
            }
        };
    }

};