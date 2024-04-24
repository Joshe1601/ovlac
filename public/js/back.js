$(document).ready(function() {
    //$('.color-picker').colorpicker();
    //$('.color-picker').ColorPicker([]);


    $('.color-picker').each(function() {

        var el = $(this);
        $(this).ColorPicker({
            color: '#0000ff',
            onChange: function (hsb, hex, rgb) {
                //console.log(el);
                el.find('div').css('backgroundColor', '#' + hex);
                console.log(el.find('div'));
                el.find('input').val(hex);
            }
        });
        el.find('div').css('backgroundColor', '#' + el.find('input').val());
    });

    $(".btn-add-part").on('click', function() {
        var generateRandomString = (length=6)=>Math.random().toString(10).substr(2, length);
        var form = $(this).parents(".form_part");
        var id_part = $(this).attr('id_part');

        var new_el = form.parent().find(".accordion-item.new-element");

        //new_el.html(new_el.html().replaceAll('[0]', '[new'+generateRandomString()+']'));



        $(this).parents(".vars_form").first().children('.accordion').append(new_el[0].outerHTML.replaceAll('[0]', '[new'+generateRandomString()+']'));
        $(this).parents(".vars_form").first().children('.accordion').children('.accordion-item.new-element').find('.form_product_part_id').first().val(id_part);

        var el = $(this).parents(".vars_form").first().children('.accordion').children('.accordion-item.new-element').find('.color-picker');

        el.ColorPicker({
            color: '#0000ff',
            onChange: function (hsb, hex, rgb) {
                //console.log(el);
                el.find('div').css('backgroundColor', '#' + hex);
                console.log(el.find('div'));
                el.find('input').val(hex);
            }
        });

        $(this).parents(".vars_form").first().children('.accordion').children('.accordion-item.new-element').removeClass('new-element').show();
        //new_el.show().click();
    });


    console.log('UI loaded');
});
