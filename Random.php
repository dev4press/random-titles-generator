<?php

namespace Dev4Press\Generator\Title;

use Exception;

class Random {
	protected $output = 'array';
	protected $allowed_formats = array(
		'array',
		'json',
		'associative_array'
	);
	private $lists = array(
		'prefixes' => array(),
		'suffixes' => array(),
		'words'    => array()
	);

	public function __construct() {
	}

	public static function instance() : Random {
		static $_instance = false;

		if ( $_instance === false ) {
			$_instance = new Random();
		}

		return $_instance;
	}

	/**
	 * @throws \Exception
	 */
	public function output( string $output = 'array' ) : Random {
		if ( ! in_array( $output, $this->allowed_formats ) ) {
			throw new Exception( 'Unrecognized format.' );
		}

		$this->output = $output;

		return $this;
	}

	public function set_list( string $name, array $list ) {
		$this->lists[ $name ] = $list;
	}

	public function generate_title( int $words = 2, bool $with_prefix = true, bool $with_suffix = true ) : string {
		$list = $this->generate_titles( 1, $words, 'array', $with_prefix, $with_suffix );

		return $list[0];
	}

	public function generate_titles( int $num = 1, int $words = 2, string $output = '', bool $with_prefix = true, bool $with_suffix = true ) {
		if ( $num < 1 ) {
			return array();
		}

		$results = array();

		$output = empty( $output ) ? $this->output : $output;

		for ( $i = 0; $i < $num; $i ++ ) {
			$prefix = $suffix = '';

			if ( $with_prefix && ! empty( $this->lists['prefixes'] ) ) {
				$_key   = array_rand( $this->lists['prefixes'] );
				$prefix = $this->lists['prefixes'][ $_key ];
			}

			if ( $with_suffix && ! empty( $this->lists['suffixes'] ) ) {
				$_key   = array_rand( $this->lists['suffixes'] );
				$suffix = $this->lists['suffixes'][ $_key ];
			}

			$title = $this->get_words( $words );

			switch ( $output ) {
				case 'array':
					$results[] = trim( $prefix . ' ' . $title . ' ' . $suffix );
					break;
				case 'json':
				case 'associative_array':
					$results[] = array( 'prefix' => $prefix, 'title' => $title, 'suffix' => $suffix );
					break;
			}
		}

		if ( $output == 'json' ) {
			$results = json_encode( $results );
		}

		return $results;
	}

	private function get_words( int $words = 2 ) : string {
		$list = array();
		$keys = array_rand( $this->lists['words'], $words );

		foreach ( $keys as $key ) {
			$list[] = $this->lists['words'][ $key ];
		}

		return join( ' ', $list );
	}
}
