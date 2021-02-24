<?php

	$roc = \Rhubarb\RedisCache\Plugin::instance();

	$redis_client 	= $roc->get_redis_client_name();
	$redis_prefix 	= $roc->get_redis_prefix();
	$redis_maxttl 	= $roc->get_redis_maxttl();
	$redis_version 	= $roc->get_redis_version();
	$diagnostics 	= $roc->get_diagnostics();


	// redis drop-in
	if ( ! $roc->object_cache_dropin_exists() ):
        $drop_in = "Not installed";
	elseif ( $roc->object_cache_dropin_outdated() ):
		$drop_in = "Outdated";
	else:
		$drop_in = $roc->validate_object_cache_dropin() ? "Valid" : "Invalid";
	endif;


    // redis connection cluster                        
	if( isset($diagnostics['cluster']) && ! empty($diagnostics['cluster'])):
		$cluster = "<ul>";
		foreach ( $diagnostics['cluster'] as $node ){
			$cluster.='<li><code>'.esc_html( $node ).'</code></li>';
		}
		$cluster.= "</ul>";
	endif;


	// redis connection shards   
	if( isset($diagnostics['shards']) && ! empty($diagnostics['shards'])):
		$shards = "<ul>";
		foreach ( $diagnostics['shards'] as $node ){
			$shards.='<li><code>'.esc_html( $node ).'</code></li>';
		}
		$shards.= "</ul>";
	endif;


	// redis connection servers   
	if( isset($diagnostics['servers']) && ! empty($diagnostics['servers'])):
		$servers = "<ul>";
		foreach ( $diagnostics['servers'] as $node ){
			$servers.='<li><code>'.esc_html( $node ).'</code></li>';
		}
		$servers.= "</ul>";
	endif;

	$info = [
		"Instalação" => [
			"Versão Plugin" => \Lanci\App::$version,
			"Site"	=> get_option("siteurl"),
			"Alias"	=> LANCI_SERVER_ALIAS,
			'Cache Zone' => get_option("nginx_cache_path"),
			'Cache Zone Status' => is_writable(get_option("nginx_cache_path")) ? "ready" : "<span style=\"color:red\">not writeable</span>"
		],
		"Redis" => [
			'Client' 		=> @$redis_client,
			'Key Prefix' 	=> @trim( $redis_prefix ),
			'Drop-in'		=> $drop_in,
			'Disabled'		=> defined( 'WP_REDIS_DISABLED' ) && WP_REDIS_DISABLED ? "yes" : "no",
			'Max. TTL'		=> @$redis_maxttl . ( isset($redis_maxttl) && !is_int( $redis_maxttl) && !ctype_digit($redis_maxttl) ? ' - This doesn’t appear to be a valid number' : "" )
		],
		"Redis Connection" => [
			"Status"		=> $roc->get_status(),
			"Host"			=> esc_html( @$diagnostics['host'] ),
			"Cluster"		=> @$cluster,
			"Shards"		=> @$shards,
			"Servers"		=> @$servers,
			"Port"			=> esc_html( @$diagnostics['port'] ),
			"Username"		=> esc_html( @$diagnostics['password'][0] ),
			"Database"		=> @$diagnostics['database'],
			"Con. Timeout"	=> @$diagnostics['timeout'],
			"Read Timeout"	=> @$diagnostics['read_timeout'],
			"Retry Inter."	=> @$diagnostics['retry_interval'],
			"Redis Version"	=> @$redis_version 
		]
	];
?>

<?php foreach($info as $title => $i) : ?>
<div class="card">
<h2 class="title"><?php echo $title ?></h2>
<table class="form-table">
	<?php 
		foreach($i as $key => $value) : 
			// if(empty(trim($value)))
			// 	continue;
	?>
	<tr>
        <td><?php echo $key ?>: </td>
        <td><code><?php echo $value ?></code></td>
    </tr>
	<?php endforeach; ?>
</table>
</div>
<?php endforeach; ?>




 