
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


    $('.selectedModels').change(function(){

        // get data for selected models
        const selectedModels = $( this ).val();
        let items = selectedModels.split(':')
        let clean_items = items.map( str => str.replaceAll( "\\", '').replaceAll('"', ''))
        console.log('Clean Models', clean_items)
        let models_collection = []
        for(let i = 0; i < clean_items.length; i++) {
            if(clean_items[i] !== '') {
                let data = clean_items[i].substring(1, clean_items[i].length - 1)
                let modelo_array = data.split(',')
                let modelo = {
                    url_model: modelo_array[0],
                    price_model: modelo_array[1],
                    color_model: modelo_array[2]
                }
                models_collection.push(modelo)
            }
        }
        console.log('Ay Joder...', models_collection)

        // print the selected models

        
        // update the price for totals


        // remove the other models
    });


    /* $("#cta_button").on("click", function() {
    }); */
    update_totals();
    console.log('UI loaded');
});

function submit_form(custom) {
    update_totals();
    let data_prod = {};
    data_prod['product_id'] = $("#input_product_id").val();
    data_prod['product_title'] = $("#input_product_title").val();
    if (custom) data_prod['product_selected_parts'] = [];
    data_prod['product_selected_ids'] = [];

    $(".subvar_radio:checked").each(function() {
        let label = $("label[for='" + $(this).attr('id') + "']");
        let part_title = label.attr('title');
        let part_id = label.attr('part_id');
        if (custom) data_prod['product_selected_parts'].push(part_title);
        data_prod['product_selected_ids'].push(part_id);
    });

    data_prod['total_price'] = get_total_price();

    //console.log(data_prod);
    let submit_url = "";
    if (custom) {
        submit_url = $("#input_submit_url").val();
    } else {
        submit_url = $("#input_submit_url_default").val();
    }
    if (!submit_url) return;

    //location.href = submit_url;
    //console.log(JSON.stringify(data_prod));
    let pd = btoa(JSON.stringify(data_prod));
    submit_url = submit_url + "&prod_data=" + pd;
    window.open(submit_url, "_blank");


    /* $.ajax({
        type: 'POST',
        url: '../event/print',
        async: false,
        data: data_prod,
        success:function(data){

        },
        error:function(data){

        }
    }); */


    /* $.ajax({
        type: "POST",
        url: submit_url,
        data: data_prod,
    }); */

    /* $.ajax({
        type: 'POST',
        url: submit_url,
        data: data_prod,
    })
    .done(function( data ) {
        // CALLBACK
    }); */

}


function get_total_price() {
    let price = parseFloat($("#input_product_price").val());
    console.log(price);
    $(".subvar_radio:checked").each(function() {
        let part_price = parseFloat($(this).attr("part_base_price"));
        console.log(part_price);
        if (part_price) price += part_price;
    });
    return price;
}

function update_totals() {
    let price = get_total_price();
    $("#price_total").text(parseFloat(price).toFixed(2));
}
