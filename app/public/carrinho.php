<div class="page-top-info">
    <div class="container">
        <h4>Seu carrinho</h4>
        <div class="site-pagination">
            <a href="<?=$url?>">Home</a> /
            <a id="shop" href="">Carrinho</a> /
        </div>
    </div>
</div>
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table">
                    <div class="cart-table-warp">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-th">Item</th>
                                    <th class="total-th">Total</th>
                                </tr>
                            </thead>
                            <tbody id="carrinho"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cle-card-right">
                    <form class="promo-code-form">
                        <input type="text" placeholder="Codigo da promo" disabled="">
                        <button type="button" disabled="">Submeter</button>
                    </form>
                    <div class="cle-card-checkout">
                        <p>Subtotal <span id="subtotal">0 MZN></span></p>
                        <p>Desconto <span id="desconto">0 MZN</span></p>
                        <p>Desconto Promo <span id="promo">0 MZN</span></p>
                    </div>
                    <div class="cle-card-total">
                        <h5>Total <span id="total">0 MZN</span></h5>
                    </div>
                    <button class="btn btn-success btn-block cle-btn-rounded" style="text-transform: uppercase;" id="summary_cart" <?='onclick=\'window.location=("'.$url.'check-out");return false;\''?> disabled>Fazer o check-out</button>
                    <a class="btn btn-dark btn-block cle-btn-rounded text-white" onClick="window.history.back();" style="text-transform: uppercase;">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</section>