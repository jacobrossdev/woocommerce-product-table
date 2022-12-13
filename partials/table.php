		
		<div class="product-table-column">
			<table style="max-width: 500px;">
				<thead>
					<tr>
						<th>RBC</th>
						<th>Price</th>
						<th>Qty</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($query->posts as $post): 
							$qty = 0;
							$key = '';
							if( $cart_item = has_cart_item($cart_contents, $post->ID) ){
								$qty = $cart_item['quantity'];
								$key = $cart_item['key'];
							}
						?>
						<tr data-product_id="<?php echo $post->ID; ?>" <?php echo strlen($key) ? 'data-cart_key="'.$key.'"' : '';?>>
							<td><?php echo $post->post_title?></td>
							<td>

								<?php 

										$product_object = wc_get_product($post->ID);
									
										$product_type = wp_get_post_terms( $post->ID, 'product_type' );		

										$price = $product_object->get_data();
										
										switch ($product_type) {
											case 'variation':
												continue;
												break;
											case 'composite':
												$data = get_post_meta( $post->ID, '_bto_data', true );
												$args = array();										
												$price = 0;
												foreach($data as $key => $component){
													$_product = wc_get_product( $component['assigned_ids'][0] ); 
													$price += floatval($_product->get_regular_price()) * $component['quantity_max']; 
												}
												break;
											
											case 'simple':
											default:
												$price = $price['price'];
												break;
										}

									echo '$ '.number_format((float)$price, 2, '.', '');

								?>
								
							</td>
							<td style="width: 60px;"><input class="product-table-row-qty" type="number" min="0" step="1" value="<?php echo $qty; ?>"></td>
						</tr>
						
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
