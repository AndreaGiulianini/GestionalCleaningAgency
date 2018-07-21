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
                <div class="col-sm-6">
                    <label class="col-sm-6 col-form-label">Magazzino di Spedizione</label>
                    <select name="source" class="form-control custom-select" required="true">
                        <option value="0" selected="" disabled="">-- Seleziona un'opzione --</option>
                        <?php foreach ($magazzini as $value) { ?>
                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class="col-sm-6 col-form-label">Magazzino di Destinazione</label>
                    <select name="destination" class="form-control custom-select" required="true">
                        <option value="0" selected="" disabled="">-- Seleziona un'opzione --</option>
                        <?php foreach ($magazzini as $value) { ?>
                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["nome"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-8">
                            <label class="col-form-label">Data Scadenza</label>
                            <input name="dataScadenza" type="text" class="form-control datepicker">
                        </div>
                        <div class="col-sm-2">
                            <label class="col-form-label">Bolla con Prezzo?</label>
                            <input id="pBolla" type="checkbox" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <label class="col-form-label">Vendita?</label>
                            <input id="tBolla" type="checkbox" class="form-control">
                        </div>

                        <label class="col-sm-12 col-form-label">Causale</label>
                        <div id="repeatCau" class="col-sm-9">
                            <select name="causale0" class="form-control custom-select" required="true">
                                <option value="0" selected="" disabled="">-- Seleziona un'opzione --</option>
                                <?php foreach ($causali as $value) { ?>
                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["causale"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div id="prependCau" class="col-sm-1">
                            <button id="bRepeatCau" type="button" class="btn btn-primary">+</button>
                        </div>
                        <div class="col-sm-1">
                            <button id="bDeleteCau" type="button" class="btn btn-primary">-</button>
                        </div>
                        <input name="countCau" style="display:none" value="1">
                    </div>
                </div>
            </div>
            <div id="product" style="display:none">
                <div class="row">
                    <label class="col-sm-5 col-form-label">Nome Prodotto - Quantità</label>
                    <label class="col-sm-5 col-form-label">Quantità da spostare</label>
                </div>
                <div class="row">
                    <div id="repeat" class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-6">
                                <select name="prod0" class="form-control custom-select" required="true">
                                    <option value="0" selected="" disabled="">-- Seleziona un prodotto --</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input name="quant0" type="text" placeholder="Quantità"
                                       class="form-control form-control-danger" required="true">
                            </div>
                        </div>
                    </div>
                    <div id="prepend" class="col-sm-1">
                        <button id="bRepeat" type="button" class="btn btn-primary">+</button>
                    </div>
                    <div class="col-sm-1">
                        <button id="bDelete" type="button" class="btn btn-primary">-</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-1 offset-sm-10">
                        <button type="submit" class="btn btn-primary">Inserisci</button>
                    </div>
                    <input name="count" style="display:none" value="1">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        //initialize the javascript
        App.init();
        $('.datepicker').datepicker();
        //+ e - per i prodotti
        var i = 1;
        $("#bRepeat").click(function () {
            var repeat = $("#repeat").eq(0).clone();
            repeat.addClass("canc");
            repeat.find('select').each(function () {
                this.name = this.name.replace('prod0', 'prod' + i + '');
            });
            repeat.find('input').each(function () {
                this.name = this.name.replace('quant0', 'quant' + i + '');
            });
            $('#repeat').after(repeat);
            i++;
            $("input[name='count']").val(i);
        });

        $("#bDelete").click(function () {
            if (i != 0) {
                $(".canc")[0].remove();
                i--;
                $("input[name='count']").val(i);
            }
        });

        //+ e - causali
        var k = 1;
        $("#bRepeatCau").click(function () {
            var repeat = $("#repeatCau").eq(0).clone();
            repeat.addClass("cancCau");
            repeat.find('select').each(function () {
                this.name = this.name.replace('causale0', 'causale' + k);
            });
            $('#repeatCau').after(repeat);
            k++;
            $("input[name='countCau']").val(k);
        });

        $("#bDeleteCau").click(function () {
            if (k != 0) {
                $(".cancCau")[0].remove();
                k--;
                $("input[name='countCau']").val(k);
            }
        });

        //Sul change della provenienza
        $("select[name='source']").change(function () {
            $(".removable").remove();
            $(".canc").remove();
            i = 1;
            $.ajax({
                method: "POST",
                url: "/views/magazzino/spedizioni/productFromMag.php",
                data: {
                    source: $(this).val(),
                },
            })
                .done(function (msg) {
                    var json = JSON.parse(msg);
                    $.each(json, function (i, item) {
                        $("select[name='prod0']").append("<option class='removable' value=" + item.id + ">" + item.nome + " Qtà: " + item.quant + "</option>");
                    });
                    $("#product").css("display", "block");
                });
        });

        $("form").submit(function () {
            $.ajax({
                method: "POST",
                url: "/views/magazzino/spedizioni/destinationSpedition.php",
                data: $(this).serialize(),
            })
                .done(function (msg) {
                    if (msg != "KO") {
                        $.gritter.add({
                            title: 'Successo',
                            text: 'Inserimento avvenuto con successo',
                            class_name: 'gritter-color success'
                        });
                        $("input").val("");

                        if ($("#pBolla").is(":checked") && $("#tBolla").is(":checked")) {
                            window.location.href = '/gestione-magazzino/pdfBolla.php?idSped=' + msg + "&prezzo=con&type=ven";
                        }
                        if ($("#pBolla").is(":checked")) {
                            window.location.href = '/gestione-magazzino/pdfBolla.php?idSped=' + msg + "&prezzo=con&type=acq";
                        } else {
                            window.location.href = '/gestione-magazzino/pdfBolla.php?idSped=' + msg + "&prezzo=senza&type=none";
                        }
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
    });
</script>
</body>
</html>
