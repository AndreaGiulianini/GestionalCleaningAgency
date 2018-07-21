<!DOCTYPE html>
<html lang="en">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/libs/head.php'; ?>
<!-- Main CSS -->
<link rel="stylesheet" href="/assets/css/app.css" type="text/css"/>
<style>
    .text-login {
        margin: 20px 0;
        transition: opacity .5s;
        opacity: 0;
    }
</style>
<body class="mai-splash-screen">
<div class="mai-wrapper mai-login">
    <div class="main-content container">
        <div class="splash-container row">
            <div class="col-sm-6 user-message"><span class="splash-message text-right">Ben Tornato!<br> sull'area riservata<br> A clienti e operatori!</span>
            </div>
            <div class="col-sm-6 form-message"><img src="/assets/img/loghi/db.png" alt="logo" width="169" height="auto"
                                                    class="logo-img mb-4"><span
                        class="splash-description text-center mt-5 mb-5">Inserisci le tue credenziali</span>
                <form id="login">
                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon"><i class="icon s7-user"></i></span>
                            <input id="usr" type="text" placeholder="Username" autocomplete="off" class="form-control"
                                   style="padding:5px">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group"><span class="input-group-addon"><i class="icon s7-lock"></i></span>
                            <input id="pwd" type="password" placeholder="Password" class="form-control"
                                   style="padding:5px">
                        </div>
                    </div>
                    <p id="loginResult" class="text-danger text-login">Username o Password errati.</p>
                    <div class="form-group login-submit">
                        <button data-dismiss="modal" type="submit" class="btn btn-lg btn-primary btn-block">Login
                        </button>
                    </div>
                    <div class="form-group row login-tools">
                        <div class="col-6 login-remember">
                            <label class="custom-control custom-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input"><span
                                        class="custom-control-indicator"></span><span
                                        class="custom-control-description">Ricordami</span>
                            </label>
                        </div>
                    </div>
                </form>
                <div class="out-links"><a href="#">GestionalePulizie SRL</a></div>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/libs/head-js.php'; ?>
<script type="text/javascript">
    $(document).ready(function () {
        //initialize the javascript
        App.init();

        $("#login").submit(function () {
            var par = {};
            $(this).find('input').each(function (index, item) {
                par[$(item).attr('id')] = $(item).val();
            });
            $.post("auth/login.php", par, function (res) {
                if (res !== "") {
                    window.location.replace(res);
                } else {
                    $("#loginResult").css({opacity: 1});
                    setTimeout(function () {
                        $("#loginResult").css({opacity: 0});
                    }, 2000);
                }
            });
            return false;
        });
    });

</script>
</body>
</html>
