var goblal_models_selected = []
$(document).ready(function() {
    // $(".subvar_radio").on('change', function(e) {
    //     $(this).parents('.variation_list').find("li").removeClass('active');
    //     $(this).parents(".variation_list > li").addClass('active');
    //
    //
    //     var model_file = $(this).val();
    //     var model_group = $(this).attr('model-group');
    //     var model_color = "";
    //     if ($(this).attr('colorize')) {
    //         model_color = $(this).attr('colorize');
    //     }
    //     //remove_model_group(model_group);
    //     if (!model_file) {
    //         remove_model_group(model_group);
    //     } else {
    //         //add_model(relative_path + '/public/models/test/IndividualElements/'+model_file+'/'+model_file+'.gltf', model_group);
    //         add_model(relative_path + model_file, model_group, model_color);
    //     }
    //
    //     //update price label
    //     var model_price = $(this).attr('part_base_price');
    //     console.log("price " + model_price);
    //     $(this).parents(".variation_vars").first().find(".variation_price .price_value").first().text(parseFloat(model_price).toFixed(2));
    //     update_totals();
    // });

    // try to toggle selected and unseletect images
    $('.radio-image').click(function() {
        $('.radio-image').removeClass('selected');
        $(this).toggleClass('selected')

        var radio = $(this).prev('.hidden-radio')
        radio.prop('checked', true)

    })

    $('.item-selected').click(function() {
        console.log('selected item', this.id)
        const id = $(this).attr('model-group');
        const id_number = this.id.split('#')

        const input_radio = document.getElementById('#' + id_number[1])
        console.log('the input radio', input_radio.value)
        const selected_models = input_radio.value
        //$(this).toggleClass('selected')
       // global_models_selected = selected_models
        loadSelectedModels(selected_models)

        var radio = $(this).prev('.hidden-radio')
        radio.prop('checked', true)

    })

    $('#menu_options_toggle').click(function() {
        console.log('aqui estamos')
        $('#accordion').toggle()
    })

    // $(".selectedModels").click(function(){
    //
    //     console.log('we are here selected Models')
    //     // get data for selected models
    //     const model_group = $(this).attr('model-group');
    //     const selectedModels = $( this ).val();
    //
    //
    //
    //     // Remove previous selectedModels, those which do not match with selected one
    //     clean_scene_from_old_models()
    //
    //     let items = selectedModels.split(':')
    //     let clean_items = items.map( str => str.replaceAll( "\\", '').replaceAll('"', ''))
    //     var models_collection = []
    //
    //     for(let i = 0; i < clean_items.length; i++) {
    //         if(clean_items[i] !== '') {
    //             let data = clean_items[i].substring(1, clean_items[i].length - 1)
    //             let model_array = data.split(',')
    //             if(model_array[0] !== '') {
    //                 let model = {
    //                     model_id: model_array[3],
    //                     id: (Math.random() + 1).toString(36).substring(2),
    //                     url: model_array[0],
    //                     price: model_array[1],
    //                     color: model_array[2],
    //                     group: 'model-group'
    //                 }
    //                 models_collection.push(model)
    //             }
    //         }
    //     }
    //
    //     for(const model of models_collection) {
    //         add_model(relative_path + model.url, model.group, model.color, model.id)
    //     }
    //     // update the price for totals
    //     selected_models_collection = models_collection
    //
    //     let total_price = get_total_price_selected_models(selected_models_collection)
    //     update_totals(total_price)
    // });

    $("#finish_button").click(function(){

        //takeshot_selected_models();
    });

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
        add_model(relative_path + model.url, model.group, model.color, model.id)
    }
    // update the price for totals
    selected_models_collection = models_collection
    console.log('los modelos que se han seleccted', selected_models_collection)
    let total_price = get_total_price_selected_models(selected_models_collection)
    update_totals(total_price)
}



// function captureScreenshot() {
//     try {
//         var canvas = document.getElementById('visor_3d');
//         var imageData = canvas.toDataURL('image/png'); // Get image data as Data URL
//         console.log('imagen data => ', imageData);
//         // Send image data to backend to save
//         saveImageWithForm(imageData, );
//     } catch (error) {
//         console.error('Error capturing screenshot:', error);
//     }
// }

// function sameImageWithForm(imageData, saveDirectory) {
//     // Create a form element
//     var form = document.createElement('form');
//     form.setAttribute('method', 'post');
//     form.setAttribute('action', "{{ controller_path() }}{{ controller_sep() }}md=product&action=save_image");
//     // "{{ controller_path() }}{{ controller_sep() }}md=product&action=save_image" / 'save_image'
//     form.setAttribute('enctype', 'multipart/form-data');
//     form.style.display = 'none'; // Hide the form
//
//     // Create input fields for imageData and saveDirectory
//     var imageDataInput = document.createElement('input');
//     imageDataInput.setAttribute('type', 'hidden');
//     imageDataInput.setAttribute('name', 'imageData');
//     imageDataInput.setAttribute('value', imageData);
//
//     var saveDirectoryInput = document.createElement('input');
//     saveDirectoryInput.setAttribute('type', 'hidden');
//     saveDirectoryInput.setAttribute('name', 'saveDirectory');
//     saveDirectoryInput.setAttribute('value', saveDirectory);
//
//     // Append input fields to the form
//     form.appendChild(imageDataInput);
//     form.appendChild(saveDirectoryInput);
//
//     // Append the form to the document body
//     document.body.appendChild(form);
//
//     // Submit the form
//     form.submit();
// }

// Function to send image data to backend to save
// function saveImageToServer(imageData) {
//     fetch('/save-file', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify({ imageData: imageData }), // Send image data in JSON format
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 console.log('Image saved successfully at:', data.imagePath);
//             } else {
//                 console.error('Error saving image:', data.error);
//             }
//         })
//         .catch(error => {
//             console.error('Error saving image to server:', error);
//         });
// }


function submit_form(custom) {

    //captureScreenshot(); // take a screenshot of the scene for adding it to the pdf report
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
    console.log('la length de la collection of models', selected_models_collection)
    if(selected_models_collection.length > 0) {
        window.open(submit_url, "_blank");
    } else {
        const h2MessageElement = document.getElementById('message-selection')
        h2MessageElement.textContent = "Por favor, seleccione una opcion."
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
        console.log('part price', part_price);
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
