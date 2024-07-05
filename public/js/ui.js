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
            const panel_father = $(`[data-accordion-button="${id}"]`);
            //Este accesory es el panel de "Accesorios"
            const accessory = $("[accessory]")
            //Este subaccesory son los subaccesorios de "Accesorios"
            const sub_accessory = $("[data-accessory]")
            //Este numero asegura que no se cierre el panel principal ya que si i = 0, simboliza al panel padre absoluto

            const sub_accessory_father_id = $("#"+id).attr('data-accessory')
            console.log(sub_accessory_father_id)

            if(id.substring(6) === panel_father.attr('model_father')) {
                console.log("Son iguales")

                let option_selected = document.getElementsByClassName('selected')
                console.log(option_selected)

                let input_element = option_selected[0].children[0]
                let input_value_option = input_element.value
                let input_value_father = panel_father.children().last().attr('value')

                console.log("input_value_option: "+input_value_option)
                console.log("input_value_father: "+input_value_father)

                if(input_element === undefined) {
                    const h2MessageElement = document.getElementById('message-selection')
                    h2MessageElement.textContent = "Por favor, seleccione una opción."
                }

                if(panel_father.hasClass('active')) {
                    $(`[data-closed-image="${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
                    input_value_option = input_value_option.replace(input_value_father, '');
                    console.log("input_value_option: "+input_value_option)
                    input_element.value = input_value_option;
                    panel_father.removeClass('active');
                    loadSelectedModels(input_value_option)

                } else {
                    $(`[data-closed-image="${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_on.png');
                    input_value_option = input_value_option + input_value_father
                    console.log("input_value_option: "+input_value_option)
                    input_element.value = input_value_option;
                    panel_father.addClass('active');
                    loadSelectedModels(input_value_option)

                }
            } else if(sub_accessory_father_id !== undefined){
                const accessory_father = $(`[data-accessory="${sub_accessory_father_id}"]`);
                $(accessory_father).not(panel_father).each(function() {
                    const otherId = $(this).attr('data-accordion-button');
                    console.log("otherId: "+otherId)
                    if ($(this).hasClass('active')) {
                        console.log("Llega a cerrar los demas paneles")
                        $(`[data-closed-image="${otherId}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
                        $(this).removeClass('active');
                        const otherContentId = otherId.replace('panel-', '');
                        console.log("otherContentId: "+otherContentId)
                        const visor_body = $(`#body-${otherContentId}`)
                        visor_body.removeClass('show');

                    }
                });

                if(panel_father.hasClass('active')) {
                    $(`[data-closed-image="${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
                    panel_father.removeClass('active');
                    let option = $('.selected')
                    console.log(option)
                    option.find('.overlay').css('background-color', '#B8B8B8');

                    let radioImageFather = option.attr('radio-image-father');
                    console.log(radioImageFather)

                    let input_value_father = $("#"+radioImageFather).children().first().attr('value')
                    console.log("input_value_father: "+input_value_father)
                    loadSelectedModels(input_value_father)

                } else {
                    $(`[data-closed-image="${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_on.png');
                    panel_father.addClass('active');
                }
            } else {
                //Este id es el id del accessory
                let id_accessory = accessory.children().first().attr('id');

                let i = 0;

                //Este id es el id del data-accordion-button
                id = id.substring(6)

                console.log("id"+id)
                console.log("id Acc:" + id_accessory)

                //Si el id del data-accordion-button es diferente al id del accessory,
                // entonces se cierra el panel de "Accesorios" menos los subaccesorios
                if(id_accessory !== id ) {
                    //Esta lista contiene los id de todos los subaccesorios
                    let id_sub_accessory = [];

                    sub_accessory.each(function() {
                        console.log(sub_accessory)
                    });


                    //Si el id del data-accordion-button no esta en el array de los id de los subaccesorios,
                    //entonces se cierran los demas paneles
                    if (id_sub_accessory.indexOf(id) === -1){
                        $('[data-accordion-button]').not(panel_father).each(function() {
                            const otherId = $(this).attr('data-accordion-button');
                            console.log("otherId: "+otherId)
                            if ($(this).hasClass('active') && i !== 0 && otherId !== "panel-57") {
                                console.log("Llega a cerrar los demas paneles")
                                $(`[data-closed-image="${otherId}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
                                $(this).removeClass('active');
                                const otherContentId = otherId.replace('panel-', '');
                                const visor_body = $(`#body-${otherContentId}`)
                                visor_body.removeClass('show');
                                accessory.addClass('d-none')
                                let idAccessory = $("[accessory]").children().first().attr('id')
                                $('#body-'+idAccessory).removeClass('show')
                            } else{
                                i++;
                            }
                            console.log("i: "+i)
                        });
                    }else{

                    }
                }
                if(panel_father.hasClass('active')) {
                    $(`[data-closed-image="panel-${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
                    panel_father.removeClass('active');
                } else {
                    $(`[data-closed-image="panel-${id}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_on.png');
                    panel_father.addClass('active');
                }
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

        console.log('radio', $(this).attr("id"))
        let radioFatherId = $(this).attr("id")
        console.log('radioChild', $(`[radio-image-father="${radioFatherId}"]`))
        let radioChildren = $(`[radio-image-father="${radioFatherId}"]`)

        let model_father = $('[model_father]')
        console.log('model_father', model_father)
        if(model_father.hasClass('active')) {
            $(`[data-closed-image= "${model_father.attr('id')}"]`).attr('src', relative_path + '/public/images/ovlac/toggle_off.png');
            model_father.removeClass('active');

        }
        let input_model_father = model_father.children().last().attr('value')
        let option = document.getElementsByClassName('selected')
        console.log(option)
        let input_element = option[0].children[0]
        let input_value_option = input_element.value
        console.log("input_model_father: "+input_model_father)
        console.log("input_value_option: "+input_value_option)
        input_value_option = input_value_option.replace(input_model_father, '');
        input_element.value = input_value_option;
        loadSelectedModels(input_value_option)
        if(radioChildren.length > 0) {
            $('[radio-image-father]').not(radioChildren).each(function() {
                $(this).addClass('d-none')
            });
            radioChildren.removeClass('d-none')
            console.log('inputvalue', $(this).children().first().attr('value'))
            let input_value_father = $(this).children().first().attr('value')

            if(input_value_father === ":[\"\\/storage\\/app\\/models\\/php1LuVm3\\/Bastidor normal.glb\",\"0.00\",\"\",54]"
            || input_value_father === ":[\"\\/storage\\/app\\/models\\/phpGwIHOx\\/Bastidor laminas.glb\",\"0.00\",\"\",55]"){
                radioChildren.each(function() {
                    let child = $(this).children().first();

                    console.log('child', child)
                    child.attr('value', child.attr('value').replace(input_value_father, ""));
                    child.attr('value', child.attr('value') + input_value_father);


                }); }

        }


        $("[accessory]").removeClass('d-none')
        let idAccessory = $("[accessory]").children().first().attr('id')
        $('#body-'+idAccessory).addClass('show')

    })
    $('#info-lateral-icon').click(function() {
        $('#detail-lateral-panel').show()
    })

    $('#detail-lateral-panel-close').click(function() {
        $('#detail-lateral-panel').hide()
    })

    $('#fullScreen').click(function() {
        document.getElementById('visor_3d').requestFullscreen().then(r => console.log(r)).catch(e => console.log(e));
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

        // Cambiar el color de fondo a blanco antes de capturar
        renderer.setClearColor(0xffffff, 1);

        // Renderizar la escena antes de capturarla
        renderer.render(scene, camera);

        // Volver al color de fondo original
        renderer.setClearColor(0xe9e9e9, 1);

        // Convertir el canvas WebGL a un blob con recorte
        if (canvas && canvas.toBlob) {
            const originalWidth = canvas.width;
            const originalHeight = canvas.height;

            // Parámetros de recorte individual para cada lado
            const cropMarginTop = 300;    // Recorte superior
            const cropMarginBottom = 300; // Recorte inferior
            const cropMarginLeft = 500;   // Recorte izquierdo
            const cropMarginRight = 500;  // Recorte derecho

            // Crear un nuevo canvas para el recorte
            const cropCanvas = document.createElement('canvas');
            const cropContext = cropCanvas.getContext('2d');

            // Configurar las dimensiones del canvas de recorte
            cropCanvas.width = originalWidth - cropMarginLeft - cropMarginRight;
            cropCanvas.height = originalHeight - cropMarginTop - cropMarginBottom;

            // Dibujar la imagen recortada en el nuevo canvas
            cropContext.drawImage(canvas, cropMarginLeft, cropMarginTop, cropCanvas.width, cropCanvas.height, 0, 0, cropCanvas.width, cropCanvas.height);

            // Convertir el canvas recortado a un blob
            cropCanvas.toBlob(function (blob) {
                const formData = new FormData();
                const date = new Date();
                const formattedDate = date.getFullYear() + '-' +
                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + date.getDate()).slice(-2) + '_' +
                    ('0' + date.getHours()).slice(-2) + '-' +
                    ('0' + date.getMinutes()).slice(-2) + '-' +
                    ('0' + date.getSeconds()).slice(-2);
                const fileName = 'screenshot-' + formattedDate + '.png';

                // Agregar archivo y nombre de archivo al formData
                formData.append('screenshot', blob, fileName);
                formData.append('filename', fileName);

                // Enviar el blob y el nombre del archivo al servidor
                fetch(relative_path + '/app/Helpers/saveScreenshot.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log('Success:', data); // Registrar la respuesta del servidor
                        resolve(fileName); // Resolver la promesa con el nombre del archivo

                        // Cargar la imagen recortada y agregarla al PDF
                        const img = new Image();
                        console.log("ACA EMPIEZA URL")
                        console.log(URL)
                        img.src = URL.createObjectURL(blob);
                        console.log(img.src)
                        img.onload = function() {
                            // Crear el PDF
                            const pdf = new jsPDF('landscape', 'pt', [originalWidth, originalHeight]);
                            pdf.addImage(img, 'PNG', 0, 0, originalWidth, originalHeight);
                            pdf.save('screenshot.pdf');
                        };
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        reject(error); // Rechazar la promesa si hay un error
                    });
            });
        } else {
            console.log('ERROR: no hay canvas');
            reject(new Error('No canvas available')); // Rechazar la promesa si no hay canvas
        }
    });
}

function submit_form(custom) {
    captureScreenshot().then(fileName => {
        setTimeout(() => {
            createPDF(fileName);
        }, 3000);

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
