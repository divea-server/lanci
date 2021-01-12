<?php

namespace Lanci;

class Cache
{
	static function init()
	{
		// adicionando eventos para limpar cache automaticamente
		self::autoFlush();
	}

	static function enable()
	{
		// habilitando redis
		self::redisEnable();

		// cache_zone do nginx proxy
		add_option("nginx_cache_path", sprintf("/home/%s/cache_zone", LANCI_SERVER_ALIAS));
	}

	static function deactivate($plugin)
	{
		$redisPlugin = \Rhubarb\RedisCache\Plugin::instance();
		$redisPlugin->on_deactivation($plugin);
		delete_option("nginx_cache_path");
	}

	static function flush() 
	{
		static $completed = false;
		if ( ! $completed ) {

			// limpa o redis
			self::redisFlush();

			// limpa o nginx
			self::nginxCacheFlush();

			// limpa o autoptimize
			self::autoptimizeFlush();
			
			$completed = true;
		}
	}

	static function autoFlush()
	{
		foreach([
			'save_post', 
			'edit_post', 
			'delete_post',
			'wp_trash_post', 
			'clean_post_cache', 
			'trackback_post', 
			'pingback_post', 
			'comment_post', 
			'edit_comment', 
			'delete_comment', 
			'wp_set_comment_status',
			'switch_theme', 
			'wp_update_nav_menu', 
			'edit_user_profile_update'
		] as $action) {
			
			if(did_action($action)) 
				Cache::flush();
			else 
				add_action( $action, '\Lanci\Cache::flush' );
		}
	}

	static function redisCheck()
	{
		return (bool) phpversion( 'redis' );
	}

	private static function redisEnable()
	{
		copy(LANCI_PATH . '/vendor/redis-cache/includes/object-cache.php', WP_CONTENT_DIR . '/object-cache.php');
	}

	private static function redisDisable()
	{
		unlink(WP_CONTENT_DIR . '/object-cache.php');
	}

	private static function redisFlush()
	{
		global $wp_object_cache;
		return $wp_object_cache->flush(0);
	}

	private static function nginxCacheFlush()
	{
		$nginxPlugin = new \NginxCache;
		return $nginxPlugin->purge_zone_once();
	}

	private static function autoptimizeFlush()
	{
		if( ! class_exists("\autoptimizeCache"))
			return;

		\autoptimizeCache::clearall();
    	function rrmdir($src) {
		    $dir = opendir($src);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            $full = $src . '/' . $file;
		            if ( is_dir($full) ) {
		                rrmdir($full);
		            }
		            else {
		                unlink($full);
		            }
		        }
		    }
		    closedir($dir);
		    rmdir($src);
		}
		rrmdir(WP_CONTENT_DIR."/cache/autoptimize");
	}
}