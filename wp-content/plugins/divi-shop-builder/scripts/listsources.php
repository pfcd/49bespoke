<?php
// phpcs:ignoreFile -- this is an internal use file and excluded from release
php_sapi_name() === 'cli' || die('Only cli execution is supported.');

$inFiles = [__DIR__.'/builder-bundle.js', __DIR__.'/frontend-bundle.js'];
$sourceDirs = [];

foreach ($inFiles as $file) {
	
	$fileContents = file_get_contents($file);
	preg_match_all('/\!\*\*\* (.+) \*\*\*\!/', $fileContents, $foundPaths, PREG_PATTERN_ORDER);
	
	$foundPaths = $foundPaths[1];
	
	foreach ($foundPaths as $path) {
		if (substr($path, 0, 6) === 'multi ') {
			$path = array_slice( explode(' ', $path), 1 );
			foreach ($path as $subPath) {
				$sourceDirs[] = dirname($subPath);
			}
		} else {
			$sourceDirs[] = dirname($path);
		}
	}
}

$sourceDirs = array_unique($sourceDirs);
sort($sourceDirs);
echo(implode("\n", $sourceDirs));
echo("\n\n");

foreach ($sourceDirs as $sourceDir) {
	if (substr($sourceDir, 0, 15) == './node_modules/') {
		$module = (explode('/', $sourceDir))[2];
		echo( $module.' license'."\n".'============================================='."\n\n" );
		if (file_exists(__DIR__.'/../node_modules/'.$module.'/LICENSE')) {
			echo(file_get_contents(__DIR__.'/../node_modules/'.$module.'/LICENSE'));
		} else {
			echo('Needs manual review');
		}
		
		echo("\n\n");
	}
}