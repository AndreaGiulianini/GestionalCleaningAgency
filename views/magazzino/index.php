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
<?php require($_SERVER['DOCUMENT_ROOT'] . '/views/default/navbar.php'); ?>
<div class="mai-wrapper">
    <div class="main-content container">
        <form>
            <div class="row">
                <div class="col-sm-12">
                    <select id="product" name="prodotto" class="form-control custom-select" required="true">
                        <option value="NP">Nuovo Prodotto</option>
                        <?php foreach ($prodotti as $value) { ?>
                            <option value="<?php echo $value["id"] ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label class="col-form-label">Nome Prodotto</label>
                    <input name="nome" type="text" placeholder="Nome Prodotto" class="form-control form-control-danger"
                           required>
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">Magazzino/Cantiere</label>
                    <select name="magazzino" class="form-control custom-select" required="true">
                        <option value="0" selected="" disabled="">-- Seleziona un'opzione --</option>
                        <?php foreach ($magazzini as $value) { ?>
                            <option value="<?php echo $value["id"] ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">Categoria</label>
                    <select name="categoria" class="form-control custom-select" required="true">
                        <option id="cat" value="0" selected="" disabled="">-- Seleziona un'opzione --</option>
                        <?php foreach ($categorie as $value) { ?>
                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-4">
                    <label class="col-form-label">Prezzo Acquisto</label>
                    <input name="pAcq" type="text" placeholder="Prezzo Acquisto"
                           class="form-control form-control-danger">
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">Prezzo Vendita</label>
                    <input name="pVen" type="text" placeholder="Prezzo Vendita"
                           class="form-control form-control-danger">
                </div>
                <div class="col-sm-4">
                    <label class="col-form-label">Quantità <span id="label"></span></label>
                    <input name="count" type="text" placeholder="Quantità" class="form-control form-control-danger"
                           required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-1 offset-sm-11">
                    <button type="submit" class="btn btn-primary">Inserisci</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
        $("form").submit(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/insertProducts.php",
                data: $(this).serialize(),
            })
                .done(function (msg) {
                    if (msg == "OK") {
                        $.gritter.add({
                            title: 'Successo',
                            text: 'Inserimento avvenuto con successo',
                            class_name: 'gritter-color success'
                        });
                        $("input").val("");
                        $("select").val(0);
                        $("select[name='prodotto']").val("NP");
                    } else {
                        $.gritter.add({
                            title: 'Errore',
                            text: 'Risposta dal server non valida.',
                            class_name: 'gritter-color danger'
                        });
                    }
                });
            return false;
        });

        var quant = 0;
        $("select[name='magazzino']").change(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/selectQuantity.php",
                data: {
                    id: $("#product").val(),
                    mag: $(this).val(),
                }
            })
                .done(function (msg) {
                    quant = msg;
                    $("#label").html(msg);

                });
        });

        $("input[name='count'").keyup(function () {
            var tmp = parseFloat(quant) + parseFloat($(this).val());
            $("#label").html(tmp);
        });

        $("#product").change(function () {
            if ($(this).val() == "NP") {
                $("select[name='categoria']").prop('disabled', false);
                $("input[name='pVen']").prop('disabled', false);
                $("input[name='pAcq']").prop('disabled', false);
                $("input[name='nome']").prop('disabled', false);
                $("#cat").text("-- Seleziona un'opzione --");
            } else {
                $("select[name='categoria']").prop('disabled', true);
                $("input[name='pVen']").prop('disabled', true);
                $("input[name='pAcq']").prop('disabled', true);
                $("input[name='nome']").prop('disabled', true);
                $.ajax({
                    method: "POST",
                    url: "/views/magazzino/selectDataAna.php",
                    data: {
                        id: $("#product").val(),
                    }
                })
                    .done(function (msg) {
                        var res = JSON.parse(msg);
                        $("input[name='nome']").val(res[0].nome);
                        $("input[name='pAcq']").val(res[0].prezzo_acquisto);
                        $("input[name='pVen']").val(res[0].prezzo_vendita);
                        $("#cat").text(res[0].cnome);
                    });
            }
        });
    });
</script>
</body>
</html>
