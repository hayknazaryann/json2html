(function($) {
    $.fn.serializeWithFiles = function() {
        var obj = $(this);
        var formData = new FormData();
        $.each(obj.find("input[type='file']"), function(i, tag) {
            $.each($(tag)[0].files, function(i, file) {
                formData.append(tag.name, file);
            });
        });
        var params = obj.serializeArray();
        $.each(params, function (i, val) {
            formData.append(val.name, val.value);
        });
        return formData;
    };
})(jQuery);

$(document).ready(function () {
    $('input.json-input-type').trigger('change');
    $('input.background-input-type').trigger('change');
}).on('click', '#generate', function (e) {
    e.preventDefault();
    let $this = $(this),
        form = $this.closest('form'),
        url = form.attr('action'),
        data = form.serializeWithFiles();

    $.ajax({
        method:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data:data,
        processData: false,
        contentType: false,
        cache: false,
    }).done(function (response) {
        $('div#list').html(response.html);
        $('ul.list').not('.child').attr("style", response.background);
    }).fail(error => {
        if (error.status === 422) {
            let response = JSON.parse(error.responseText),
                errors = response.errors;

            form.find('input[type="text"], input[type="file"], input[type="number"], textarea').each(function (index, input) {
                let input_name = $(input).attr('name'),
                    exist = $(input).closest('div.form-item').find('.invalid-feedback');


                console.log(errors);
                if(input_name in errors){
                    $(input).addClass('is-invalid');
                    let error = errors[input_name];
                    if (exist.length < 1) {
                        $(input).closest('.form-item').append($(`<div class="invalid-feedback d-block">${error}</div>`));
                    } else {
                        $(`input[name="${input_name}"]`).parent().find('.invalid-feedback').html(error);
                    }
                }else {
                    $(input).removeClass('is-invalid');
                    if (exist.length) {
                        $(exist).removeClass('d-block').addClass('d-none')
                    }
                }
            })
        }
    });
}).on('change','input.json-input-type', function () {
    let type = $('input.json-input-type:checked').val();
    loadInputs('json', type)
}).on('change','input.background-input-type', function () {
    let type = $('input.background-input-type:checked').val();
    loadInputs('background', type)
}).on('click','p',function () {
    let child = $(this).next();
    if (child.hasClass('d-none')){
        child.removeClass('d-none').addClass('d-block');
    } else if (child.hasClass('d-block')){
        child.removeClass('d-block').addClass('d-none');
    }
});

function loadInputs(property,type) {
    let url = $('form#generate-list').data('load-inputs-url');
    $.ajax({
        method:"POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        data:{
            property: property,
            type:type
        },
    }).done(function (response) {
        if (response.success === true){
            $('#' + property + '-input-row').html(response.input);
        }
    }).fail(function (response) {

    })
}
