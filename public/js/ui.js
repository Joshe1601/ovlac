var goblal_models_selected = []
var id_selected = 0

function closeAllDetailPanel() {
    $('.detail-panel').each(function() {
        $(this).hide()
    })
}

const Accordion = function(selector) {
    const obj = {

        openPanel: function(panel) {
            panel.slideDown()
            const id = panel[0].id
            $(`[data-closed-image="panel-${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_on.png');
        },
        closePanel: function(panel) {
            closeAllDetailPanel()
            panel.slideUp()
            const id = panel[0].id
            $(`[data-closed-image="panel-${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
            panel.prev().find('[data-accordion-icon]').text("+")
            panel.prev().find('[data-closed-image]').attr('src', relative_path + '/public/images/ovlac/toggle_off.png');

        },
        togglePanel: function(id) {
            const panel = $(`[data-accordion-content="${id}"]`)
            if( panel.is(":hidden") ) {
                this.closeOtherPanels(id)
                this.openPanel(panel)
            } else {
                this.closePanel(panel)
            }
        },
        closeOtherPanels: function(openedPanel) {
            const _t = this
            $('[data-accordion-content]').each(function() {
                const panelId = $(this).data('accordion-content')
                if(panelId !== openedPanel) {
                    _t.closePanel($(this))
                }
            })
        },
        setEvents: function() {
            const _t = this
            $(".visor-link").click(function() {
                const id = $(this).attr("id")
                _t.togglePanel(id)
            })
        },
        init: function() {
            // this.el = $(selector)
            this.setEvents()
        }
    }

    obj.init()
    return obj
}
$(document).ready(function() {
    const accordion1 = Accordion(".new_accordion")


    // try to toggle selected and unseletect images
    $('.radio-image-container').click(function() {

        $('.radio-image-container').removeClass('selected');
        $(this).toggleClass('selected')

        $('.radio-image-container').not(this).each(function() {
            $(this).find('.overlay').css('background-color', '#B8B8B8');
            $(this).find('info-icon').attr('src', relative_path + '/public/images/ovlac/info.png');
        });

        $(this).find('.overlay').css('background-color', '#e52b38');
        $(this).find('info-icon').attr('src', relative_path + '/public/images/ovlac/info_selected.png');

        var radio = $(this).prev('.hidden-radio')
        radio.prop('checked', true)

    })

    $('.info-icon').click(function() {
        const categoryId = $(this).attr('data-icon-detail')

        $('.detail-panel').each(function() {
            if($(this).attr('data-detail-panel') === categoryId) {
                $(this).show()
            } else {
                $(this).hide()
            }
        })
    })

    $('.detail-panel-close').click(function() {
        closeAllDetailPanel()
    })

    $('.item-selected').click(function() {

        //const id = $(this).attr('model-group');
        const id_number = this.id.split('#')

        $('.detail-panel').each(function() {
            if($(this).attr('data-detail-panel') != id_number[1]) {
                $(this).hide()
            }
        })

        const input_radio = document.getElementById('#' + id_number[1])
        const selected_models = input_radio.value
        loadSelectedModels(selected_models)
        var radio = $(this).prev('.hidden-radio')
        radio.prop('checked', true)
    })

    $('#menu_options_toggle').click(function() {
        $('#new_accordion').toggle()
        // $('#message-selection').hide();
    })



    $("#finish_button").click(function(){
        //takeshot_selected_models();
    });

    // Send quote pdf by email
    $('#openPopup').click(function () {
        if(selected_models_collection.length > 0) {
            $('#popup').show();
            $('#layer').show();
            let selected_models_id = ''
            let total_price = get_total_price_selected_models(selected_models_collection)
            for(const model of selected_models_collection) {
                selected_models_id = selected_models_id + "," + model.model_id
            }
            $('#input_total_price').val(total_price);
            $('#input_selected_models_id').val(selected_models_id);
        }

    })

    $('#closePopup, #layer').click(function() {
        $('#popup').hide();
        $('#layer').hide();
    })


    // Update price label when we selected a collection of models

    let total_price = get_total_price_selected_models(selected_models_collection)
    update_totals(total_price);
    console.log('UI loaded');
});

function loadSelectedModels(selectedModels) {

    // Remove previous selectedModels, those which do not match with selected one
    clean_scene_from_old_models()

    let items = selectedModels.split(':')
    let clean_items = items.map( str => str.replaceAll( "\\", '').replaceAll('"', ''))
    var models_collection = []

    for(let i = 0; i < clean_items.length; i++) {
        if(clean_items[i] !== '') {
            let data = clean_items[i].substring(1, clean_items[i].length - 1)
            let model_array = data.split(',')
            if(model_array[0] !== '') {
                let model = {
                    model_id: model_array[3],
                    id: (Math.random() + 1).toString(36).substring(2),
                    url: model_array[0],
                    price: model_array[1],
                    color: model_array[2],
                    group: 'model-group'
                }
                models_collection.push(model)
            }
        }
    }

    for(const model of models_collection) {
        //add_model(relative_path + model.url, model.group, model.color, model.id)
        add_model_gltf(relative_path + model.url, model.group, model.color, center_group, model.id)
    }
    // update the price for totals
    selected_models_collection = models_collection
    let total_price = get_total_price_selected_models(selected_models_collection)
    update_totals(total_price)
}

function captureScreenshot() {
    return new Promise((resolve, reject) => {
        console.log("Screenshot", container[0]);
        var canvas = jQuery("#canvas_3d canvas")[0];

        // Change background color to white before capture
        renderer.setClearColor(0xffffff, 1);

        // Render the scene before capturing it
        renderer.render(scene, camera);

        // Revert to the original background color
        renderer.setClearColor(0xe9e9e9, 1);

        // Convert the WebGL canvas to a blob
        if (canvas && canvas.toBlob) {
            canvas.toBlob(function (blob) {
                const formData = new FormData();
                // Get current Date() to identify file
                const date = new Date();
                const formattedDate = date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2) + '_' +
                    ('0' + date.getHours()).slice(-2) + '-' +
                    ('0' + date.getMinutes()).slice(-2) + '-' +
                    ('0' + date.getSeconds()).slice(-2);
                const fileName = 'screenshot-' + formattedDate + '.png';

                // Add file and fileName to the formData
                formData.append('screenshot', blob, fileName);
                formData.append('filename', fileName);

                // Send the blob and fileName to the server
                fetch(relative_path + '/app/Helpers/saveScreenshot.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Success:', data); // Log the server response
                        resolve(fileName); // Resolve the promise with the filename
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        reject(error); // Reject the promise if there's an error
                    });
            });
        } else {
            console.log('ERROR: no hay canvas');
            reject(new Error('No canvas available')); // Reject the promise if there's no canvas
        }
    });
}



