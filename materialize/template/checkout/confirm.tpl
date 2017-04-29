<?php if (!isset($redirect)) { ?>
<table class="bordered card-panel">
	<thead class="grey lighten-4">
		<tr>
			<th><small><?php echo $column_name; ?></small></th>
			<th><small><?php echo $column_model; ?></small></th>
			<th><small><?php echo $column_quantity; ?></small></th>
			<th><small><?php echo $column_price; ?></small></th>
			<th><small><?php echo $column_total; ?></small></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($products as $product) { ?>
		<tr>
			<td><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a>
			<?php foreach ($product['option'] as $option) { ?>
			<br>
			&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
			<?php } ?>
			<?php if($product['recurring']) { ?>
			<br>
			<span><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
			<?php } ?>
			</td>
			<td><?php echo $product['model']; ?></td>
			<td><?php echo $product['quantity']; ?></td>
			<td><?php echo $product['price']; ?></td>
			<td><?php echo $product['total']; ?></td>
		</tr>
		<?php } ?>
		<?php foreach ($vouchers as $voucher) { ?>
		<tr>
			<td"><?php echo $voucher['description']; ?></td>
			<td></td>
			<td>1</td>
			<td><?php echo $voucher['amount']; ?></td>
			<td><?php echo $voucher['amount']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<?php foreach ($totals as $total) { ?>
		<tr>
			<td colspan="4"><strong><?php echo $total['title']; ?>:</strong></td>
			<td><?php echo $total['text']; ?></td>
		</tr>
		<?php } ?>
	</tfoot>
</table>
<?php echo $payment; ?>
<?php } else { ?>
<script>
	location = '<?php echo $redirect; ?>';
</script>
<?php } ?>