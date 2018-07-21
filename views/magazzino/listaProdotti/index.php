<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Lista Prodotti</div>
                    <div class="panel-body" style="padding-bottom: 20px;">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Prezzo Vendita</th>
                                <th>Prezzo Acquisto</th>
                                <th>Nome Categoria</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($prodotti as $value) { ?>
                                <tr>
                                    <td><?php echo $value['id']; ?></td>
                                    <td><?php echo $value['ana_nome']; ?></td>
                                    <td><?php echo $value['prezzo_vendita'] . "\xE2\x82\xAc"; ?></td>
                                    <td><?php echo $value['prezzo_acquisto'] . "\xE2\x82\xAc"; ?></td>
                                    <td><?php echo $value['categoria_nome']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="md-default" tabindex="-1" role="dialog" class="modal fade" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="col-form-label">Modificare Prodotto</label>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col-sm-12">
                                <label class="col-form-label">Nome</label>
                                <input id="name" type="text" class="form-control form-control-danger">
                            </div>
                            <div class="col-sm-12">
                                <label class="col-form-label">Prezzo Acquisto</label>
                                <input id="pVen" type="text" class="form-control form-control-danger">
                            </div>
                            <div class="col-sm-12">
                                <label class="col-form-label">PrezzoVendita</label>
                                <input id="pAcq" type="text" class="form-control form-control-danger">
                            </div>
                            <div class="col-sm-12">
                                <label class="col-form-label">Categoria</label>
                                <select id="idCat" class="form-control form-control-danger">
                                    <?php foreach ($categoria as $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <div class="mt-6">
                                    <button id="bModPro" type="button" data-dismiss="modal"
                                            class="btn btn-sm btn-space btn-primary">Conferma
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        //initialize the javascript
        App.init();
        var table = $(".table").DataTable(
            {
                buttons: [
                    {
                        text: 'Modifica Prodotto',
                        action: function (e, dt, node, config) {
                            if ($('.table .selected').length > 0) {
                                $('#md-default').modal();
                            } else {
                                $.gritter.add({
                                    title: 'Attenzione',
                                    text: 'Selezionare una riga',
                                    class_name: 'gritter-color warning'
                                });
                            }
                        },
                        className: 'btn-secondary'
                    },
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
        });
        $("#bModPro").click(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/listaProdotti/modProduct.php",
                data: {
                    id: table.row('.selected').data()[0],
                    nome: $("#name").val(),
                    pVen: $("#pVen").val(),
                    pAcq: $("#pAcq").val(),
                    idCat: $("#idCat").val(),
                },
            }).done(function (msg) {
                location.reload();
            });
        });
    });
</script>
</body>
</html>
