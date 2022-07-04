<section class="cle-section-login" style="height:100%">
    <div class="container h-100 text-dark">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col col-sm-7 col-md-7 col-lg-6 col-xl-4">
                <div class="card cle-card-shadow">
                    <div class="card-body">
                        <div class="cle-logo-app mb-2 d-flex">
                            <img src="./assets/img/administracao/logo/logo-bg-white.png" alt="funeraria">
                        </div>
                        <form name="cle-form-login" id="cle-form-login" method="post">
                            <div class="field">
                                <div class="control-form mb-4">
                                    <input type="text" name="endereco_electronico" id="endereco_electronico" placeholder="Endereço electrônico" required>
                                </div>
                            </div>
                            <div class="control-form mb-1">
                                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                            </div>
                            <small class="text-center d-block"><a href="<?=$url?>recuperar">Esqueci-me da senha</a></small>
                            <div class="mt-2" id="info"></div>
                            <div class="d-flex flex-column mt-3">
                                <div class="mx-4 btn-group">
                                    <button type="submit" id="cle" class="cle-btn-rounded btn btn-success">Continuar</button>
                                    <a href="<?=$url?>registar" class="cle-btn-rounded btn btn-primary">Registar</a>
                                </div>
                                <p class="text-center mt-3 mb-3">- ou -</p>
                                <a class="cle-btn-rounded mx-4 btn btn-light"><i class="gg-google"></i>Google</a>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="my-2 cc-back"><i class="gg-arrow-left"></i> Voltar</p>
            </div>
        </div>
    </div>
</section>