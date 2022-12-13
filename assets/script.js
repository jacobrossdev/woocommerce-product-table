jQuery(document).ready(function($){

	$('#table-totals').on('click', 'button.checkout', function(e){

		window.location.href=woo_product_table.checkout_url;
	});

	var qty = 0;

	$('input.product-table-row-qty').on('change',function(e){
	
		var qty = $(this).val();
		var el = this;

		if( $(this).closest('tr').is('[data-cart_key]') ){

			var cart_key = $(this).closest('tr').data('cart_key');

			$.ajax({
				url : woo_product_table.admin_ajax,
				type : 'POST',
				dataType: 'json',
				data : {
					action: 'product_table_update',
					qty: $(this).val(),
					cart_key: cart_key,
					product_id : $(this).closest('tr').data('product_id')
				},
				beforeSend: function(){
					$('#table-totals').find('button').attr('disabled','disabled');
					$('#table-totals').find('td.subtotal span').text('...');
					$('#table-totals').find('td.tax span').text('...');
					$('#table-totals').find('td.total span').text('...');
				},
				success: function(d){
					$('#table-totals').find('button').removeAttr('disabled');
					$('#table-totals').find('td.subtotal span').text(d.subtotal);
					$('#table-totals').find('td.tax span').text(d.total_tax);
					$('#table-totals').find('td.total span').text(d.total);
					if( $(el).val() == 0 ){

						$(el).closest('tr').removeAttr('data-cart_key');
					}

				}
			});

		} else {

			$.ajax({
				url : woo_product_table.admin_ajax,
				type : 'POST',
				dataType: 'json',
				data : {
					action: 'product_table_update',
					qty: $(this).val(),
					product_id : $(this).closest('tr').data('product_id')
				},
				beforeSend: function(){
					$('#table-totals').find('button').attr('disabled','disabled');
					$('#table-totals').find('td.subtotal span').text('...');
					$('#table-totals').find('td.tax span').text('...');
					$('#table-totals').find('td.total span').text('...');
				},
				success: function(d){
					$('#table-totals').find('button').removeAttr('disabled');
					$(el).closest('tr').attr('data-cart_key', d.key);
					$('#table-totals').find('td.subtotal span').text(d.subtotal);
					$('#table-totals').find('td.tax span').text(d.total_tax);
					$('#table-totals').find('td.total span').text(d.total);
				}
			});

		}
	});	

});