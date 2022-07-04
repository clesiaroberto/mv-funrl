<div class="page-top-info">
    <div class="container">
        <h4>Meu carrinho</h4>
        <div class="site-pagination">
            <a href="<?=$url?>">Home</a> /
            <a id="check-out" href="">check-out</a> /
        </div>
    </div>
</div>
<section class="checkout-section spad container py-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 order-2 order-lg-1">
				<form class="checkout-form" name="cle-form-checkOut" id="cle-form-checkOut">
					<div class="cf-title">Endere&ccedil;o de Cobran&ccedil;a</div>
					<div class="row">
						<div class="col-md-12">
							<div class="option-group d-flex justify-content-center">
								<div class="option-container"></div>
							</div>
						</div>
					</div>
					<div class="address-inputs"></div>
					<div class="cf-title">Modo de Pagamento</div>
					<ul class="payment-list">
						<div class="cfr-item">
							<input type="radio" class="pm" name="pm" id="one" value="M-pesa" required>
							<label for="one">
								<li>M-pesa
									<img class="lazy" data-src="img/paypal.png" alt=""></a>
								</li>
							</label>
						</div>
						<div class="cfr-item">
							<input type="radio" class="pm" name="pm" id="two" value="Visa" required>
							<label for="two">
								<li>Visa
									<img class="lazy" data-src="img/mastercart.png" alt=""></a>
								</li>
							</label>
						</div>
						<div class="cfr-item">
							<input type="radio" class="pm" name="pm" id="tree" value="Transfer&ecirc;ncia" required>
							<label for="tree">
								<li>Transfer&ecirc;ncia</li>
							</label>
						</div>
					</ul>
					<button type="submit" class="btn btn-success btn-block cle-btn-rounded">Finalizar</button>
				</form>
			</div>
			<div class="col-lg-4 order-1 order-lg-2">
				<div class="checkout-cart">
					<h3>Seu Carrinho</h3>
					<ul class="product-list">
						<?php
							$desconto = $descontoPromo = $subtotal = $total = 0;
							foreach ($object->select('*', 'rec_cotacao', "ref_compraid = '".((!empty($_SESSION['ref_compra'])) ? $_SESSION['ref_compra'] : '' )."' AND email = '".$_SESSION['email']."' AND estado = '0'") as $key => $value) {
								$tabela = $object->select_table("codigo='".$value['codigo']."'");
								$operador = ($tabela == 'servico') ? 'img, nome, categoriaid' : 'img, marcaid, categoriaid, corid' ;
								$item = mysqli_fetch_assoc($object->select($operador, $tabela, "codigo='".$value['codigo']."'"));
								if($tabela != 'servico') {
									$marca = mysqli_fetch_assoc($object->select("nome_marca", "marca", "id='".$item['marcaid']."'"));
									$cor = mysqli_fetch_assoc($object->select("nome_cor", "cor", "id='".$item['corid']."'"));
								}
								echo '<li>
										<div class="pl-thumb"><img class="img-responsive" src="'.$url.'assets/img/produtos/'.$item['categoriaid'].'/'.$item['img'].'.png" alt=""></div>
										<h6 style="padding-top: 0px;">'.(($tabela != 'servico') ? $marca['nome_marca'] : $item['nome_marca'] ).'</h6>
										<p>'.number_format(($value['qtd'] * $value['preco_un']), 2, ".", ",").' '.$generator->moeda('m').'</p>
										'.(($tabela != 'transporte') ? '' : '<p>'.'+'.number_format(($value['dias_trans'] * $value['taxa_trans']), 2, ".", ",").' '.$generator->moeda('m').'</p>').'
										'.(($tabela != 'servico') ? '<label class="cs-'.$cor['nome_cor'].'" for="'.$cor['nome_cor'].'-color" style="background-color:'.$cor['nome_cor'].';border:1px solid #303030;width: 24px;height: 14px;border-radius: 25px;margin: auto;margin-left:2px;"></label>' : '' ).'
									</li>';
								$subtotal += $value['preco_venda'];
							}
							$total = $subtotal - $desconto - $descontoPromo;
						?>
					</ul>
					<ul class="price-list">
						<li>Subtotal<span><?=number_format($subtotal, 2, ".", ",").' '.$generator->moeda('m')?></span></li>
						<li>Desconto<span><?=number_format($desconto, 2, ".", ",").' '.$generator->moeda('m')?></span></li>
						<li>Desconto promo<span><?=number_format($descontoPromo, 2, ".", ",").' '.$generator->moeda('m')?></span></li>
						<li class="total">Total<span><?=number_format($total, 2, ".", ",").' '.$generator->moeda('m')?></span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>