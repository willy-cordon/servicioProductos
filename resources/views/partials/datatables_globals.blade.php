<input type="hidden" id="current_time">
<script>
    setInterval(function(){
        var newDate = new Date();
        $("#current_time").val(newDate.getTime());
    }, 1000);
    $(function() {
        let copyButtonTrans = '{{ trans('global.datatables.copy') }}';
        let csvButtonTrans = '{{ trans('global.datatables.csv') }}';
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}';
        let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}';
        let printButtonTrans = '{{ trans('global.datatables.print') }}';
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}';

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
            'es': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' });
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: languages['{{ app()->getLocale() }}']
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style:    'multi+shift',
                selector: 'td:first-child'
            },
            order: [],

            pageLength: 20,
            dom: '<"table-header" Bfr>t<"table-footer"lpi><"actions">',
            initComplete: () => {$(".datatable").css('visibility','visible'); setTimeout(function(){ $(".datatable-loader").fadeOut(); }, 1000);},
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-secondary',
                    text: copyButtonTrans,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function(data, row, column, node) {
                                export_data = $(node).data('export-data');
                                return  export_data !== undefined ? export_data : data ;
                            }
                        }
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-secondary',
                    text: csvButtonTrans,
                    filename: function(){return document.title.replace(' | ','-').replace(' ','_').toLocaleLowerCase()+'-' + $("#current_time").val()},
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function(data, row, column, node) {
                                export_data = $(node).data('export-data');
                                return  export_data !== undefined ? export_data : data ;
                            }
                        }
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-secondary',
                    text: excelButtonTrans,
                    filename: function(){return document.title.replace(' | ','-').replace(' ','_').toLocaleLowerCase()+'-' + $("#current_time").val()},
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function(data, row, column, node) {
                                export_data = $(node).data('export-data');
                                return  export_data !== undefined ? export_data : data ;
                            }
                        }
                    },
                },
                {
                    extend: 'pdf',
                    className: 'btn-secondary',
                    text: pdfButtonTrans,
                    filename: function(){return document.title.replace(' | ','-').replace(' ','_').toLocaleLowerCase()+'-' + $("#current_time").val()},
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function(data, row, column, node) {
                                export_data = $(node).data('export-data');
                                return  export_data !== undefined ? export_data : data ;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-secondary',
                    text: printButtonTrans,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)',
                        format: {
                            body: function(data, row, column, node) {
                                export_data = $(node).data('export-data');
                                return  export_data !== undefined ? export_data : data ;
                            }
                        }
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn-secondary',
                    text: colvisButtonTrans,
                    exportOptions: {
                        columns: ':visible:not(.not-export-col)'
                    }
                }
            ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';

    });
</script>
