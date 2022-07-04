<?php
    $attr = ($exe[0] != '?q') ? $_ROL : $exe[1] ;
?>
<div class="page-top-info">
    <div class="container">
        <h4>P&aacute;gina de Categoria</h4>
        <div class="site-pagination">
            <a href="<?=$url?>">Home</a> /
            <a id="shop-val" data-shop="<?=base64_encode($_VAL)?>" href="">Shop</a> /
        </div>
    </div>
</div>
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="filter-widget mb-0">
                    <h4>Filtrar por</h4>
                    <div class="price-range-wrap">
                        <h4 class="fw-title">Pre&ccedil;o (MZN)</h4>
                        <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="10" data-max="270">
                            <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;">
                            </span>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;">
                            </span>
                        </div>
                        <div class="range-slider">
                            <div class="price-input">
                                <input type="text" id="minamount">
                                <input type="text" id="maxamount" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-widget mb-0">
						<h4 class="fw-title">Cor</h4>
						<div class="fw-color-choose" id="cor">
                            <!-- Cor do(s) iten(s) -->
                        </div>
					</div>
					<div class="filter-widget mb-0">
						<h4 class="fw-title">Marca</h4>
						<ul class="brand" id="marca">
                            <!-- Marca do(s) item(s) -->
						</ul>
					</div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                <?= ($object->select_table($_TYPE."id = '".$_VAL."'") == 'transporte') ? '<div class="alert cle-alert"><i>* Ao selecionar uma viatura está incluso a taxa fixa diária por transporte de 1,800.00 MZN, caso queira ficar com o(s) transporte(s) por mais de 1 dia, defina no carrinho.</i></div>' : '' ;?>
                <div class="card-columns" id="item" data-tunel="<?=$_TYPE?>">
                    <!-- Item(s) -->
                </div>
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Item</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">×</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5">
                                        <div class="d-flex align-items-center h-100">
                                            <div id="owl-demo" class="owl-carousel owl-theme">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7">
                                        <h5 class="card-title font-weight-bold mt-4">Informa&ccedil;&otilde;es</h5>
                                        <hr/>
                                        <p class="info-modal-for">Marca: <b class="info-modal-provider"></b></p>
                                        <p class="text-justify info-modal-flower">Info here</p>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="cc-btn-category" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script language="javascript">
    var _attr = decodeURIComponent("<?php print $attr; ?>");
    var _list = document.getElementsByClassName('site-pagination');

    var newItem = document.createElement("a");
    var textnode = document.createTextNode(_attr);
    newItem.appendChild(textnode);
    document.getElementById('shop-val').innerHTML = _attr;
</script>