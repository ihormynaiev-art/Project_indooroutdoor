import $ from 'jquery';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    let managedFiles = [];
    $('#category').on('change', function() {
        $.ajax({
            url: '/categories/subcategories',
            type: 'GET',
            data: { categoriesIds : $(this).val() },
            dataType: 'json',
            success: function(response) {
                $('#sub-category').empty();
                $('#sub-category').append('<option value="">Select a subcategory</option>');
                $.each(response.data, function(key, value) {
                    $('#sub-category').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
            }
        });
    });

    $('#upload-btn').on('click', function (){
        $('#documents').click();
    })

    $('#documents').on('change', function() {
        const newFiles = Array.from($(this)[0].files);

        newFiles.forEach(file => {
            if (!managedFiles.some(existingFile => existingFile.name === file.name)) {
                managedFiles.push(file);
            }
        });

        $(".documents-preview").empty();

        managedFiles.forEach(file => {
            let reader = new FileReader();

            reader.onload = function(e) {
                let previewImg = '../assets/img/file-icon.png';

                if (file.type.startsWith('image/')) {
                    previewImg = e.target.result;
                }

                let html = `
                    <div class="col-md-4 col-sm-6" id="document-preview">
                        <img src="${previewImg}" alt="Service Image">
                        <span class="d-flex justify-content-center mb-2">${file.name.slice(0,15) }</span>
                        <a href="javascript:void(0);" data-name="${file.name}" class="remove-document"><i class="feather-trash-2"></i></a>
                    </div>
                `;
                $(".documents-preview").append(html);
            };

            reader.readAsDataURL(file);
        });
    });

    $(document).on("click", ".remove-document", function() {
        const fileNameToRemove = $(this).data('name');

        managedFiles = managedFiles.filter(file => file.name.toLowerCase() !== fileNameToRemove.toLowerCase());

        $(this).parent().remove();
    });

    $('#form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        formData.delete('documents[]');

        managedFiles.forEach(file => {
            formData.append('documents[]', file);
        });

        $('.text-danger').html('');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                Swal.fire({
                    title: "Your Request Has Been Submitted!",
                    html: "Your request is being sent to qualified contractors who specialize in exactly what you need. They will be contacting you shortly by your preferred method. <br><br> Sit back and relax — when they compete for your project, you win!",
                    icon: 'success',
                    animation: false,
                })
                $('#form').trigger('reset');
                $('.select').val(null).trigger('change');
                $('.documents-preview div').each(function() {
                    $(this).remove();
                });
                managedFiles = [];
                $('#request-quote').modal('hide');
                grecaptcha.reset();
            },
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.errors;
                    $('.text-danger').html('');

                    var fileErrorDisplayed = false;

                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            if (key.startsWith('documents.')) {
                                if (!fileErrorDisplayed) {
                                    $('#documents-error').html(errors[key][0]);
                                    fileErrorDisplayed = true;
                                }
                            } else {
                                $('#' + key + '-error').html(errors[key][0]);
                            }
                        }
                    }

                    grecaptcha.reset();
                }
            }
        });
    });
});