function submit_form(custom) {
    captureScreenshot().then(fileName => {
        createPDF(fileName);
    }).catch(error => {
        console.error('Error capturing screenshot:', error);
    });
}

function createPDF(fileName) {
    let custom = false;
    update_totals();
    let data_prod = {
        product_id: $("#input_product_id").val(),
        product_title: $("#input_product_title").val(),
        selected_models: selected_models_collection,
        product_selected_ids: [],
        total_price: get_total_price_selected_models(selected_models_collection),
        screenshot: fileName // Add the screenshot filename to the data
    };
    if (custom) {
        data_prod.product_selected_parts = [];
        $(".subvar_radio:checked").each(function() {
            let label = $("label[for='" + $(this).attr('id') + "']");
            data_prod.product_selected_parts.push(label.attr('title'));
            data_prod.product_selected_ids.push(label.attr('part_id'));
        });
    }

    let pd = btoa(JSON.stringify(data_prod));
    let submit_url = custom ? $("#input_submit_url").val() : $("#input_submit_url_default").val();
    submit_url = submit_url + "&prod_data=" + pd;
    if (!submit_url) return;

    if (selected_models_collection.length > 0) {
        window.open(submit_url, "_blank");
    } else {
        document.getElementById('message-selection').textContent = "Por favor, seleccione una opción.";
    }
}


function send_email(custom) {
    update_totals();
    let data_prod = {};
    data_prod['product_id'] = $("#input_product_id").val();
    data_prod['product_title'] = $("#input_product_title").val();
    if (custom) data_prod['product_selected_parts'] = [];
    data_prod['product_selected_ids'] = [];
    // new code v2
    data_prod['selected_models'] = selected_models_collection

    $(".subvar_radio:checked").each(function() {
        let label = $("label[for='" + $(this).attr('id') + "']");
        let part_title = label.attr('title');
        let part_id = label.attr('part_id');
        if (custom) data_prod['product_selected_parts'].push(part_title);
        data_prod['product_selected_ids'].push(part_id);
    });
    data_prod['total_price'] = get_total_price_selected_models(selected_models_collection)
    let submit_url = "";
    if (custom) {
        submit_url = $("#input_submit_url").val();
    } else {
        submit_url = $("#input_submit_url_default").val();
    }
    if (!submit_url) return;
    let pd = btoa(JSON.stringify(data_prod));
    submit_url = submit_url + "&prod_data=" + pd;
    // console.log('cuando hacemos click finish', submit_url)

    if(selected_models_collection.length > 0) {
       // window.open(submit_url, "_blank");
    } else {
        const h2MessageElement = document.getElementById('message-selection')
        h2MessageElement.textContent = "Por favor, seleccione una opción."
    }
}

const get_total_price_selected_models = (selected_models) => {
    let product_base_price = parseFloat($("#input_product_price").val());
    let total_price = product_base_price;
    if(selected_models.length > 0 ){
        for(const model of selected_models) {
            total_price += parseFloat(model.price);
        }
    }
    return total_price;
}

function get_total_price() {
    let price = parseFloat($("#input_product_price").val());
    $(".subvar_radio:checked").each(function() {
        let part_price = parseFloat($(this).attr("part_base_price"));
        if (part_price) price += part_price;
    });
    return price;
}

function update_totals(total_price = 0) {
    total_price_selected_models = get_total_price_selected_models(selected_models_collection)
    if(total_price == 0 ){
        total_price = total_price_selected_models
    }
    $("#price_total").text(parseFloat(total_price).toFixed(2));
}
