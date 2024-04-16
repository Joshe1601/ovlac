
$(document).ready(function() {
    $(".subvar_radio").on('change', function(e) {
        $(this).parents('.variation_list').find("li").removeClass('active');
        $(this).parents(".variation_list > li").addClass('active');


        var model_file = $(this).val();
        var model_group = $(this).attr('model-group');
        var model_color = "";
        if ($(this).attr('colorize')) {
            model_color = $(this).attr('colorize');
        }
        //remove_model_group(model_group);
        if (!model_file) {
            remove_model_group(model_group);
        } else {
            //add_model(relative_path + '/public/models/test/IndividualElements/'+model_file+'/'+model_file+'.gltf', model_group);
            add_model(relative_path + model_file, model_group, model_color);
        }

        //update price label
        var model_price = $(this).attr('part_base_price');
        console.log("price " + model_price);
        $(this).parents(".variation_vars").first().find(".variation_price .price_value").first().text(parseFloat(model_price).toFixed(2));
        update_totals();
    });



    $(".selectedModels").change(function(){
        // get data for selected models
        const model_group = $(this).attr('model-group');
        const selectedModels = $( this ).val();

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
                        group: model_group
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

        let total_price = get_total_price_selected_models(selected_models_collection)
        update_totals(total_price)
    });

    $("#finish_button").click(function(){

        //takeshot_selected_models();
    });

    // Update price label when we selected a collection of models

    let total_price = get_total_price_selected_models(selected_models_collection)
    update_totals(total_price);
    console.log('UI loaded');
});



function saveAsImage() {


    try {



        const cav = document.querySelector('#canvas_3d');
        console.log('cav', cav)
        const base64 = cav.toDataURL('img/png');
        var imagen = document.createElement('img')
        imagen.src = base64;
        var mainElement = document.getElementById('main');
        mainElement.appendChild(imagen)


    } catch (e) {
        console.log(e);
        return;
    }

}

var saveFile = function (strData, filename) {
    var link = document.createElement('a');
    if (typeof link.download === 'string') {
        document.body.appendChild(link); //Firefox requires the link to be in the body
        link.download = filename;
        link.href = strData;
        link.click();
        document.body.removeChild(link); //remove the link when done
    } else {
        location.replace(uri);
    }
}



function submit_form(custom) {

    //saveAsImage(); // take a screenshot of the scene for adding it to the pdf report
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
    if(selected_models_collection.length > 0) {
        window.open(submit_url, "_blank");
    } else {
        const h2MessageElement = document.getElementById('message-selection')
        h2MessageElement.textContent = "Please, select an option"
        console.log("NEED TO SELECT AN OPTION")
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
