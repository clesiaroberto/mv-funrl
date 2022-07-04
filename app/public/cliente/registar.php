<section class="cle-section-login" style="height:100%">
    <div class="container h-100 text-dark">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col col-sm-12 col-md-10 col-lg-8 col-xl-8">
                <div class="card cle-card-shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 col-md-9 col-sm-12">
                                <form id="cle-form-register" name="cle-form-register" method="POST">
                                    <div>
                                        <h3></h3>
                                        <section>
                                           <div class="row">
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="Primeiro nome" name="nome" id="nome" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="Apelido" name="apelido" id="apelido" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="date" placeholder="Nascimento" name="nascimento" id="nascimento" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>                

                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <select name="genero" id="genero" required>
                                                                <option disabled selected>Genero</option>
                                                                <option value="M">Masculino</option>
                                                                <option value="F">Feminino</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <select name="nacionalidade" id="nacionalidade" required>
                                                                <option disabled selected>Nacionalidade</option>
                                                                <?php
                                                                    foreach ($object->select('*', 'nacionalidade') as $value) {
                                                                        echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="Avenida ou Bairro" name="av_bairro" id="av_bairro" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-7">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="Rua" name="rua" id="rua" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="N&ordm; da casa" name="casa" id="casa" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <h3></h3>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="tel" placeholder="Contacto #1" name="contacto_1" id="contacto_1" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="tel" placeholder="Contacto #2" name="contacto_2" id="contacto_2" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="text" placeholder="Endereco electronico" name="endereco_electronico" id="endereco_electronico" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="field">
                                                        <div class="control-form mb-4">
                                                            <input type="password" placeholder="Senha" name="senha" id="senha" autocomplete="off" required>
                                                        </div>

                                                        <div class="control-form mb-4">
                                                            <input type="password" placeholder="Confirmar senha" name="confirmar" id="confirmar" autocomplete="off" required>
                                                        </div>
                                                    </div>                                     
                                                </div>
                                                <div id="info"></div>
                                            </div>
                                        </section>

                                        <h3></h3>
                                        <section>
                                            <div class="field mb-2">
                                                <div class="control-form">
                                                    <input type="checkbox" name="termo_uso" id="termo_uso" required/>
                                                    <label class="control-label" for="termos" style="margin-bottom: 0px;">Termos de Utiliza&ccedil;&atilde; e Pol&iacute;ticas de Privacidade.</label>
                                                </div>
                                            </div>
                                            <div class="field mb-2">
                                                <div class="control-form">
                                                    <input type="checkbox" name="termo_marketing" id="termo_marketing" required/>
                                                    <label class="control-label" for="termos" style="margin-bottom: 0px;">Aceito que os meus dados sejam utilizados para ac&ccedil;&otilde;es de marketing.</label>
                                                </div>
                                            </div>
                                            <div class="field mb-4">
                                                <div class="control-form">
                                                    <input type="checkbox" name="termo_notificacao" id="termo_notificacao" required/>
                                                    <label class="control-label" for="termos" style="margin-bottom: 0px;">Aceito receber comunica&ccedil;&atilde;o via email. Receber informa&ccedil;&atilde;o das campanhas, produtos e servi&ccedil;os atrav&eacute;s de e-mail.</label>
                                                </div>
                                            </div>    
                                        </section>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-4 col-md-3">
                                <div class="d-flex h-100 align-items-center">
                                    <img src="<?=$url?>assets/img/administracao/logo/logo-bg-white.png" id="logo" width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="my-2 cc-back"><i class="gg-arrow-left"></i> Voltar</p>
            </div>
        </div>
    </div>
</section>