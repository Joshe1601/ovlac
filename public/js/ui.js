var goblal_models_selected = []
var id_selected = 0

function closeAllDetailPanel() {
    $('.detail-panel').each(function() {
        $(this).hide()
    })
}

const Accordion = function(selector) {
    const obj = {
        toggleImage: function(elementId, state) {
            const imageSrc = state === 'on' ? 'toggle_on.png' : 'toggle_off.png';
            $(`[data-closed-image="${elementId}"]`).attr('src', `${relative_path}/public/images/ovlac/${imageSrc}`);
        },

        updateInputValue: function(input, fatherValue, add) {
            return add ? input.value + fatherValue : input.value.replace(fatherValue, '');
        },

        openPanel: function(panel) {
            panel.slideDown();
            const id = panel[0].id;
            this.toggleImage(`panel-${id}`, 'on');
        },

        closePanel: function(panel) {
            closeAllDetailPanel();
            panel.slideUp();
            const id = panel[0].id;
            this.toggleImage(`panel-${id}`, 'off');
            panel.prev().find('[data-accordion-icon]').text("+");
        },

        handleModelFatherToggle: function(id, panelFather) {
            console.log("Son iguales");
            const optionSelected = document.getElementsByClassName('selected')[0];
            const inputElement = optionSelected.children[0];
            const inputValueFather = panelFather.children().last().attr('value');

            console.log(`input_value_option: ${inputElement.value}`);
            console.log(`input_value_father: ${inputValueFather}`);

            if (!inputElement) {
                document.getElementById('message-selection').textContent = "Por favor, seleccione una opción.";
                return;
            }

            if (panelFather.hasClass('active')) {
                this.toggleImage(id, 'off');
                inputElement.value = this.updateInputValue(inputElement, inputValueFather, false);
                panelFather.removeClass('active');
            } else {
                this.toggleImage(id, 'on');
                inputElement.value = this.updateInputValue(inputElement, inputValueFather, true);
                panelFather.addClass('active');
            }

            loadSelectedModels(inputElement.value);
        },

        handleSubAccessoryToggle: function(id, panelFather, subAccessoryFatherId) {
            const accessoryFather = $(`[data-accessory="${subAccessoryFatherId}"]`);

            accessoryFather.not(panelFather).each((_, element) => {
                const otherId = $(element).attr('data-accordion-button');
                if ($(element).hasClass('active')) {
                    console.log("Llega a cerrar los demas paneles");
                    this.toggleImage(otherId, 'off');
                    $(element).removeClass('active');
                    $(`#body-${otherId.replace('panel-', '')}`).removeClass('show');
                }
            });

            if (panelFather.hasClass('active')) {
                this.toggleImage(id, 'off');
                panelFather.removeClass('active');
                const option = $('.selected');
                option.find('.overlay').css('background-color', '#B8B8B8');

                const radioImageFather = option.attr('radio-image-father');
                const inputValueFather = $(`#${radioImageFather}`).children().first().attr('value');
                $(`#${radioImageFather}`).find('.overlay').css('background-color', '#e52b38');
                loadSelectedModels(inputValueFather);
            } else {
                this.toggleImage(id, 'on');
                panelFather.addClass('active');
            }
        },

        handleGeneralToggle: function(id, panelFather, accessory, subAccessory) {
            const idAccessory = accessory.children().first().attr('id');
            const panelId = id.substring(6);

            console.log(`id: ${panelId}`);
            console.log(`id Acc: ${idAccessory}`);

            if (idAccessory !== panelId) {
                const idSubAccessory = subAccessory.map(function() {
                    return $(this).attr('id');
                }).get();

                if (!idSubAccessory.includes(panelId)) {
                    this.closeOtherPanels(panelFather, accessory);
                }
            }

            if (panelFather.hasClass('active')) {
                this.toggleImage(`panel-${panelId}`, 'off');
                panelFather.removeClass('active');
            } else {
                this.toggleImage(`panel-${panelId}`, 'on');
                panelFather.addClass('active');
            }
        },

        closeOtherPanels: function(panelFather, accessory) {
            $('[data-accordion-button]').not(panelFather).each((index, element) => {
                const otherId = $(element).attr('data-accordion-button');
                if (index !== 0 && otherId !== "panel-57" && $(element).hasClass('active')) {
                    this.toggleImage(otherId, 'off');
                    $(element).removeClass('active');
                    $(`#body-${otherId.replace('panel-', '')}`).removeClass('show');
                    accessory.addClass('d-none');
                    const idAccessory = $("[accessory]").children().first().attr('id');
                    $(`#body-${idAccessory}`).removeClass('show');
                }
            });
        },

        togglePanel: function(id) {
            const panelFather = $(`[data-accordion-button="${id}"]`);
            const accessory = $("[accessory]");
            const subAccessory = $("[data-accessory]");
            const subAccessoryFatherId = $(`#${id}`).attr('data-accessory');

            if (id.substring(6) === panelFather.attr('model_father')) {
                this.handleModelFatherToggle(id, panelFather);
            } else if (subAccessoryFatherId !== undefined) {
                this.handleSubAccessoryToggle(id, panelFather, subAccessoryFatherId);
            } else {
                this.handleGeneralToggle(id, panelFather, accessory, subAccessory);
            }
        },

        setEvents: function() {
            $(".visor-link").click((event) => {
                const id = $(event.currentTarget).attr("id");
                this.togglePanel(id);
            });
        },

        init: function() {
            this.setEvents();
        }
    };

    obj.init();
    return obj;
};
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

        let radioImageFather = $(this).attr('radio-image-father');
        console.log(radioImageFather)

        $("#"+radioImageFather).find('.overlay').css('background-color', '#e52b38');
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
            const cropMarginBottom = 200; // Recorte inferior
            const cropMarginLeft = 150;   // Recorte izquierdo
            const cropMarginRight = 150;  // Recorte derecho

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
        }, 1000);

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
