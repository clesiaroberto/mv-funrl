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

$(document).on('show.bs.modal', '#categoriaModal', function (event) {
	var button = $(event.relatedTarget)
	var recipient = button.data('whatever')
	var code = button.data('whatcode');
	var modal = $(this)
	var url = atob($('body').attr('id'));
	modal.find('.modal-title').text('Flor ' + recipient);

	$.ajax({
		type: 'POST',
		url: `${url}app/controllers/select.php`,
		data: {key:'flower', code: code, url: url},
		beforeSend: function() {
			contextLoader.addLoader('.modal-body #owl-demo', 'image')
			contextLoader.addLoader('.modal-body .info-modal-flower', 'content')
        },
		success: function(response) {
			var imgContent = "",
				infoContent = "";
				fornecedor = "";
			$.each(response, function(k, v) {
				imgContent += response[k]['img'];
			});

			modal.find('.modal-body #owl-demo').html(imgContent)
			modal.find('.modal-body .info-modal-flower').text(`${response[0]["info"]}`);
			modal.find('.modal-body .info-modal-provider').text(`${response[0]["fornecedor"]}`)

			var owlInfo = $('#owl-demo');
			owlInfo.trigger('destroy.owl.carousel');
			owlInfo.owlCarousel({
				loop: true,
				autoplay: true,
			    autoplayTimeout: 2400,
			    autoplayHoverPause: true,
				nav: false, // Show next and prev buttons
				slideSpeed : 300,
				paginationSpeed : 400,
				items: 1,
				dots: false
			})

			owlInfo.on('translated.owl.carousel', function(e) {
				if(event.type == "show") {
			    	var atr = $(this).find('.active').find('img').get(0);
			    	var i = atr.id;
			    }

			    var items     = e.item.count;     // Number of items
    			var item      = e.item.index;     // Position of the current item

				modal.find('.modal-body .info-modal-flower').text(`${response[i]["info"]}`);
				modal.find('.modal-body .info-modal-provider').text(`${response[i]["fornecedor"]}`)
			});

			modal.find('.modal-body .caption').remove();
		},
		error: function(jqXHR) {
            console.log('Error occured [' + jqXHR.responseText + ']');
        }
	})
})