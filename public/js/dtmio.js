let año = (new Date).getFullYear();
    let mes = (new Date).getMonth() + 1;
    let start = moment('' + año + '-' + mes + '').startOf('month');
    let end = moment('' + año + '-' + mes + '').endOf('month');
    let label = '';

    $(document).ready(function() {
        var DataTable = $('#DataTable').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            responsive: "true",
            dom: "Bfrtilp",
            buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i>',
                    tittleAttr: 'Exportar a Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i>',
                    tittleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i>',
                    tittleAttr: 'Imprimir',
                    className: 'btn btn-info'
                },
                {
                    extend: 'copy',
                    text: '<i class="fas fa-copy"></i>',
                    tittleAttr: 'Copiar en portapapeles',
                    className: 'btn btn-success'
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fas fa-file-csv"></i>',
                    tittleAttr: 'Exportar a CSV',
                    className: 'btn btn-danger'
                },
            ]
        });

        let año = (new Date).getFullYear();
        let mes = (new Date).getMonth() + 1;
        let start = moment('' + año + '-' + mes + '').startOf('month');
        let end = moment('' + año + '-' + mes + '').endOf('month');
        let label = '';

        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'YYYY/MM/DD'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'Hoy': [moment(), moment()],
                    'YTD': [moment().subtract(1, 'days').startOf('year'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                }
            },
            function(start, end, label) {
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('YYYY/MM/DD') + ' - ' + end.format(
                        'YYYY/MM/DD'));
                    minDateFilter = start;
                    maxDateFilter = end;
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        var date = Date.parse(data[0]);
                        if (
                            (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
                            (isNaN(minDateFilter) && date <= maxDateFilter) ||
                            (minDateFilter <= date && isNaN(maxDateFilter)) ||
                            (minDateFilter <= date && date <= maxDateFilter)
                        ) {
                            return true;
                        }
                        return false;
                    });
                    DataTable.draw();
                }
            });



        function isDate(val) {
            return Date.parse(val);
        }

        function IncDecMonth(Action) {
            if (!isDate(start)) {
                start = moment().startOf('month');
            }
            if (Action == 'Inc') {
                start = moment(start).add(0, 'month').startOf('month');
                end = moment(start).endOf('month')
            } else {
                start = moment(start).subtract(0, 'month').startOf('month');
                end = moment(start).endOf('month')
            }
            if (isDate(start)) {
                $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
            }
            minDateFilter = start;
            maxDateFilter = end;
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var date = Date.parse(data[0]);
                if (
                    (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
                    (isNaN(minDateFilter) && date <= maxDateFilter) ||
                    (minDateFilter <= date && isNaN(maxDateFilter)) ||
                    (minDateFilter <= date && date <= maxDateFilter)
                ) {
                    return true;
                }
                return false;
            });
            DataTable.draw();
        }

        IncDecMonth();
    });
