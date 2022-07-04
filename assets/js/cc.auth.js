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

var url = atob($('body').attr('id'));
var access = `${url}app/controllers/`;

document.addEventListener('DOMContentLoaded', function (event) {
    [].forEach.call(document.querySelectorAll('form'), function(form){
        switch (form.getAttribute('name')) {
        	case 'cle-form-login':
        		$('#'+form.getAttribute('id')).validate({
        			rules: {
				        endereco_electronico: {
				            required: true,
				            email: true
				        },
				        senha: {
				            required: true,
				            minlength: 6
				        }
				    },
				    messages: {
				    	endereco_electronico: {
           	            	required: 'Por favor, introduza seu endere&ccedil;o electr&ocirc;nico.',
                	        email: 'Por favor introduza um endere&ccedil;o electr&ocirc;nico v&aacute;lido!'
                	    },
                	    senha: {
                            required: 'Por favor, introduza sua senha',
                            minlength: 'A sua senha deve ter pelo menos {0} caracteres!'
                        }
				    },
				    submitHandler:function(e){
                        $.ajax({
                            url: `${access}acesso.php`,
                            type: 'POST',
                            data: {key: 'login', email:$('#endereco_electronico').val(), senha:$('#senha').val()},
                            beforeSend: function() {
                                $('#cle').html('<i class="gg-spinner-two"></i>Continuar');
                            },
                            success: function(data) {
                                if(data['logar'] == 'next') {
                                    setTimeout('window.history.back()', 10);
                                } else {
                                    $("#info").fadeIn(1000).html('<small class="alert alert-danger text-center d-block">' + data['acesso'] + '</small>');
                                    setTimeout(function(){
                                        $("#info").fadeOut('slow');
                                    }, 5000);
                                    $('#cle').html('Continuar');
                                }
                            },
                            error: function(jqXHR) {
                                console.log('Error occured [' + jqXHR.status + ']');
                            }
                        })
                    }
        		});
        		break;

        	case 'cle-form-register':
                $('#'+form.getAttribute('id')).validate({
                    rules: {
                        nome: {
                            required: true,
                            minlength: 4
                        },
                        apelido: {
                            required: true
                        },
                        nascimento: {
                            required: true
                        },
                        genero: {
                            required: true
                        },
                        nacionalidade: {
                            required: true,
                        },
                        rua: {
                            required: true
                        },
                        av_bairro: {
                            required: true
                        },
                        casa: {
                            required: true,
                            number: true
                        },
                        contacto_1: {
                            required: true,
                            number: true,
                            minlength: 9
                        },
                        endereco_electronico: {
                            required: true,
                            email: true,
                            remote: {
                                url: `${access}select.php`,
                                type: "post",
                                dataType: "json",
                                data: {key:'validation'}
                            }
                        },
                        senha: {
                            required: true,
                            minlength: 6
                        },
                        confirmar: {
                            required: true,
                            equalTo: '#senha'
                        },
                        termo_uso: {
                        	required: true
                        },
                        termo_marketing: {
                        	required: true
                        },
                        termo_notificacao: {
                        	required: true
                        }
                    },
                    messages: {
                        nome: {
                            required: 'Por favor, introduza seu nome.',
                            minlength: 'Por favor, introduza at&eacute; pelo menos {0} caracteres!'
                        },
                        apelido: {
                            required: 'Por favor, introduza seu apelido.'
                        },
                        nascimento: {
                            required: 'Por favor, introduza sua data de nascimento.'
                        },
                        genero: {
                            required: 'Por favor, selecione seu g&ecirc;nero.'
                        },
                        nacionalidade: {
                            required: 'Por favor, selecione sua nacionalidade.'
                        },
                        rua: {
                            required: 'Por favor, introduza sua rua.'
                        },
                        av_bairro: {
                            required: 'Por favor, introduza avenida ou bairro.'
                        },
                        casa: {
                            required: 'Por favor, introduza o n&uacute;mero da sua casa.',
                            number: 'Por favor, d&iacute;gite somente n&uacute;meros!'
                        },
                        contacto_1: {
                            required: 'Por favor, introduza seu contacto.',
                            number: 'Por favor, d&iacute;gite somente n&uacute;meros!',
                            minlength: 'Por favor, introduza até pelo menos {0} d&iacute;gitos!'
                        },
                        endereco_electronico: {
                            required: 'Por favor, introduza seu endere&ccedil;o electr&ocirc;nico.',
                            email: 'Por favor introduza um endere&ccedil;o electr&ocirc;nico v&aacute;lido!',
                            remote: 'Este endere&ccedil;o electr&ocirc;nico existe!'
                        },
                        senha: {
                            required: 'Por favor, introduza sua senha',
                            minlength: 'A sua senha deve ter pelo menos {0} caracteres!'
                        },
                        confirmar: {
                            required: 'Por favor, introduza sua senha',
                            equalTo: 'Introduza a mesma senha acima'
                        },
                        termo_uso: {
                        	required: 'Por favor, selecione o termo de uso'
                        },
                        termo_marketing: {
                        	required: 'Por favor, selecione o termo de marketing'
                        },
                        termo_notificacao: {
                        	required: 'Por favor, selecione o termo de nottifi&ccedil;a&atilde;o'
                        }
                    },
                    errorPlacement: function errorPlacement(error, element) {
                        element.after(error);
                    }
                });
                $('#'+form.getAttribute('id')).children("div").steps({
                    headerTag: "h3",
                    bodyTag: "section",
                    transitionEffect: "fade",
                    labels:  {
                        current: "Passo actual:",
                        pagination: "Paginação",
                        finish: "Registar",
                        next: "Próximo",
                        previous: "Anterior",
                        loading: "Carregando ..."
                    },
                    onStepChanging: function (event, currentIndex, newIndex) {
                        $('#'+form.getAttribute('id')).validate().settings.ignore = ":disabled,:hidden";
                        return $('#'+form.getAttribute('id')).valid();
                    },
                    onFinishing: function (event, currentIndex) {
                        $('#'+form.getAttribute('id')).validate().settings.ignore = ":disabled";
                        return $('#'+form.getAttribute('id')).valid();
                    },
                    onFinished: function (event, currentIndex) {
                        $.ajax({
                            url: `${access}insert.php`,
                            type: 'POST',
                            data: {key: 'cliente', nome:$('#nome').val(), apelido:$('#apelido').val(), nascimento:$('#nascimento').val(), genero:$('#genero').val(), nacionalidade:$('#nacionalidade').val(), av_bairro:$('#av_bairro').val(), rua:$('#rua').val(), casa:$('#casa').val(), contacto:$('#contacto_1').val(), contacto_alt:$('#contacto_2').val(), email:$('#endereco_electronico').val(), senha:$('#senha').val()},
                            beforeSend: function() {
                                $('#cle-r').html('<i class="gg-spinner-two"></i>Continuar');
                            },
                            success: function(data) {
                                if(data['logar'] == 'next') {
                                    window.location.href = './';
                                } else {
                                    $("#info").fadeIn(1000).html('<small class="alert alert-danger text-center d-block">' + data['err'] + '</small>');
                                    setTimeout(function(){
                                        $("#info").fadeOut('slow');
                                    }, 5000);
                                }
                            },
                            error: function(jqXHR) {
                                console.log('Error occured [' + jqXHR.status + ']');
                            }
                        })
                    }
                });
                break;

            case 'cle-form-recuperar':
            	$('#'+form.getAttribute('id')).validate({
            		rules: {
            			endereco_electronico: {
            				required: true,
            				email: true
            			}
            		},
            		messages: {
            			endereco_electronico: {
            				required: 'Por favor, introduza seu endere&ccedil;o electr&ocirc;nico.',
                            email: 'Por favor introduza um endere&ccedil;o electr&ocirc;nico v&aacute;lido!'
            			}
            		},
            		submitHandler:function(e){
            			$.ajax({
                            url: `${access}acesso.php`,
                            type: 'POST',
                            data: {key: 'recuperar', email:$('#endereco_electronico').val()},
                            success: function(data) {
                                if(data['acesso'] == 1) {
                                    $(".cle-logo-app").fadeIn(1000).after('<div class="alert alert-danger" style="display: -webkit-box"><i class="gg-close-o mr-2"></i>' + data['message'] + '</div>');
                                    setTimeout(function(){
                                        $(".alert-danger").fadeOut('slow', function() {
                                            $(this).remove();
                                        })
                                    }, 5000);
                                } else {
                                    $('.cle-logo-app').after('<div class="alert alert-success" style="display: -webkit-box"><i class="gg-check-o mr-2"></i>' + data['message'] + '</div>');
                                    $('#cle-form-recuperar').remove();
                                }
                            },
                            error: function(jqXHR) {
                                console.log('Error occured [' + jqXHR.status + ']');
                            }
                        })
            		}
            	})
            	break;

            case 'cle-form-checkOut':
                $('#'+form.getAttribute('id')).validate({
                	rules:{
                		av_bairro: {
                			required: true
                		},
                		rua: {
                			required: true
                		},
                		casa: {
                			required: true,
                			number: true
                		},
                		pm: {
                			required: true
                		},
                		mpesa: {
                			required: true,
                			minlength: 9,
                            maxlength: 9,
                			number: true
                		}
                	},
                	messages: {
                		av_bairro: {
                			required: 'Por favor, introduza avenida ou bairro.'
                		},
                		rua: {
                			required: 'Por favor, introduza sua rua.'
                		},
                		casa: {
                			required: 'Por favor, introduza o n&uacute;mero da sua casa.',
                            number: 'Por favor d&iacute;gite n&uacute;meros!'
                		},
                		pm: {
                			required: 'Por favor selecione uma das op&ccedil;&otilde;es'
                		},
                		mpesa: {
                			required: 'Por favor, introduza seu n&uacute;mero do m-pesa.',
                			minlength: 'Por favor, introduza até pelo menos {0} d&iacute;gitos!',
                            maxlength: 'Por favor, introduza até pelo menos {0} d&iacute;gitos!',
                            number: 'Por favor, d&iacute;gite somente n&uacute;meros!',
                		}
                	},
                	submitHandler:function(e){
                		$.ajax({
                			url: `${access}insert.php`,
                			type: 'POST',
                			data: {key:'finalizar', enderecoid: $('.option-input:checked').val(), av_bairro: $('#av_bairro').val(), rua: $("#rua").val(), casa: $("#casa").val(), pagamento:$("input[name='pm']:checked").val(), numero_conta:$("#mpesa").val()},
                            success:function(data) {
                                console.log(data);
                			}
                		})         		
                	}
                });
                break;

        	default:
                break;
        }
    })
})

