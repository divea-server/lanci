<form method="post">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label>Limpar Cache</label></th>
				<td>
					<a href="<?php echo wp_nonce_url(admin_url( add_query_arg( 'action', 'purge-cache', "options-general.php?page=lanci" )),'purge-cache'); ?>" class="button button-secondary button-large delete">
						<?php if(class_exists("\autoptimizeCache")) : ?>
							Limpar Autoptimize, Redis e Nginx
						<?php else: ?>
							Limpar Redis e Nginx
						<?php endif; ?>
					</a>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Google Analytics</label></th>
				<td colspan=2>
					<input name="google_analytics" type="text" class="regular-text" value="<?php echo @$lanci['google_analytics'] ?>" />
					<p class="description">O código UA, ou códigos de eventos separados por <b>(ponto e vírgula)</b> - analytics v4</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Google Tag Manager</label></th>
				<td colspan=2>
					<input name="google_tag_manager" type="text" class="regular-text" value="<?php echo @$lanci['google_tag_manager'] ?>" />
					<p class="description">O código GTM, apenas um.</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Facebook Pixel</label></th>
				<td colspan=2>
					<input name="facebook_pixel" type="text" class="regular-text" value="<?php echo @$lanci['facebook_pixel'] ?>" />
					<p class="description">O código do seu pixel, para adicionar mais que um separe por <b>(ponto e vírgula)</b></p>
				</td>
			</tr>
			<tr>
				<th scope="row">Outros</th>
				<td style="with:40%">
					<textarea name="outros_header" rows="10" class="large-text code"><?php echo @$lanci['lanci_outros_header'] ?></textarea>
					<p class="description">Inseridos em <code><?php echo htmlentities("<head></head>") ?></code></p>
				</td>
				<td style="with:40%">
					<textarea name="outros_body" rows="10" class="large-text code"><?php echo @$lanci['lanci_outros_body'] ?></textarea>
					<p class="description">Inseridos em <code><?php echo htmlentities("<body></body>") ?></code></p>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<input type="submit" class="button button-primary button-large" value="Salvar">
				</td>
			</tr>
		</tbody>
	</table>
</form>