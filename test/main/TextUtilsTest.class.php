<?php
	/* $Id$ */
	
	final class TextUtilsTest extends UnitTestCase
	{
		public function testFriendlyFileSize()
		{
			$units = array('', 'k' , 'M', 'G', 'T', 'P');
			
			$this->assertEqual(TextUtils::friendlyFileSize(0), '0');
			$this->assertEqual(TextUtils::friendlyFileSize(1024), '1k');
			$this->assertEqual(TextUtils::friendlyFileSize(812), '812');
			
			for ($i = 0; $i < 6; ++$i) {
				$this->assertEqual(
					TextUtils::friendlyFileSize(2 * pow(1024, $i)), '2'.$units[$i]
				);
			}
			
			$this->assertEqual(
				TextUtils::friendlyFileSize(2 * pow(1024, 6)), '2048'.$units[5]
			);
		}
		
		public function testNormalizeUri()
		{
			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com:/'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com:80/'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://wWw.exaMPLE.COm/'),
				'http://www.example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('htTP://example.com/'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/foo%7bbar'),
				'http://example.com/foo%7Bbar'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/foo%2Dbar%2dbaz%2cqaz'),
				'http://example.com/foo-bar-baz%2Cqaz'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/b/c/./../../g'),
				'http://example.com/a/g'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/mid/content=5/../6'),
				'http://example.com/mid/6'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/./b'),
				'http://example.com/a/b'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/../b'),
				'http://example.com/b'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/../b'),
				'http://example.com/b'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/.'),
				'http://example.com/a/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/..'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/./'),
				'http://example.com/a/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('http://example.com/a/../'),
				'http://example.com/'
			);

			$this->assertEqual(
				TextUtils::normalizeUri('hTTPS://a/./b/../b/%63/%7bfoo%7d'),
				'https://a/b/c/%7Bfoo%7D'
			);
		}
		
		public function testHex2Binary()
		{
			$this->assertEqual(
				'     ',
				TextUtils::hex2Binary('2020202020')
			);
		}
	}
?>