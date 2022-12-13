<style>
		
	.group:before,
	.group:after {content: ""; display: table; }
	.group:after {clear: both; }
	.group {zoom: 1; }

	.form-box {background-color: #fff; border: 1px solid #ddd; width: 70% }
	.form-header {border-bottom: 1px solid #ddd; padding: 0 10px; }
	.form-footer {border-top: 1px solid #ddd; padding: 6px 10px; }
	.footer-message { float: left; line-height: 34px; color: #555 }
	.form-row {position: relative; border-bottom: 1px solid #ddd; display: flex; flex-direction: row; flex-wrap: nowrap; }
	.form-input .inner input { width: 100%; }
	.form-input .inner { padding: 10px;}
	.form-input { flex-grow: 3;}

	label {cursor: pointer; align-items: center; display: flex; padding: 10px; min-width: 130px;}
	input[type="submit"] {padding: 8px 12px; background-color: #0073AA; border: none; border-radius: 6px; float: right; }
	textarea { width: 100%; }

</style>

<div class="wrap">
	
	<div class="options">
			
			<div class="form-box">
				<form action="<?=get_admin_url();?>admin.php?page=woo_product_table" method="POST">
					
					<div class="form-header">
							
							<h3>WooCommerce Product Table Settings</h3>

					</div>
					
					<div class="form-row">
						
						<label for="progress_bar_value">Additional CSS</label>
						
						<div class="form-input"><div class="inner"><textarea name="woo_product_table_css" id="woo_product_table_css" cols="30" rows="10"><?php echo isset($options['woo_product_table_css']) ? stripslashes($options['woo_product_table_css']) : '' ?></textarea></div></div>

					</div>

					<div class="form-footer group">
						<div class="footer-message"><?=isset($_POST['message']) ? $_POST['message'] : ''?></div>
						<input type="submit" name="publish">
					</div>

				</form>
			</div>

	</div>

</div>