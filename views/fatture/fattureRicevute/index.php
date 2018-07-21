<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
<!-- Wizard? -->
<link rel="stylesheet" type="text/css" href="/assets/lib/fuelux/css/wizard.css"/>
<link rel="stylesheet" type="text/css" href="/assets/lib/select2/css/select2.min.css"/>
<link rel="stylesheet" type="text/css" href="/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css"/>
<!-- Calendar -->
<link rel="stylesheet" type="text/css" href="/assets/lib/jquery.fullcalendar/fullcalendar.min.css"/>
<!-- Main CSS -->
<link rel="stylesheet" href="/assets/css/app.css" type="text/css"/>
<style>
    .timetable td {
        text-align: center;
    }
</style>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'; ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <form>
            <div class="row">
                <div class="col-sm-4">
                    <label>Data Scadenza
                    </label>
                    <input name="dataScadenza" type="text" class="form-control datepicker" value="" required="true"/>
                </div>
                <div class="col-sm-4">
                    <label>Pagata
                    </label>
                    <input name="pagata" type="checkbox" class="form-control" value="yes"/>
                </div>
                <div class="col-sm-4">
                    <label>Costo
                    </label>
                    <input name="costo" type="text" class="form-control" value="" required="true"/>
                </div>
                <div class="col-sm-12">
                    <label>Seleziona Cantiere Associato
                    </label>
                    <select name="cantiere" class="form-control custom-select" required="true">
                        <option value="0">Seleziona Cantiere
                        </option>
                        <?php foreach ($cantieri as $value) { ?>
                            <option value="<?php echo $value["id"] ?>">
                                <?php echo $value["nome"]; ?>
                            </option>
                            <?php
                        } ?>
                    </select>
                </div>
                <div class="col-sm-12">
                    <input name="url" type="hidden" value=""/>
                    <img id="profilePicPreview" src="" class="img-responsive img-profilo"
                         style="margin-top:10px; width:100%">
                    <input id="profilePic" type="file" style="display:none" required="true"/>
                    <label for="profilePic" style="margin-top:30px; width:100%" class="btn btn-secondary open-activity">
                        <i class="icon icon-left s7-pen">
                        </i> Carica Fattura
                    </label>
                </div>
                <div class="col-sm-6 offset-sm-3">
                    <button class="btn btn-primary btn-block">Salva
                    </button>
                </div>
            </div>
        </form>
        <br/>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Lista Fatture
                    </div>
                    <div class="panel-body" style="padding-bottom: 20px;">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Id
                                </th>
                                <th>Fattura
                                </th>
                                <th>Costo
                                </th>
                                <th>Pagata
                                </th>
                                <th>Data Scadenza
                                </th>
                                <th>Nome Magazzino
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($fatture as $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $value['url'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['costo'] . "\xE2\x82\xAc"; ?>
                                    </td>
                                    <td>
                                        <?php echo $value['pagata']; ?>
                                    </td>
                                    <td
                                        <?php echo $value['css']; ?>>
                                        <?php echo $value['dataScadenza']; ?>
                                    </td>
                                    <td>
                                        <?php echo $value['nome']; ?>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
            App.init();
            $('.datepicker').datepicker();
            $("#profilePicPreview").click(function () {
                    $("#profilePic").click();
                }
            );
            $("#profilePic").change(function () {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#profilePicPreview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                    var formData = new FormData();
                    formData.append('section', 'general');
                    formData.append('file', $(this)[0].files[0]);
                    $.ajax({
                            // Your server script to process the upload
                            url: '/views/fatture/fattureRicevute/uploadFatt.php',
                            type: 'POST',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (res) {
                                $('input[name="url"]').val("/uploads/fatture/" + res);
                            }
                        }
                    );
                }
            );
            $("form").submit(function () {
                    $.ajax({
                            url: '/views/fatture/fattureRicevute/uploadFattDB.php',
                            type: 'POST',
                            data: $(this).serialize(),
                        }
                    ).done(function (msg) {
                            console.log(msg);
                            if (msg == "OK") {
                                $.gritter.add({
                                        title: 'Successo',
                                        text: 'Inserimento avvenuto con successo',
                                        class_name: 'gritter-color success'
                                    }
                                );
                            }
                            else {
                                $.gritter.add({
                                        title: 'Errore',
                                        text: 'Controlla di aver inserito dei parametri corretti',
                                        class_name: 'gritter-color danger'
                                    }
                                );
                            }
                        }
                    );
                    return false;
                }
            );
            var table = $(".table").DataTable(
                {
                    buttons: [
                        {
                            text: 'Pdf',
                            action: function (e, dt, node, config) {
                                if ($('.table .selected').length > 0) {
                                    window.location.href = '/uploads/fatture/' + table.row('.selected').data()[1]
                                }
                                else {
                                    $.gritter.add({
                                            title: 'Attenzione',
                                            text: 'Selezionare una riga',
                                            class_name: 'gritter-color warning'
                                        }
                                    );
                                }
                            }
                            ,
                            className: 'btn-secondary'
                        }
                        ,
                        {
                            text: 'Da pagare',
                            action: function (e, dt, node, config) {
                                if ($('.table .selected').length > 0) {
                                    $.ajax({
                                            "url": "/views/fatture/fattureRicevute/modifyPayments.php",
                                            "data": {
                                                id: table.row('.selected').data()[0],
                                                pay: "false"
                                            }
                                            ,
                                            "success": function (res) {
                                                if (res == 'OK') {
                                                    $.gritter.add({
                                                            title: 'Successo',
                                                            text: "Dato Aggiornato",
                                                            class_name: 'gritter-color success'
                                                        }
                                                    );
                                                    table.cell(table.row('.selected').index(), 3).data("No").draw();
                                                }
                                                else {
                                                    $.gritter.add({
                                                            title: 'Errore',
                                                            text: "Dato non Aggiornato",
                                                            class_name: 'gritter-color danger'
                                                        }
                                                    );
                                                }
                                            }
                                        }
                                    );
                                }
                                else {
                                    $.gritter.add({
                                            title: 'Attenzione',
                                            text: 'Selezionare una riga',
                                            class_name: 'gritter-color warning'
                                        }
                                    );
                                }
                            }
                            ,
                            className: 'btn-secondary'
                        }
                        ,
                        {
                            text: 'Pagata',
                            action: function (e, dt, node, config) {
                                if ($('.table .selected').length > 0) {
                                    $.ajax({
                                            "url": "/views/fatture/fattureRicevute/modifyPayments.php",
                                            "data": {
                                                id: table.row('.selected').data()[0],
                                                pay: "true"
                                            }
                                            ,
                                            "success": function (res) {
                                                if (res == 'OK') {
                                                    $.gritter.add({
                                                            title: 'Successo',
                                                            text: "Dato Aggiornato",
                                                            class_name: 'gritter-color success'
                                                        }
                                                    );
                                                    table.cell(table.row('.selected').index(), 3).data("Si").draw();
                                                }
                                                else {
                                                    $.gritter.add({
                                                            title: 'Errore',
                                                            text: "Dato non Aggiornato",
                                                            class_name: 'gritter-color danger'
                                                        }
                                                    );
                                                }
                                            }
                                        }
                                    );
                                }
                                else {
                                    $.gritter.add({
                                            title: 'Attenzione',
                                            text: 'Selezionare una riga',
                                            class_name: 'gritter-color warning'
                                        }
                                    );
                                }
                            }
                            ,
                            className: 'btn-secondary'
                        }
                        ,
                    ]
                }
            );
            $('.table tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('selected')) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                }
            );
        }
    );
</script>
</body>
</html>
