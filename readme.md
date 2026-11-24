# Random Titles Generator

`Dev4Press\Generator\Title\Random` generates titles from caller-supplied lists of words, prefixes, and suffixes. Use it to create demo post titles, sample products, or other text built from a small vocabulary.

## Requirements

- PHP 8.0 or newer

## Run the demo

From the repository root, run `php demo/index.php`. The demo also works through a PHP-enabled web server. [Demo script](demo/index.php)

## Usage

Run these examples from a PHP file alongside `Random.php`.

### Create a word list and generate a title

Use `set_list()` with `words` for the title body. The optional `prefixes` and `suffixes` lists add one entry each when enabled.

```php
<?php

use Dev4Press\Generator\Title\Random;

require_once __DIR__ . '/Random.php';

$generator = new Random();
$generator->set_list( 'words', array( 'Garden', 'Studio', 'Workshop', 'Collection' ) );
$generator->set_list( 'prefixes', array( 'The', 'A New' ) );
$generator->set_list( 'suffixes', array( 'Guide', 'Preview' ) );

echo $generator->generate_title( 2 ), PHP_EOL;
echo $generator->generate_title( 2, false, false ), PHP_EOL;
```

The generator picks distinct entries from the word list up to the requested count and keeps their order from the original list. With an empty list or a nonpositive word count, the title body is empty and enabled prefixes and suffixes still apply.

### Generate a batch with structured fields

Use the same `$generator` instance. Set `with_suffix` to `false` to omit suffixes from this batch.

```php
$titles = $generator->generate_titles(
    num: 3,
    words: 2,
    output: 'associative_array',
    with_suffix: false
);

foreach ( $titles as $title ) {
    echo trim( $title['prefix'] . ' ' . $title['title'] ), PHP_EOL;
}
```

## Output formats

| Format | Result |
| --- | --- |
| `array` (default) | An array of complete title strings. |
| `associative_array` | An array of records with `prefix`, `title`, and `suffix` keys. The `title` field contains only the word list selection. |
| `json` | A JSON string containing those records, or `false` if encoding fails. |

`output()` sets the default format for the instance. `generate_title()` always returns a single string. A nonpositive count passed to `generate_titles()` returns an empty PHP array in every format.

## License

[MIT](license.txt)
