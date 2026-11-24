<?php

use Dev4Press\Generator\Title\Random;

require_once __DIR__ . '/../Random.php';

header( 'Content-Type: text/plain; charset=UTF-8' );

$generator = new Random();
$generator->set_list( 'words', array( 'Garden', 'Studio', 'Workshop', 'Collection', 'Project' ) );
$generator->set_list( 'prefixes', array( 'The', 'A New' ) );
$generator->set_list( 'suffixes', array( 'Guide', 'Preview' ) );

echo 'Title with a prefix and suffix', PHP_EOL;
echo $generator->generate_title( 2 ), PHP_EOL, PHP_EOL;

echo 'Title from the word list alone', PHP_EOL;
echo $generator->generate_title( 2, false, false ), PHP_EOL, PHP_EOL;

echo 'Batch of titles', PHP_EOL;
foreach ( $generator->generate_titles( 5, 2 ) as $title ) {
    echo $title, PHP_EOL;
}

echo PHP_EOL, 'Structured titles without suffixes', PHP_EOL;
print_r( $generator->generate_titles( 3, 1, 'associative_array', true, false ) );

echo PHP_EOL, 'JSON titles', PHP_EOL;
$generator->output( 'json' );
echo $generator->generate_titles( 3, 2 ), PHP_EOL;