$(document).ready(function(){
    $('.cc-back').click(function(){
    	window.history.back();
    })
})

$(document).on('change', 'input[class="option-input"]', function(){
    // -> Criacao de elementos(tags) <- //
    var div = document.createElement("div"),
        div_1 = document.createElement("div"),
        div_2 = document.createElement("div"),
        div_3 = document.createElement("div");
    var av = document.createElement("input"),
        rua = document.createElement("input"),
        casa = document.createElement("input");

    // -> Atributos de cada tag <- //
    av.setAttribute("type", "text");
    av.setAttribute("placeholder", "Avenida ou Bairro");
    av.setAttribute("name", "av_bairro");
    av.setAttribute("id", "av_bairro");
    av.setAttribute("required", "");

    rua.setAttribute("type", "text");
    rua.setAttribute("placeholder", "Rua");
    rua.setAttribute("name", "rua");
    rua.setAttribute("id", "rua");
    rua.setAttribute("required", "");

    casa.setAttribute("type", "text");
    casa.setAttribute("placeholder", "No da Casa");
    casa.setAttribute("name", "casa");
    casa.setAttribute("id", "casa");
    casa.setAttribute("required", "");

    div.setAttribute("class", "row address");
    div_1.setAttribute("class", "col-md-12 mb-4");
    div_2.setAttribute("class", "col-md-6 mb-4");
    div_3.setAttribute("class", "col-md-6 mb-4");

    // -> Inclua tags <- //
    $(div_1)[0].appendChild(av);
    $(div_2)[0].appendChild(rua);
    $(div_3)[0].appendChild(casa);
    $(div)[0].appendChild(div_1);
    $(div)[0].appendChild(div_2);
    $(div)[0].appendChild(div_3);

    if($(this).val() == 'on') {
        $(".address-inputs")[0].appendChild(div);
    } else {
    	if ($(".address").length > 0) {
		  $(".address")[0].remove(div);
		}
    }
})

$(document).on('change', 'input[name="pm"]', function(){
	var $this = $(this),
		div = document.createElement("input");

	div.setAttribute("type", "tel");
	div.setAttribute("placeholder", "O seu numero do m-pesa");
	div.setAttribute("name", "mpesa");
	div.setAttribute("id", "mpesa");
	div.setAttribute("required", "");

	if($this.attr('id') == 'one') {
		$this.parent().find('label').after(div);
	} else {
		$('#mpesa').remove()
	}
})