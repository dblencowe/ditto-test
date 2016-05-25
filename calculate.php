#!/usr/bin/env php
<?php

require __DIR__ . '/ditto/classes/DateCalculator.php';

// Specify default name
$file = 'export.csv';

// Dirty validation to get rid of paths:
if (!empty($argv[1])) {
	if (is_string($argv[1])) {
		$explodedPath = explode('/', $argv[1]);
		$file = array_pop($explodedPath);

		// Check the specified file extension is CSV
		$fileNameParts = explode('.', $file);
		$extension = array_pop($fileNameParts);
		if ($extension !== 'csv') {
			exit('Please specify a filename ending in .csv');
		}
	}
}

echo "Beginning generation..." . PHP_EOL;
$calculator = new Ditto_DateCalculator();

$fp = fopen($file, 'w');
foreach ($calculator->paydays as $fields) {
	fputcsv($fp, $fields);
}
fclose($fp);

echo "Generation finished... Results saved in $file" . PHP_EOL;
exit();
