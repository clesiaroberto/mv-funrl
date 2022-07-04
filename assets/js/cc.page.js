// ------------------------------------------------------------------------------ //
//
// Name website : MovelCare
// Categorie : E-commerce
// Author : Clésia Chale
// Version : v.1.0.6
// Created : 2020-11-11
// Last update : 2021-05-28
//
// ------------------------------------------------------------------------------ //

(function($) {
    "use strict";

    // [EN] Variable
    // [PT] Variável
    var REPLACE = {
        DEFAULT_URL: "",
        DEFAULT_SIZE: 9,
        DEFAULT_PREFIX: ".php"
    }

    var _AJAX_OBJ = null;

    var url = document.URL;
    var parameter = url.split("/");
    REPLACE["DEFAULT_URL"] = atob($('body').attr('id'));

    // [EN] Constant variables
    // [PT] Variaveis constantes
    const DEFAULT_URL = {
        DEFAULT_ACCESS: `${REPLACE["DEFAULT_URL"]}app/controllers/acesso${REPLACE["DEFAULT_PREFIX"]}`,
        DEFAULT_DELETE: `${REPLACE["DEFAULT_URL"]}app/controllers/delete${REPLACE["DEFAULT_PREFIX"]}`,
        DEFAULT_INSERT: `${REPLACE["DEFAULT_URL"]}app/controllers/insert${REPLACE["DEFAULT_PREFIX"]}`,
        DEFAULT_SELECT: `${REPLACE["DEFAULT_URL"]}app/controllers/select${REPLACE["DEFAULT_PREFIX"]}`,
        DEFAULT_UPDATE: `${REPLACE["DEFAULT_URL"]}app/controllers/update${REPLACE["DEFAULT_PREFIX"]}`
    }

    /* [EN] Code Bank {unused code, in future use}
     * [PT] Banco de código {código não aproveitado, futuramente em uso}
     *   Number.prototype.format = function(n, x) {
     *      var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
     *       return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
     *   };
    */

    var t = {
        // [EN] Inicialize
        // [PT] Inicializar
        _ini: function() {
            if(this._findPage(["carrinho"])){
                this._getCart();
            }

            this._getBasket();

            if(this._findPage(["check-out"])){
                this._getCheckOut();
            }

            var display = this._findPage(["carrinho", "check-out", "logar"]);
            if(display === false) {
                this._getRange();
                this._fetchItem();
                this._getColor();
                this._getBrand();
            }
        },

        // [EN] Find Page
        // [PT] Página de localização
        _findPage:function(e) {
            for (var i = e.length - 1; i >= 0; i--) {
                const el = parameter.find(element => element == e[i])
                if(el == "" || el == "carrinho" || el == "check-out" || el == "logar") {
                    var found = true;
                } else {
                    var found = false;
                }
            }
            return found;
        },

        // [EN] Card quantity
        // [PT] Quantidade de card
        _sizeCard: function() {
            if($('#item').find('.card').length > 9) {
                return REPLACE["DEFAULT_SIZE"] = $('#item').find('.card').length;
            } else {
                return REPLACE["DEFAULT_SIZE"];
            }
        },

        // [EN] Initialize default ajax
        // [PT] Inicializar ajax padräo
        _ajaxDefault: function(u, d) {
            // [EN][PT] local var
            var theResponse = null;

            // [EN][PT] jQuery ajax
            $.ajax({
                url: u,
                method: 'POST',
                data: d,
                // [EN] line added to get ajax response in sync
                // [PT] linha adicionada para obter a resposta ajax em sincronia
                async: false,
                success: function(response) {
                    theResponse = response;
                },
                error: function(jqXHR) {
                    console.log('Error occured [' + jqXHR.status + ']\n' + jqXHR.responseText);
                }
            })
            return theResponse;
        },

        // [EN] Get item / product / transport
        // [PT] Obter item / produto / transporte
        _fetchItem: function() {
            $('#item').html('<p class="d-flex justify-content-center" style="width:100%"><i class="gg-spinner-two"></i></p>');
            var minimum = $('#minamount').val();
            var maximum = $('#maxamount').val();
            var brand = this._getFeature('marca');
            var color = this._getFeature('cor');

            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'request', type:$('#item').data("tunel"), val:$("#shop-val").data("shop"), min:minimum, max:maximum, cor:color, marca:brand, limit:"LIMIT " + this._sizeCard(), root: REPLACE["DEFAULT_URL"]});
        
            if(Object.keys(_AJAX_OBJ)[0] == "empty") {
                $('#item').html(_AJAX_OBJ["empty"]);
            } else {
                $('#item').html(_AJAX_OBJ.join(""));
                $('#cc-btn-category').html('<button type="button" id="cc-load" class="btn btn-dark">Carregar</button>');
            }
        },

        // [EN] Get color
        // [PT] Obter cor
        _getColor: function() {
            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'feature', type:$('#item').data("tunel"), feature:'cor', val:$("#shop-val").data("shop")});
            $('#cor').html(_AJAX_OBJ.join(""))
        },

        // [EN] Get Brand
        // [PT] Obter marca
        _getBrand: function() {
            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'feature', type:$('#item').data("tunel"), feature:'marca', val:$("#shop-val").data("shop")});
            $('#marca').html(_AJAX_OBJ.join(""))
        },

        // [EN] Get Price
        // [PT] Obter preço
        _getRange: function() {
            var rangeSlider = $(".price-range"),
                minamount = $("#minamount"),
                maxamount = $("#maxamount");

            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'price', type:$('#item').data("tunel"), val:$("#shop-val").data("shop")});

            var minPrice = parseInt(_AJAX_OBJ.min),
                maxPrice = parseInt(_AJAX_OBJ.max);

            rangeSlider.slider({
                range: true,
                min: minPrice,
                max: maxPrice,
                values: [minPrice, maxPrice],
                slide: function (event, ui) {
                    minamount.val(ui.values[0]);
                    maxamount.val(ui.values[1]);
                    t._fetchItem();
                }
            });     
            minamount.val(rangeSlider.slider("values", 0));
            maxamount.val(rangeSlider.slider("values", 1));
        },

        // [EN] Get Basket of cart
        // [PT] Obter cesto do carrinho
        _getBasket: function() {
            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'cart', type:'cesto', root:REPLACE["DEFAULT_URL"]});

            $('.badge').html(_AJAX_OBJ['cesto_total']);
            $('.cart-list').html(_AJAX_OBJ['cesto']);
            $('#cesto').html(_AJAX_OBJ['subtotal']);
            if(_AJAX_OBJ['cesto_total'] == 0) {
                $('#summary').prop('disabled', true);
                $('#summary_cart').prop('disabled', true);
            }else {
                $('#summary').prop('disabled', false);
                $('#summary_cart').prop('disabled', false);
            }
        },

        // [EN] Get cart
        // [PT] Obter carrinho
        _getCart: function() {
            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'cart', type:'carrinho', root:REPLACE["DEFAULT_URL"]});
            $('#carrinho').html(_AJAX_OBJ['carrinho']);
            $('#subtotal').html(_AJAX_OBJ['subtotal']);
            $('#desconto').html(_AJAX_OBJ['desconto']);
            $('#promo').html(_AJAX_OBJ['promo']);
            $('#taxa').html(_AJAX_OBJ['taxa']);
            $('#total').html(_AJAX_OBJ['total']);
        },

        // [EN] Get address of client in checkout
        // [PT] Obter endereço do cliente no checkout
        _getCheckOut: function() {
            _AJAX_OBJ = this._ajaxDefault(DEFAULT_URL["DEFAULT_ACCESS"], {key: 'endereco'});

            var content = '',
                elem = '',
                omega = '';
            for (var key in _AJAX_OBJ) {
                elem += '<input class="option-input" id="option-' + key + '" type="radio" name="options" ' + _AJAX_OBJ[key].check + ' value="' + _AJAX_OBJ[key].id + '" required/>';
                if (_AJAX_OBJ.hasOwnProperty(key)) {
                    const element = _AJAX_OBJ[key];
                    content +='<label class="option" for="option-' + key + '" >';
                    content += (Object.keys(_AJAX_OBJ).length == 1) ? '' : '<a id="cc-trash" data-id="'+_AJAX_OBJ[key].id+'"><i class="gg-trash"></i></a>';
                    content +=  '<span class="option-indicator"></span>';
                    content +=  '<span class="option-label">';
                    content +=      '<p>A/B: <span>' + element.av_bairro + '</span></p>';
                    content +=      '<p>R: <span>' + element.rua + '</span></p>';
                    content +=      '<p>C: <span>' + element.casa + '</span></p>';
                    content +=      '<p>T: <span>' + element.contacto_1 + '</span></p>';
                    content +=  '</span>';
                    content +='</label>';
                }
            }
            if(key != 3){
                elem += '<input class="option-input" id="option-3" type="radio" name="options" required/>';
                content += '<label class="option" for="option-3">';
                content +=  '<span class="option-indicator"></span>';
                content +=  '<span class="option-label">';
                content +=      '<sub>+</sub>';
                content +=  '</span>';
                content += '</label>';
                omega = elem + content;
            } else {
                omega = elem + content;
            }
            $('.option-container').html(omega);
        },

        // [EN] Get feature of input
        // [PT] Obter caracteristica da input
        _getFeature: function(e) {
            var filter = [];
            $('.' + e + ':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;
        }
    }

    $(document).ready(function(){
        // [EN] Initialize
        // [PT] Inicializar
        t._ini();

        // _AJAX_OBJ = t._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'search'});
        // console.log(_AJAX_OBJ)

        $('#procura').on('keyup', function(){
            var _item = "";
            var _search = $('#result-search');

            if (this.value.length == 0) {
                $(".search").remove();
                _search.css('border', 'none')
                return;
            }

            _AJAX_OBJ = t._ajaxDefault(DEFAULT_URL["DEFAULT_SELECT"], {key:'search', search:$(this).val()});

            _search.html('<div class="search py-3 px-5"></div>');
            _search.css('border', '1px solid #ced4da');
            var obj = JSON.parse(_AJAX_OBJ);
            for(var k in obj) {
                if(k == "empty") {
                    _item = obj[k];
                } else {
                    _item += '<a id="cc-search" data-id="'+obj[k][2]+'" data-content="'+obj[k][1]+'">'+obj[k][1]+' '+obj[k][3]+'</a><br/>';     
                }
            }
            $(".search").html(_item);
        })

        // [EN] Load to Button more itens / product / transport
        // [PT] Botão para carregar mais items / produto / transporte
        $('#cc-load').click(function() {
            var codigo = $('[data-codigo]').last().data('codigo'),
                $this = $(this);
            $.ajax({
                url: DEFAULT_URL["DEFAULT_SELECT"],
                type: 'POST',
                data: {key:'request', type:$('#item').data("tunel"), val:$("#shop-val").data("shop"), limit:"LIMIT 6", codigo:codigo},
                beforeSend: function() {
                    $this.text('Carregando...');
                    $this.prop("disabled", true);
                },
                success:function(response) {
                    for(var k in response) {
                        if(k == "empty") {
                            $this.css("display", "none");
                        } else {
                            $this.text('Carregar');
                            $this.prop("disabled", false);
                            $('#item').append(response.join(""));
                        }
                    }
                },
                error: function(jqXHR) {
                    console.log('Error occured [' + jqXHR.status + ']\n'+jqXHR.responseText+'');
                }
            })
        })
    });

    // [EN] Search item
    // [PT] Procurar item
    $(document).on('click', '#cc-search', function(){
        var e = this;
        window.location.href = `${REPLACE["DEFAULT_URL"]}procurar?q=${$(e).data('content')}`;
        t._ini();
    })

    // [EN] Exit button
    // [PT] Botão de saída
    $(document).on('click', '#sair', function(){
        if(t._ajaxDefault(DEFAULT_URL["DEFAULT_ACCESS"], {key: 'sair'})) {
            window.location = `${REPLACE["DEFAULT_URL"]}`;
        }
        return false;
    });

    // [EN] Changing an event that occurred in a check or radio
    // [PT] Mudança de um evento ocorrido em um check ou radiobutton
    $(document).on('change', 'input[data-class="cc-feature"]', function() {
        t._fetchItem()
    })

    // [EN] Add item in cart
    // [PT] Adicionar item no carrinho
    $(document).on('click', '#cc-shop', function(){
        var e = this;
        let provider = $(e).closest('.cc-card').find('.form-select option:selected').val()  ;
        if(t._ajaxDefault(DEFAULT_URL["DEFAULT_INSERT"], {key:'cotacao', produto_id:$(e).data('id'), provider: provider}) == 'logar') {
            window.location.href = `${REPLACE['DEFAULT_URL']}` + 'logar';
        } else {
            t._getBasket();
        }
    })

    // [EN] Add and decrease quantity for each item 
    // [PT] Adicionar e diminuir quantidade de cada item / produto / transporte
    $(document).on('click', '#cc-qty', function(){
        var e = this;
        var oldValue = $(e).parent().find('input').val();
        if($(e).hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
            if(t._ajaxDefault(DEFAULT_URL["DEFAULT_INSERT"], {key:'cotacao', type:'mais', produto_id:$(e).data('id')}) > 0) {
                t._getCart();
                t._getBasket();
            }
        } else {
            if(oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
                if(t._ajaxDefault(DEFAULT_URL["DEFAULT_INSERT"], {key:'cotacao', type:'menos', produto_id:$(e).data('id')}) > 0) {
                    t._getCart();
                    t._getBasket();
                }
            } else {
                newVal = 1;
            }
        }
        $(e).parent().find('input').val(newVal);
    })

    // [EN] Delete cart item
    // [PT] Excluir item do carrinho
    $(document).on('click', '#cc-del', function(){
        var e = this;
        if(t._ajaxDefault(DEFAULT_URL["DEFAULT_DELETE"], {key:'cotacao', code:$(e).data('id')}) == 1) {
            t._getBasket();
            t._getCart();
        } else {
            console.log('Error delete!')
        }
    })

    // [EN] Change days in transport cart
    // [PT] Alterar dias no carrinho de transporte
    $(document).on('change', 'input[class="option-days ml-2"]', function(){
        var param = this.id.split('.');

        if(t._ajaxDefault(DEFAULT_URL["DEFAULT_INSERT"], {key:'cotacao', type:'transporte', produto_id:param[0], dias:param[1], preco:$(this).val()}) > 0) {
            t._getCart();
        } else {
            console.log('Error insert/update!')
        }
    })

    // [EN] Delete address
    // [PT] Excluir endereço
    $(document).on('click', '#cc-trash', function(){
        var $this = $(this);

        if(t._ajaxDefault(DEFAULT_URL["DEFAULT_DELETE"], {key:'endereco', id:$this.attr('data-id')}) == 1) {
            t._getCheckOut()
        } else {
            console.log('Error delete!')
        }
    })
}(jQuery));