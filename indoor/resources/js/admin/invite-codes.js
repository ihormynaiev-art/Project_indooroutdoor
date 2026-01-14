if ($.fn.dataTable.isDataTable('#invite-codes-data')) {
    table = $('#invite-codes-data').DataTable();
} else {
    var table = $('#invite-codes-data').DataTable({
        ordering: true,
        order: [3, 'desc'],
        ajax: '/admin/invite-codes',
        columns: [
            {
                data: 'code',
                render: function (data, type, row) {
                    return `<code style="font-size: 14px; letter-spacing: 1px;">${data}</code>`;
                }
            },
            {
                data: 'plan',
                render: function (data, type, row) {
                    if (data) {
                        let badgeClass = data.name === 'premium' ? 'bg-primary' : 'bg-secondary';
                        return `<span class="badge ${badgeClass}">${data.display_name}</span>`;
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
            {
                data: 'status',
                render: function (data, type, row) {
                    return data;
                }
            },
            { data: 'created_at' },
            { data: 'expires_at' },
            { data: 'used_at' },
            {
                data: 'used_by_provider',
                render: function (data, type, row) {
                    if (data && data.user) {
                        return `<a href="/admin/providerDetail/${data.user.id}" class="text-primary">${data.user.name}</a>`;
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    let baseUrl = window.location.origin;
                    let registrationUrl = `${baseUrl}/provider-registration?code=${row.code}`;

                    let copyButton = `<a class="table-copy mx-1" href="javascript:void(0);" data-url="${registrationUrl}" title="Copy registration link">
                        <i class="fa-solid fa-copy"></i><span>Copy</span>
                    </a>`;

                    let deleteButton = '';
                    if (!row.is_used) {
                        deleteButton = `<a class="table-delete" href="javascript:void(0);" data-id="${data}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>`;
                    }
                    return `<div class="action-language">${copyButton}${deleteButton}</div>`;
                }
            }
        ],
        paging: true,
        searching: true,
        info: true,
        dom: 'rtip',
        language: {
            paginate: {
                first: '',
                last: '',
                next: '',
                previous: ''
            },
            info: 'Showing _START_ - _END_ of _TOTAL_ items',
            infoFiltered: '',
            infoEmpty: '',
        },
    });
}

// Search filter for code column
$(document).ready(function () {
    $('#search').on('keyup change', function () {
        table.column(0).search(this.value).draw();
    });
});

// Generate random code
$('#generate-code-btn').on('click', function () {
    let code = generateRandomCode(8);
    let input = $('#code');
    input.val(code);

    // Mark as valid since generated codes are always valid
    input.removeClass('is-invalid').addClass('is-valid');
    input.closest('.input-group').find('.invalid-feedback').text('');
});

// Auto uppercase code input with real-time validation
$('#code').on('input', function () {
    let input = $(this);
    let value = this.value.toUpperCase();
    this.value = value;

    // Get the invalid feedback element
    let feedback = input.closest('.input-group').find('.invalid-feedback');

    // Clear previous validation state
    input.removeClass('is-invalid is-valid');
    feedback.text('');

    // Skip validation if field is empty
    if (value.length === 0) {
        return;
    }

    // Validate: only uppercase letters and numbers allowed
    const validPattern = /^[A-Z0-9]+$/;

    if (!validPattern.test(value)) {
        input.addClass('is-invalid');
        feedback.text('Code must contain only uppercase letters and numbers.');
    } else if (value.length > 20) {
        input.addClass('is-invalid');
        feedback.text('Code must not exceed 20 characters.');
    } else {
        input.addClass('is-valid');
    }
});

function generateRandomCode(length) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return result;
}

// Create code form submission
$('#create-code-form').on('submit', function (event) {
    event.preventDefault();
    var form = $(this);
    var formData = form.serialize();

    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');

    $.ajax({
        url: '/admin/invite-codes',
        method: 'POST',
        data: formData,
        success: function (response) {
            if (response.status === 'success') {
                // Hide create modal
                $('#create-code-modal').modal('hide');

                // Reset form
                form[0].reset();

                // Build registration URL
                let baseUrl = window.location.origin;
                let registrationUrl = `${baseUrl}/provider-registration?code=${response.code}`;
                $('#registration-url').text(registrationUrl);

                // Show success modal with registration URL
                $('#code-success-modal').modal('show');

                // Reload table
                table.ajax.reload();
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                for (let field in errors) {
                    let input = $(`#${field}`);
                    input.addClass('is-invalid');

                    // Find the feedback element - could be a sibling or inside input-group
                    let feedback = input.siblings('.invalid-feedback');
                    if (feedback.length === 0) {
                        feedback = input.closest('.input-group').find('.invalid-feedback');
                    }
                    feedback.text(errors[field][0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while creating the code.',
                });
            }
        }
    });
});

// Copy registration link to clipboard
$('#copy-link-btn').on('click', function () {
    let url = $('#registration-url').text();
    navigator.clipboard.writeText(url).then(function () {
        let btn = $('#copy-link-btn');
        let originalHtml = btn.html();
        btn.html('<i class="fa fa-check me-2"></i>Copied!');
        btn.removeClass('btn-primary').addClass('btn-success');

        setTimeout(function () {
            btn.html(originalHtml);
            btn.removeClass('btn-success').addClass('btn-primary');
        }, 2000);
    }, function (err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to copy link to clipboard.',
        });
    });
});

// Copy registration link from table
$(document).on("click", ".table-resposnive .table-copy", function () {
    let url = $(this).data('url');
    let btn = $(this);

    navigator.clipboard.writeText(url).then(function () {
        Swal.fire({
            toast: true,
            icon: 'success',
            title: 'Registration link copied to clipboard',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    }, function (err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to copy link to clipboard.',
        });
    });
});

// Delete code
$(document).on("click", ".table-resposnive .table-delete", function () {
    let id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/invite-codes/${id}`,
                method: 'DELETE',
                data: {
                    _token: $('#token').val()
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Code deleted successfully',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        table.ajax.reload();
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the code.',
                    });
                }
            });
        }
    });
});

// Reset form when modal is closed
$('#create-code-modal').on('hidden.bs.modal', function () {
    $('#create-code-form')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.is-valid').removeClass('is-valid');
    $('.invalid-feedback').text('');
});
