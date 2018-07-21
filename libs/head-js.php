<script src="/assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="/assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/lib/tether/js/tether.min.js" type="text/javascript"></script>
<script src="/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="/assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/app.js" type="text/javascript"></script>
<!-- GRITTER NOTIFICATIONS -->
<script src="/assets/lib/jquery.gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- Data Tables -->
<script src="/assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>
<!-- Date Picker -->
<script src="/assets/lib/datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/js/datepicker.it.js" type="text/javascript"></script>
<script src="/assets/js/today.js" type="text/javascript"></script>
<!-- Nifty Modal -->
<script src="/assets/lib/jquery.niftymodals/dist/jquery.niftymodals.js" type="text/javascript"></script>
<!-- Parsley -->
<script src="/assets/lib/parsley/parsley.js" type="text/javascript"></script>
<script src="/assets/lib/parsley/i18n/it.js" type="text/javascript"></script>
<!-- Moment -->
<script src="/assets/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
<!-- Html2Canvas -->
<script src="/assets/js/html2canvas.min.js" type="text/javascript"></script>

<script> //Defaults
    //Default datepicker
    $.fn.datepicker.defaults.language = 'it';
    $.fn.datepicker.defaults.format = 'dd/mm/yyyy';
    $.fn.datepicker.defaults.todayHighlight = true;
    $.fn.datepicker.defaults.weekStart = '1';
    $.fn.datepicker.defaults.autoclose = true;

    //Default datatables
    $.extend(true, $.fn.dataTable.defaults, {
        dom: "<'row mai-datatable-header'<'col-sm-4'l><'col-sm-4 text-right'B><'col-sm-4'f>>" +
        "<'row mai-datatable-body'<'col-sm-12'tr>>" +
        "<'row mai-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
        language: {
            "url": "/assets/lib/datatables/dataTables.it.lang"
        }
    });

    //Default Nifty Modals
    $.fn.niftyModal('setDefaults', {
        overlaySelector: '.modal-overlay',
        contentSelector: '.modal-content',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
        classModalOpen: 'modal-open',
        classScrollbarMeasure: 'modal-scrollbar-measure',
        afterOpen: function () {
            $("html").addClass('mai-modal-open');
        },
        afterClose: function () {
            $("html").removeClass('mai-modal-open');
        }
    });
    window.Parsley.addValidator('minMaxIncluded',
        function (value, requirement) {
            var minMax = requirement.split('-');
            var date = moment(value, 'HH:mm'), min = moment(minMax[0], 'HH:mm'), max = moment(minMax[1], 'HH:mm');
            return !date.isBefore(min) && !date.isAfter(max) || !date.isAfter(max) || !date.isBefore(min);
        })
        .addMessage('it', 'minMaxIncluded', "L'orario deve essere compreso nel tempo dell'attività");
</script>
