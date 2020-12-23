<?php

	defined( '\\ABSPATH' ) || exit;

?>
<div id="lanci">

	<img src="<?php echo plugin_dir_url(__FILE__) . "assets/divea.svg" ?>" class="logo" />
	<h1>Meu Wordpress</h1>

	<?php if(false !== ( $temp_message = get_transient('temporary_message'))) : ?>
		<div class="message"><?php echo $temp_message ?></div>
	<?php delete_transient('temporary_message'); endif; ?>

	<div class="columns">
		<div class="content-column">

			<h2 class="nav-tab-wrapper"> 
				<a id="config-tab" class="nav-tab nav-tab-active" data-toggle="config" href="#tags">
					Configurações
				</a>              
				<a id="info-tab" class="nav-tab" data-toggle="info" href="#info">
					Informações
				</a>
			</h2>

			<div class="tab-content">
				<div id="config-pane" class="tab-pane tab-pane-config active">
					<?php require_once("config-config.php"); ?>
				</div>
				<div id="info-pane" class="tab-pane tab-pane-info">
					<?php require_once("config-info.php"); ?>
				</div>
			</div>

		</div>
	</div>
</div>
