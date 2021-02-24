<?php

	require_once LANCI_PATH.'/vendor/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php';

	add_action( 'tgmpa_register', 'lanci_register_required_plugins' );
	function lanci_register_required_plugins() 
	{
		$plugins = [
			[
				'name'			=> 'Autoptimize',
				'slug'			=> 'autoptimize',
				'required'		=> true
			],
			// [
			// 	'name'      	=> 'reSmush.it',
			// 	'slug'      	=> 'resmushit-image-optimizer',
			// 	'required'  	=> true,
			// ],
			// [
			// 	'name'      	=> 'Redirection',
			// 	'slug'      	=> 'redirection',
			// 	'required'  	=> false,
			// ],
			// [
			// 	'name'      	=> 'Yoast Duplicate Post',
			// 	'slug'      	=> 'duplicate-post',
			// 	'required'  	=> false,
			// ],
			// [
			// 	'name'        	=> 'Yoast SEO',
			// 	'slug'        	=> 'wordpress-seo',
			// 	'is_callable' 	=> 'wpseo_init',
			// ],
		];

		$config = [
			'id'           => 'lanci',
			'default_path' => '', 
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'plugins.php',
			'capability'   => 'manage_options',
			'has_notices'  => true, 
			'dismissable'  => true, 
			'dismiss_msg'  => '', 
			'is_automatic' => false, 
			'message'      => '', 
			'strings'      => [
				'page_title'                      => __( 'Instalar Plugins Recomendados', 'lanci' ),
				'menu_title'                      => __( 'Instalar Plugins', 'lanci' ),
				'installing'                      => __( 'Instalando o plugin: %s', 'lanci' ),
				'updating'                        => __( 'Atualizando o plugin: %s', 'lanci' ),
				'oops'                            => __( 'Oops aconteceu algum erro.', 'lanci' ),
				'notice_can_install_required'     => _n_noop('Instale o plugin obrigatório: %1$s.','Instale os plugins obrigatórios: %1$s.','lanci'),
				'notice_can_install_recommended'  => _n_noop('Instale o plugin recomendado: %1$s.','Instale os plugins recomendados: %1$s.','lanci'),
				'notice_ask_to_update'            => _n_noop('Alguns plugins precisam ser atualizados: %1$s.','Alguns plugins precisam ser atualizados: %1$s.','lanci'),
				'notice_ask_to_update_maybe'      => _n_noop('Alguns plugins precisam ser atualizados: %1$s.','Alguns plugins precisam ser atualizados: %1$s.','lanci'),
				'notice_can_activate_required'    => _n_noop('O plugin obrigatório está inativo: %1$s.','Os plugins obrigatórios estão inativos: %1$s.','lanci'),
				'notice_can_activate_recommended' => _n_noop('O plugin recomendado está inativo: %1$s.','Os plugins recomendados estão inativos: %1$s.','lanci'),
				'install_link'                    => _n_noop('Instalar','Instalar todos','lanci'),
				'update_link' 					  => _n_noop('Atualizar','Atualizar todos','lanci'),
				'activate_link'                   => _n_noop('Ativar','Ativar todos','lanci'),
				'return'                          => __( 'Voltar', 'lanci' ),
				'plugin_activated'                => __( 'Plugin ativado.', 'lanci' ),
				'activated_successfully'          => __( 'Plugins ativado:', 'lanci' ),
				'plugin_already_active'           => __( 'O Plugin %1$s já estava ativado.', 'lanci' ),
				'plugin_needs_higher_version'     => __( 'Plugin não ativado. há uma nova versão de %s, por favor atualize o plugin.', 'lanci' ),
				'complete'                        => __( 'Todos os plugins instalados e ativados. %1$s', 'lanci' ),
				'dismiss'                         => __( 'Ignorar', 'lanci' ),
				'notice_cannot_install_activate'  => __( 'Há um ou mais plugins que não podem ser instalados ou ativados.', 'lanci' ),
				'contact_admin'                   => __( 'Contate o suporte', 'lanci' ),
				'nag_type'                        => 'notice-info',
			],
		];
		tgmpa( $plugins, $config );
	}
