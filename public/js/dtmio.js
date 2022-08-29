function todomidata(hotel)
{
    let año = (new Date).getFullYear();
    let mes = (new Date).getMonth() + 1;
    let start = moment('' + año + '-' + mes + '').startOf('month');
    let end = moment('' + año + '-' + mes + '').endOf('month');
    let label = '';
    var logo = 'data:image/png;base64,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';
    var firma = 'data:image/jpeg;base64,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';

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
                    pageSize: 'LEGAL',
                    orientation: 'landscape',
                    header: true,
                    text: '<i class="fas fa-file-pdf"></i>',
                    tittleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    customize: function(doc) {
                        doc.styles.tableHeader = {
                            fillColor: '#ffe259'
                        }
                        doc.content.splice(0, 0, {
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            text: new Date().toLocaleString(),
                            fontSize: '10'
                        });
                        doc.content.splice(0, 0, {
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            image: logo
                        });

                        doc.content.splice(1, 0, {
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            text: hotel,
                            fontSize: '20'
                        });

                        doc.content.push({
                            image: firma,
                            margin: [450, -0, 20, 20],
                            alignment: 'center'
                        });
                    }
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
}
