</div>
		<div id="table-totals" class="product-table-column">
			<table>
				<thead>
					<tr>
						<th colspan="2">Amount Due</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Sub Total</td>
						<td class="subtotal">$ <span><?php echo $totals['subtotal']?></span></td>
					</tr>
					<tr>
						<td>Tax</td>
						<td class="tax">$ <span><?php echo $totals['total_tax']?></span></td>
					</tr>
					<tr>
						<td>Total</td>
						<td class="total">$ <span><?php echo $totals['total']?></span></td>
					</tr>
					<tfoot>
						<tr>
							<td colspan="2">
								<button class="checkout">Checkout</button>
							</td>
						</tr>
					</tfoot>
				</tbody>
			</table>
		</div>

	</div>