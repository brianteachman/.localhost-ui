<?php
/**
 * Simple localhost interface.
 * 
 * @author Brian Teachman, Teachman Web Development <me@briant.me>
 * @license WTFPL <http://sam.zoy.org/wtfpl/COPYING>
 */
if ( ! is_dir('.localhost-ui')) {
	chdir('.localhost-ui');
	header("Location: README.md");
}
$runtime_path = function($path) {
	$path = realpath(__DIR__).DIRECTORY_SEPARATOR. $path;
	if ( ! strpos(strtolower(PHP_OS), 'win') !== false) {
	    return str_replace('/', '\\', $path);
	}
	return $path;
};
require $runtime_path('.localhost-ui/runtime.php');
?>
