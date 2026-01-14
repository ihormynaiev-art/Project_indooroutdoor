var jsonDataUrl = '../public/assets/json/device-management.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {

        if ($.fn.DataTable.isDataTable('#device-management-data')) {
            $('#device-management-data').DataTable().destroy();
        }
        var table = $('#device-management-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'Device' },
                { data: 'Date' },
                { data: 'IPAddress' },
                { data: 'Location' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <span class="badge-danger">${data.Status}</span>`;
                        return imageHtml;
                    }
                },
            ],
            paging: true,
            searching: false,
            info: false,
            dom: '<"custom-datatable"t><"custom-datatable1"ilp>', // Customize the DataTable layout
            language: {
                paginate: {
                    first: '',
                    last: '',
                    next: '',
                    previous: ''
                },
                info: 'Showing _START_ - _END_ of _TOTAL_ items', // Customize the show info text
                infoFiltered: '', // Remove filtered info
                infoEmpty: '', // Remove empty info
            },
            // dom: '<"top"i>rt<"bottom"lp>',
            // scrollX: false,
            // scrollY: false
            // dom: '<"top"if>rt<"bottom"lp>'

        });
    })
    .catch(error => {
        console.error('Error:', error);
    });