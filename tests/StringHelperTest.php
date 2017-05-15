<?php

use Zver\StringHelper;

class StringHelperTest extends PHPUnit\Framework\TestCase
{

    use \Zver\Package\Helper;

    public function testSetFirstLastPart()
    {
        $test = "1_2_3_4 5 6 7 8";

        $this->foreachSame([
                               [
                                   StringHelper::load($test)
                                               ->setFirstPart('|')
                                               ->get(),
                                   $test,
                               ],
                               [
                                   StringHelper::load($test)
                                               ->setLastPart('|')
                                               ->get(),
                                   $test,
                               ],
                               [
                                   StringHelper::load($test)
                                               ->setLastPart()
                                               ->get(),
                                   '8',
                               ],
                               [
                                   StringHelper::load($test)
                                               ->setLastPart('_')
                                               ->get(),
                                   '4 5 6 7 8',
                               ],
                               [
                                   StringHelper::load($test)
                                               ->setFirstPart()
                                               ->get(),
                                   '1_2_3_4',
                               ],
                               [
                                   StringHelper::load($test)
                                               ->setFirstPart('_')
                                               ->get(),
                                   '1',
                               ],
                           ]);
    }

    public function testGetColumns()
    {

        $tests = [
            "
         
         
         drwxrwxr-x  3 jm72 jm72  4096      2  16:39       my Dir
         
         
         -rw-rw-r--  1 jm72 jm72   257 Nov  2     16:39    my Fi l e
         
         
        ",
            "
         jm72 jm72  4096      2
         jm72 jm72   257
        ",
            "
         jm72 jm72
        ",
            "
         jm72
        ",
            "",
            "
         jm72 jm72 jm 72
         jm72 jm72 jm72
        ",
        ];

        $expectedResults = [
            [
                ['drwxrwxr-x', '-rw-rw-r--'],
                ['3', '1'],
                ['jm72', 'jm72'],
                ['jm72', 'jm72'],
                ['4096', '257'],
                ['', 'Nov'],
                ['2', '2'],
                ['16:39', '16:39'],
                ['my', 'my'],
                ['Dir', 'Fi l'],
                ['', 'e'],
            ],
            [
                ['jm72', 'jm72'],
                ['jm72', 'jm72'],
                ['4096', '257'],
                ['2', ''],
            ],
            [
                ['jm72'],
                ['jm72'],
            ],
            [
                ['jm72'],
            ],
            [],
            [
                ['jm72', 'jm72'],
                ['jm72', 'jm72'],
                ['jm 72', 'jm72'],
            ],
        ];

        foreach ($tests as $index => $test) {
            $this->assertSame(Str($test)->getColumns(), $expectedResults[$index]);
        }

    }

    public function testStringLoadAndGet()
    {

        $toLoad = [
            'string',
            [
                'Arr',
                'ay',
            ],
            Str('Superstring'),
        ];

        $result = 'stringArraySuperstring';

        $this->foreachSame(
            [
                [Str($toLoad)->get(), $result],
                [Str('string')->get(), 'string'],
                [Str()->get(), ''],
                [
                    Str()
                        ->set('')
                        ->get(),
                    '',
                ],
                [
                    Str()
                        ->set($toLoad)
                        ->get(),
                    $result,
                ],
                [Str('str') . '', 'str'],
            ]
        );

        $originals = [
            ['', ''],
            [' ', ' '],
            ['str', 'str'],
            ['stR', 'stR'],
            ['sTR', 'sTR'],
            ['STR', 'STR'],
            ['Str', 'Str'],
            [['Str'], 'Str'],
            [['S', 'T', 'R'], 'STR'],
            [['S', ['T', ['R']]], 'STR'],
        ];

        foreach ($originals as $original) {
            $this->assertInstanceOf(StringHelper::class, Str($original));

            $this->assertSame(Str($original[0])->get(), $original[1]);

            $this->foreachSame(
                [
                    [
                        Str()
                            ->set($original[0])
                            ->get(),
                        $original[1],
                    ],
                ]
            );

        }
    }

    public function testIsUpperCase()
    {
        $this->foreachTrue(
            [
                Str('HIGH')->isUpperCase(),
                Str('L')->isUpperCase(),
                Str('')->isUpperCase(),
                Str(' ')->isUpperCase(),
                Str('098765432')->isUpperCase(),
            ]
        );

        $this->foreachFalse(
            [
                Str('lH')->isUpperCase(),
                Str('lH000')->isUpperCase(),
                Str('lHg000')->isUpperCase(),
                Str('lHgj00')->isUpperCase(),
                Str('lowercase')->isUpperCase(),
            ]
        );

    }

    public function testIsLowerCase()
    {
        $this->foreachTrue(
            [
                Str('')->isLowerCase(),
                Str(' ')->isLowerCase(),
                Str('098lower')->isLowerCase(),
                Str('lower')->isLowerCase(),
                Str('098765432')->isLowerCase(),
                Str('l')->isLowerCase(),
            ]
        );

        $this->foreachFalse(
            [
                Str('HIGH')->isLowerCase(),
                Str('High')->isLowerCase(),
                Str('hiGh')->isLowerCase(),
                Str('L')->isLowerCase(),
            ]
        );

    }

    public function testIsTitleCase()
    {
        $this->foreachTrue(
            [
                Str('')->isTitleCase(),
                Str(' ')->isTitleCase(),
                Str('098 Lower')->isTitleCase(),
                Str('Lower')->isTitleCase(),
                Str('098765432')->isTitleCase(),
                Str('L')->isTitleCase(),
                Str('Ll')->isTitleCase(),
                Str('Lower Case None')->isTitleCase(),
            ]
        );

        $this->foreachFalse(
            [
                Str('lower')->isTitleCase(),
                Str('Lower case second')->isTitleCase(),
                Str('l')->isTitleCase(),
                Str('HIGH')->isTitleCase(),
            ]
        );

    }

    public function testOriginSaves()
    {
        $originText = 'OrIGin';
        $origin = Str($originText);

        $origin->getLevenshteinDistance('dsdsd');
        $origin->getPreview();
        $origin->getPreview(3);
        $origin->getPreview(5);
        $origin->getPreview(500);
        $origin->getMatches('\w+');
        $origin->getLastChars(10);
        $origin->getParts();
        $origin->getFirstPart();
        $origin->getLastPart();
        $origin->getFirstChars(10);
        $origin->getPosition('s');
        $origin->getPositionIgnoreCase('s');
        $origin->getPositionFromEnd('s');
        $origin->getPositionFromEndIgnoreCase('s');
        $origin->getSplittedBy('\w+');

        $origin->isTitleCase();
        $origin->isLowerCase();
        $origin->isUpperCase();
        $origin->isEmpty();
        $origin->isEquals('dsdsdsd');
        $origin->isSerialized();
        $origin->isJSON();
        $origin->isMatch('\w');
        $origin->isEquals('str');
        $origin->isEqualsSome(['str']);
        $origin->isEndsWith('');
        $origin->isEndsWithIgnoreCase('');
        $origin->isStartsWith('');
        $origin->isStartsWith('dr');
        $origin->isStartsWith('dragon');
        $origin->isContain('dr');
        $origin->isContainIgnoreCase('dr');
        $origin->isStartsWithIgnoreCase('');

        $this->assertSame($origin->get(), $originText);
    }

    public function testUcFirst()
    {

        $this->foreachSame(
            [
                [
                    Str('привеТ')
                        ->toUpperCaseFirst()
                        ->get(),
                    'Привет',
                ],
                [
                    Str('Привет')
                        ->toUpperCaseFirst()
                        ->get(),
                    'Привет',
                ],
                [
                    Str('')
                        ->toUpperCaseFirst()
                        ->get(),
                    '',
                ],
                [
                    Str()
                        ->toUpperCaseFirst()
                        ->get(),
                    '',
                ],
            ]
        );
    }

    public function testLen()
    {
        $this->foreachSame(
            [
                [Str('helloпривет')->getLength(), 11],
                [Str('а')->getLength(), 1],
                [Str('привет日本語')->getLength(), 9],
                [Str('')->getLength(), 0],
                [Str('helloпривет')->getLength(), 11],
                [Str('а')->getLength(), 1],
                [Str('привет日本語')->getLength(), 9],
                [Str('')->getLength(), 0],
            ]
        );
    }

    public function testSubstring()
    {

        $this->foreachSame(
            [
                [
                    Str('h')
                        ->substring()
                        ->get(),
                    'h',
                ],
                [
                    Str('helloстрока')
                        ->substring()
                        ->get(),
                    'helloстрока',
                ],
                [
                    Str('hh')
                        ->substring(1)
                        ->get(),
                    'h',
                ],
                [
                    Str('привет')
                        ->substring(1)
                        ->get(),
                    'ривет',
                ],
                [
                    Str('привет')
                        ->substring(2, 2)
                        ->get(),
                    'ив',
                ],
                [
                    Str('hh')
                        ->substring(0)
                        ->get(),
                    'hh',
                ],
                [
                    Str('1234567890')
                        ->substring(-3)
                        ->get(),
                    '890',
                ],
                [
                    Str('1234567890')
                        ->substring(-30)
                        ->get(),
                    '1234567890',
                ],
                [
                    Str('1234567890')
                        ->substringFromEnd(30)
                        ->get(),
                    '1234567890',
                ],
                [
                    Str('1234567890')
                        ->substringFromEnd(3)
                        ->get(),
                    '890',
                ],
                [
                    Str('1234567890')
                        ->substring(-30, 90)
                        ->get(),
                    '1234567890',
                ],
                [
                    Str('1234567890')
                        ->substring(3, 3)
                        ->get(),
                    '456',
                ],
                [
                    Str('1234567890')
                        ->substring(3, 13)
                        ->get(),
                    '4567890',
                ],
                [
                    Str('superstring')
                        ->getFirstChars(0),
                    '',
                ],
                [
                    Str('superstring')
                        ->getFirstChars(-5),
                    'tring',
                ],
                [
                    Str('superstring')
                        ->getFirstChars(5),
                    'super',
                ],
                [
                    Str('superstring')
                        ->getFirstChars(500),
                    'superstring',
                ],
                [
                    Str('superstring')
                        ->getFirstChars(-500),
                    'superstring',
                ],
                [
                    Str('superstring')
                        ->getLastChars(6),
                    'string',
                ],
                [
                    Str('superstring')
                        ->getLastChars(-5),
                    'super',
                ],
                [
                    Str('superstring')
                        ->getLastChars(0),
                    '',
                ],
                [
                    Str('superstring')
                        ->getLastChars(600),
                    'superstring',
                ],
                [
                    Str('superstring')
                        ->getLastChars(-600),
                    'superstring',
                ],
            ]
        );
    }

    public function testConcatAppendPrepend()
    {
        $this->foreachSame(

            [
                [
                    Str('l')
                        ->concat(
                            [
                                'e',
                                't',
                                Str('ter'),
                                [
                                    ' ',
                                    'for',
                                    [
                                        ' ',
                                        'm',
                                        'e',
                                    ],
                                ],
                            ]
                        )
                        ->get(),
                    'letter for me',
                ],
                [
                    Str('l')
                        ->concat('')
                        ->get(),
                    'l',
                ],
                [
                    Str('1')
                        ->concat('1')
                        ->append('2')
                        ->prepend('3')
                        ->get(),
                    '3112',
                ],
                [
                    Str('и')
                        ->concat('в')
                        ->append('ет')
                        ->prepend('пр')
                        ->get(),
                    'привет',
                ],
            ]
        );
    }

    public function testEqualsSomeAndEqualsIgnoreCase()
    {
        $values = ['str', 'count', 'me', 'привет'];
        $valuesIgnoreCase = ['StR', 'coUNt', 'mE', 'приВет'];
        $valuesStrict = ['str', null];
        $valuesEmpty = [];

        $testDataEqualsSome = [
            ['str' => 'str', 'values' => $values, 'result' => true],
            ['str' => 'me', 'values' => $values, 'result' => true],
            ['str' => 'count', 'values' => $values, 'result' => true],
            ['str' => 'count2', 'values' => $values, 'result' => false],
            ['str' => 'Me', 'values' => $values, 'result' => false],
            ['str' => 'ME', 'values' => $values, 'result' => false],
            ['str' => 'sTr', 'values' => $values, 'result' => false],
            ['str' => 'me', 'values' => $valuesIgnoreCase, 'result' => false],
            ['str' => 'count', 'values' => $valuesIgnoreCase, 'result' => false],
            ['str' => 'str', 'values' => $valuesIgnoreCase, 'result' => false],
            ['str' => 'str', 'values' => $valuesStrict, 'result' => true],
            ['str' => '', 'values' => $valuesStrict, 'result' => true],//null=''
            ['str' => 'приВет', 'values' => $values, 'result' => false],//null=''
        ];

        $testDataEqualsSomeIgnoreCase = [
            ['str' => 'str', 'values' => $values, 'result' => true],
            ['str' => 'me', 'values' => $values, 'result' => true],
            ['str' => 'count', 'values' => $values, 'result' => true],
            ['str' => 'count2', 'values' => $values, 'result' => false],
            ['str' => 'Me', 'values' => $values, 'result' => true],
            ['str' => 'ME', 'values' => $values, 'result' => true],
            ['str' => 'sTr', 'values' => $values, 'result' => true],
            ['str' => 'me', 'values' => $valuesIgnoreCase, 'result' => true],
            ['str' => 'count', 'values' => $valuesIgnoreCase, 'result' => true],
            ['str' => 'str', 'values' => $valuesIgnoreCase, 'result' => true],
            ['str' => 'str', 'values' => $valuesStrict, 'result' => true],
            ['str' => '', 'values' => $valuesStrict, 'result' => true],//null=''
            ['str' => 'ПриВет', 'values' => $values, 'result' => true],//null=''
        ];

        foreach ($testDataEqualsSome as $testData) {
            $this->assertEquals(
                $testData['result'], Str($testData['str'])->isEqualsSome($testData['values'])
            );
        }

        foreach ($testDataEqualsSomeIgnoreCase as $testData) {
            $this->assertEquals(
                $testData['result'], Str($testData['str'])->isEqualsSomeIgnoreCase($testData['values'])
            );
        }

    }

    public function testIsMatchTest()
    {

        $this->foreachTrue(
            [
                Str(' 3521')->isMatch('\d+'),
                Str('3521')->isMatch('^\d+$'),
                Str('3521')->isMatch('\d\d\d\d'),
                Str('3521')->isMatch('\d'),
                Str('стринг2' . PHP_EOL . 'CNhbyu22')->isMatch('\w+\s'),
                Str('стринг2' . PHP_EOL . 'CNhbyu22')->isMatch('[A-Z]+'),
                Str('стринг')->isMatch('^\w+$'),
            ]
        );

        $this->foreachFalse(
            [
                Str('')->isMatch('/d+'),
                Str(' 3521')->isMatch('^\d+$'),
                Str('')->isMatch('\d'),
                Str('2' . PHP_EOL . 'CN22')->isMatch('[a-z]+'),
            ]
        );

    }

    public function testEmpty()
    {
        $this->foreachTrue(
            [
                Str('  ... ')->isEmpty(),
                Str('')->isEmpty(),
                Str('      +_)(*&^%$#@!   _')->isEmpty(),
                Str('__')->isEmpty(),
                Str("\n\n---\n....\n!@#$#%#^#&+_)(*&#$%^&*(")->isEmpty(),
                Str('       _   ')->isEmpty(),
                Str('       _   ')->isEmpty(),
            ]
        );

        $this->foreachFalse(
            [
                Str('0')->isEmpty(),
                Str('  f     _   ')->isEmpty(),
                Str('  fdfвава3     _   ')->isEmpty(),
                Str('  4     _   ')->isEmpty(),
                Str('  привет     _   ')->isEmpty(),
                Str('  п     _   ')->isEmpty(),
                Str('п')->isEmpty(),
                Str('0')->isEmpty(),
                Str('  а     _   ')->isEmpty(),
                Str('  f     _   ')->isEmpty(),
                Str('привет')->isEmpty(),
            ]
        );

    }

    public function testCompare()
    {

        $this->foreachTrue([Str('qwerty')->isEqualsIgnoreCase('QweRty')]);

        $this->foreachFalse(
            [
                Str('qwerty')->isEquals('QweRty'),
                Str('qwerty')->isEquals('dw3ff3f'),
            ]
        );

    }

    public function testIsStartsWith()
    {

        $this->foreachTrue(
            [
                Str('стартс')->isStartsWith(''),
                Str('стартс')->isStartsWith('с'),
                Str('стартс')->isStartsWithIgnoreCase('С'),
                Str('Стартс')->isStartsWith('Стар'),
                Str('стартс')->isStartsWith('стартс'),
                Str('стартс')->isStartsWithIgnoreCase('старТс'),
                Str('стартс')->isStartsWith(''),
                Str('стартс')->isStartsWithIgnoreCase(''),
            ]
        );

        $this->foreachFalse(
            [
                Str('стартс')->isStartsWith('стартсс'),
                Str('стартс')->isStartsWith('кпуцйайайцуайца'),
                Str('стартс')->isStartsWith('кп'),
                Str('стартс')->isStartsWith('у'),
                Str('')->isStartsWith('кп'),
                Str('')->isStartsWithIgnoreCase('кп'),
            ]
        );

    }

    public function testIsEndsWith()
    {

        $this->foreachTrue(
            [
                Str('стартс')->isEndsWith(''),
                Str('стартс')->isEndsWithIgnoreCase('стАртС'),
                Str('zzzsdfsdf')->isEndsWith(''),
                Str('zzzsdfsdf')->isEndsWithIgnoreCase(''),
                Str('стартс')->isEndsWith('стартс'),
                Str('стартс')->isEndsWithIgnoreCase('С'),
            ]
        );

        $this->foreachFalse(
            [
                Str('стартс')->isEndsWith('С'),
                Str('стартс')->isEndsWith('s'),
                Str('стартс')->isEndsWith('сстартс'),
                Str('стартс')->isEndsWithIgnoreCase('zzzsdfsdf'),
                Str('')->isEndsWith('zzzsdfsdf'),
                Str('')->isEndsWithIgnoreCase('zzzsdfsdf'),
            ]
        );

    }

    public function testRandomCase()
    {

        $this->assertNotEquals(
            Str('invertcaseofmybeautifulstringinvertcaseofmybeautifulstring')
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->get(), 'invertcaseofmybeautifulstringinvertcaseofmybeautifulstring'
        );

        $this->assertEquals(
            Str('invertcaseofmybeautifulstringinvertcaseofmybeautifulstring')
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toRandomCase()
                ->toLowerCase()
                ->get(), 'invertcaseofmybeautifulstringinvertcaseofmybeautifulstring'
        );

    }

    public function testSetBeginning()
    {
        $this->foreachSame(
            [
                [
                    Str()
                        ->ensureBeginningIs('/привет')
                        ->get(),
                    '/привет',
                ],
                [
                    Str('/суперпривет')
                        ->ensureBeginningIs('/суперпривет')
                        ->get(),
                    '/суперпривет',
                ],
                [
                    Str('/привет')
                        ->ensureBeginningIs('/приветW')
                        ->get(),
                    '/приветW/привет',
                ],
            ]
        );

    }

    public function testSetEnding()
    {
        $this->foreachSame(
            [
                [
                    Str()
                        ->ensureEndingIs('/привет')
                        ->get(),
                    '/привет',
                ],
                [
                    Str('/суперпривет')
                        ->ensureEndingIs('/суперпривет')
                        ->get(),
                    '/суперпривет',
                ],
                [
                    Str('/привет')
                        ->ensureEndingIs('/приветW')
                        ->get(),
                    '/привет/приветW',
                ],
            ]
        );

    }

    public function testJSON()
    {

        $this->foreachSame(
            [
                [
                    Str(json_encode('string'))
                        ->fromJSON()
                        ->get(),
                    'string',
                ],
                [
                    Str('string')
                        ->fromJSON()
                        ->get(),
                    '',
                ],
                [
                    Str('')
                        ->fromJSON()
                        ->get(),
                    '',
                ],
                [
                    Str('')
                        ->toJSON()
                        ->get(),
                    '""',
                ],
                [
                    Str('string')
                        ->toJSON()
                        ->get(),
                    '"string"',
                ],
            ]
        );

    }

    public function testSerialization()
    {
        $str = Str('string');
        $serialized = serialize($str);
        $unserialized = unserialize($serialized);
        $this->assertEquals($unserialized->get(), $str->get());
    }

    public function testEntities()
    {
        $this->foreachSame(
            [
                [
                    Str('<img src="/e.png" />')
                        ->toHTMLEntities()
                        ->get(),
                    '&lt;img src=&quot;/e.png&quot; /&gt;',
                ],
                [
                    Str('&lt;img src=&quot;/e.png&quot; /&gt;')
                        ->fromHTMLEntities()
                        ->get(),
                    '<img src="/e.png" />',
                ],
                [
                    Str('<img src="/e.png" />')
                        ->toHTMLEntities()
                        ->removeEntities()
                        ->get(),
                    'img src=/e.png /',
                ],
            ]
        );
    }

    public function testURLCoding()
    {

        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        $this->foreachSame(
            [
                [
                    Str($url)
                        ->toURL()
                        ->get(),
                    'www.example.com%2Fadmin%3Fi%3D1%26ref%3Dhttp%3A%2F%2Fex.ru%2Fer',
                ],
                [
                    Str($url)
                        ->toURL()
                        ->fromURL()
                        ->get(),
                    $url,
                ],
            ]
        );
    }

    public function testUUE()
    {
        $this->foreachSame(
            [
                [
                    Str('ПриветCat')
                        ->toUUE()
                        ->remove('\s+')
                        ->get(),
                    '/T)_1@-"XT++0M=&"0V%T`',
                ],
                [
                    Str('ПриветCat')
                        ->toUUE()
                        ->fromUUE()
                        ->get(),
                    'ПриветCat',
                ],
            ]
        );
    }

    public function testBase64Coding()
    {

        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        $this->foreachSame(
            [
                [
                    Str($url)
                        ->toBase64()
                        ->get(),
                    'd3d3LmV4YW1wbGUuY29tL2FkbWluP2k9MSZyZWY9aHR0cDovL2V4LnJ1L2Vy',
                ],
                [
                    Str($url)
                        ->toBase64()
                        ->fromBase64()
                        ->get(),
                    $url,
                ],
            ]
        );
    }

    public function testUTF8Coding()
    {

        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/привет';
        $this->foreachSame(
            [
                [
                    Str($url)
                        ->toUTF8()
                        ->get(),
                    'www.example.com/admin?i=1&ref=http://ex.ru/Ð¿ÑÐ¸Ð²ÐµÑ',
                ],
                [
                    Str($url)
                        ->toUTF8()
                        ->fromUTF8()
                        ->get(),
                    $url,
                ],
            ]
        );
    }

    public function testSerialized()
    {
        error_reporting(E_ALL);

        $this->foreachFalse(
            [
                Str('прийцавйыв')->isSerialized(),
                Str('')->isSerialized(),
                Str('')
                    ->set([])
                    ->isSerialized(),

            ]
        );

        $this->foreachTrue(
            [
                Str(
                    serialize(
                        [
                            'd2fdqw',
                            '23asdasd',
                        ]
                    )
                )->isSerialized(),
            ]
        );
    }

    public function testPunycode()
    {

        $tests = [
            'домен.рф'                => 'xn--d1acufc.xn--p1ai',
            'домены.рф'               => 'xn--d1acufc5f.xn--p1ai',
            'пример.испытание'        => 'xn--e1afmkfd.xn--80akhbyknj4f',
            'ドメイン名例.jp'               => 'xn--eckwd4c7cu47r2wf.jp',
            'ウィキペディア.ドメイン名例.jp'       => 'xn--cckbak0byl6e.xn--eckwd4c7cu47r2wf.jp',
            '例え.テスト'                  => 'xn--r8jz45g.xn--zckzah',
            'bücher'                  => 'xn--bcher-kva',
            '日本japan'                 => 'xn--japan-1e1k07e',
            '日本Japan'                 => 'xn--Japan-1e1k07e',
            'abcdef'                  => 'abcdef',
            'abæcdöef'                => 'xn--abcdef-qua4k',
            'schön'                   => 'xn--schn-7qa',
            'ยจฆฟคฏข'                 => 'xn--22cdfh1b8fsa',
            '☺'                       => 'xn--74h',
            'правда'                  => 'xn--80aafi6cg',
            'Правда'                  => 'xn--80aafi6cg',
            'täst.de'                 => 'xn--tst-qla.de',
            'солнцеюга.рф'            => 'xn--80affxkeu7b8d.xn--p1ai',
            'хадыженский-пивзавод.рф' => 'xn----7sbbhbiediniblm8bzal5a4eug.xn--p1ai',
        ];

        foreach ($tests as $original => $punycode) {

            $this->foreachTrue(
                [
                    Str($original)
                        ->toPunyCode()
                        ->isEqualsIgnoreCase($punycode),
                    Str($punycode)
                        ->fromPunyCode()
                        ->isEqualsIgnoreCase($original),
                    Str($punycode)
                        ->fromPunyCode()
                        ->toPunyCode()
                        ->isEqualsIgnoreCase($punycode),
                    Str($original)
                        ->toPunyCode()
                        ->fromPunyCode()
                        ->isEqualsIgnoreCase($original),
                ]
            );
        }
    }

    public function testFill()
    {
        $this->foreachSame(
            [
                [
                    Str('x')
                        ->fillLeft('s', 5)
                        ->get(),
                    'ssssx',
                ],
                [
                    Str('ф')
                        ->fillLeft('ы', 5)
                        ->get(),
                    'ыыыыф',
                ],
                [
                    Str('x')
                        ->fillLeft(' ', 5)
                        ->get(),
                    '    x',
                ],
                [
                    Str('x')
                        ->fillLeft('s2', 5)
                        ->get(),
                    's2s2x',
                ],
                [
                    Str('x')
                        ->fillLeft('s', 1)
                        ->get(),
                    'x',
                ],
                [
                    Str('а')
                        ->fillLeft('п2', 5)
                        ->get(),
                    'п2п2а',
                ],
                [
                    Str('а')
                        ->fillLeft('п23', 5)
                        ->get(),
                    'п23па',
                ],
                [
                    Str('а')
                        ->fillLeft('п', 1)
                        ->get(),
                    'а',
                ],
                [
                    Str('а')
                        ->fillLeft('', -22)
                        ->get(),
                    'а',
                ],
                [
                    Str('а')
                        ->fillRight('п', 1)
                        ->get(),
                    'а',
                ],
                [
                    Str('а')
                        ->fillRight('п', 2)
                        ->get(),
                    'ап',
                ],
                [
                    Str('а')
                        ->fillRight('п23', 10)
                        ->get(),
                    'ап23п23п23',
                ],
                [
                    Str('а')
                        ->fillRight('', 2)
                        ->get(),
                    'а',
                ],
            ]
        );
    }

    public function testContains()
    {

        $this->foreachTrue(
            [
                Str('hello')->isContain('l'),
                Str('hello')->isContain('hello'),
                Str('привет')->isContain('привет'),
                Str('привет')->isContain('приве'),
                Str('привет')->isContain('прив'),
                Str('привет')->isContain('при'),
                Str('привет')->isContain('пр'),
                Str('привет')->isContain('п'),
                Str('привет')->isContain('и'),
                Str('привет')->isContain('е'),
                Str('hello')->isContainIgnoreCase('HELLO'),
                Str('hello')->isContain('o'),
                Str('hello')->isContain('h'),
                Str('hello')->isContainIgnoreCase('L'),
            ]
        );

        $this->foreachFalse(
            [
                Str('привет')->isContain('ф'),
                Str('привет')->isContain('ра'),
                Str('hello')->isContain('L'),
                Str('hello')->isContain('Ll'),
                Str('hello')->isContainIgnoreCase('z'),
            ]
        );
    }

    public function testGetPosition()
    {
        $this->foreachFalse(
            [
                Str('')->getPosition('l'),
                Str('')->getPositionFromEnd('l'),
                Str('')->getPositionIgnoreCase('l'),
                Str('')->getPositionFromEndIgnoreCase('l'),
            ]
        );

        $this->foreachSame(
            [
                [Str('Hello')->getPositionFromEnd('l'), 3],
                [Str('Hello')->getPositionFromEndIgnoreCase('l'), 3],
                [Str('Hello')->getPositionIgnoreCase('L'), 2],
                [Str('Hello')->getPositionFromEnd('h'), false],
                [Str('Hello')->getPositionFromEndIgnoreCase('H'), 0],
                [Str('Hello')->getPositionIgnoreCase('l'), 2],
                [Str('Hello')->getPositionFromEndIgnoreCase('L'), 3],
                [Str('Hello')->getPositionIgnoreCase('L'), 2],
                [Str('Hello')->getPositionIgnoreCase('F'), false],
            ]
        );
    }

    public function testSubstringCount()
    {
        $this->foreachSame(
            [
                [Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('s'), 4],
                [Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('.'), 3],
                [Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('?'), 1],
                [Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('!'), 2],
                [Str('')->getSubstringCount('dwd'), 0],
            ]
        );
    }

    public function testSplit()
    {
        $this->foreachSame(
            [
                [
                    Str('1 2 3 4 5        6 7 8 9_0')->getSplittedBy('[\s_]+'),
                    [
                        '1',
                        '2',
                        '3',
                        '4',
                        '5',
                        '6',
                        '7',
                        '8',
                        '9',
                        '0',
                    ],
                ],
                [Str('1 2 3 4 5 6 7 8 9_0')->getSplittedBy('x'), ['1 2 3 4 5 6 7 8 9_0']],
            ]
        );
    }

    public function testReplaceRemove()
    {
        $this->foreachSame(
            [
                [
                    Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('\s+|\d+', '')
                        ->get(),
                    'qwerty',
                ],
                [
                    Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->remove('\s+|\d+')
                        ->get(),
                    'qwerty',
                ],
                [
                    Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('\d', ' ')
                        ->get(),
                    '     qwe    r   t   y         ',
                ],
                [
                    Str('12qweQWE35')
                        ->replace('[qwe]+', '')
                        ->get(),
                    '12QWE35',
                ],
                [
                    Str('12qweQWE35')
                        ->replace('[qweQWE]+', '')
                        ->get(),
                    '1235',
                ],
                [
                    Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('', ' ')
                        ->get(),
                    ' 1 2 3 4 5 q w e 2   4   r   5   t 4   6 y 7 5   4 6   3 5   ',
                ],
            ]
        );

    }

    public function testReverse()
    {
        $this->foreachSame(
            [
                [
                    Str('12345')
                        ->reverse()
                        ->get(),
                    '54321',
                ],
                [
                    Str('тевирп')
                        ->reverse()
                        ->get(),
                    'привет',
                ],
                [
                    Str('olleh')
                        ->reverse()
                        ->get(),
                    'hello',
                ],
            ]
        );
    }

    public function testRepeat()
    {
        $this->foreachSame(
            [
                [
                    Str('12345')
                        ->repeat(3)
                        ->get(),
                    '123451234512345',
                ],
                [
                    Str('ыh')
                        ->repeat(3)
                        ->get(),
                    'ыhыhыh',
                ],
                [
                    Str('привет')
                        ->repeat(5)
                        ->get(),
                    'приветприветприветприветпривет',
                ],
                [
                    Str('h')
                        ->repeat(1)
                        ->get(),
                    'h',
                ],
                [
                    Str('h')
                        ->repeat(0)
                        ->get(),
                    'h',
                ],
                [
                    Str('h')
                        ->repeat(-1)
                        ->get(),
                    'h',
                ],
            ]
        );
    }

    public function testGetParts()
    {
        $this->foreachSame(
            [
                [
                    Str('2011-11-01')
                        ->getParts(
                            [
                                2,
                                1,
                                0,
                            ], '-', ':'
                        ),
                    '01:11:2011',
                ],
                [
                    Str('2011-11-01')
                        ->getParts([2], '-', ':'),
                    '01',
                ],
                [
                    Str('2011-11-01')
                        ->getParts(2, '-', ':'),
                    '01',
                ],
                [
                    Str('2011-11-01')
                        ->getParts(0, '-', ':'),
                    '2011',
                ],
                [
                    Str('2011 11 01')
                        ->getParts(),
                    '2011',
                ],
                [
                    Str('2011 11 01')
                        ->getParts(0),
                    '2011',
                ],
                [
                    Str('2011 11 01')
                        ->getParts(1),
                    '11',
                ],
                [
                    Str('2011 11 01')
                        ->getParts(2),
                    '01',
                ],
                [
                    Str('2011 11 01')
                        ->getParts(
                            [
                                2,
                                2,
                                2,
                                3,
                                0,
                            ]
                        ),
                    '01 01 01 2011',
                ],
                [
                    Str('2011-11-01')
                        ->getFirstPart('-'),
                    '2011',
                ],
                [
                    Str('2011')
                        ->getFirstPart('-'),
                    '2011',
                ],
                [
                    Str()
                        ->getFirstPart('-'),
                    '',
                ],
                [
                    Str('2011-11-01')
                        ->getLastPart('-'),
                    '01',
                ],
                [
                    Str('2011')
                        ->getLastPart('-'),
                    '2011',
                ],
            ]
        );
    }

    public function testRemoveBeginningEnding()
    {
        $this->foreachSame(
            [
                [
                    Str('c3string')
                        ->removeBeginning('c3')
                        ->get(),
                    'string',
                ],
                [
                    Str('c3string')
                        ->removeBeginning('c3string')
                        ->get(),
                    '',
                ],
                [
                    Str('sd3dfgfdgfdg')
                        ->removeBeginning('3')
                        ->get(),
                    'sd3dfgfdgfdg',
                ],
                [
                    Str('c3string')
                        ->removeEnding('g')
                        ->get(),
                    'c3strin',
                ],
                [
                    Str('c3string')
                        ->removeEnding('c3string')
                        ->get(),
                    '',
                ],
                [
                    Str('sd3dfgfdgfdg')
                        ->removeEnding('4444')
                        ->get(),
                    'sd3dfgfdgfdg',
                ],
            ]
        );

    }

    public function testSlugify()
    {
        $this->foreachSame(
            [
                [
                    Str(
                        'Привет-лунатикlunatikam.!? :78 Horoso, ploho()[]{}ам 日本語! '
                        . 'A æ_Übérmensch på høyeste nivå! ' . 'И я_люблю PHP! Есть?'
                    )
                        ->slugify()
                        ->get(),
                    'privet-lunatiklunatikam-78-horoso-ploho-am-ri-ben-yu-a-ae-ubermensch-pa-hoyeste-niva-i-a-lublu-php-est',
                ],
                [
                    Str('Привет-лунатикам 日本語! 蓋 私、，…‥。「　」『　』')
                        ->slugify()
                        ->get(),
                    'privet-lunatikam-ri-ben-yu-gai-si',
                ],
                [
                    Str('SenSio')
                        ->slugify()
                        ->get(),
                    'sensio',
                ],
                [
                    Str('sensio labs')
                        ->slugify()
                        ->get(),
                    'sensio-labs',
                ],
                [
                    Str('sensio   labs')
                        ->slugify()
                        ->get(),
                    'sensio-labs',
                ],
                [
                    Str('paris,france')
                        ->slugify()
                        ->get(),
                    'paris-france',
                ],
                [
                    Str('  sensio')
                        ->slugify()
                        ->get(),
                    'sensio',
                ],
                [
                    Str('sensio  ')
                        ->slugify()
                        ->get(),
                    'sensio',
                ],
                [
                    Str('')
                        ->slugify()
                        ->get(),
                    '',
                ],
                [
                    Str('-hell-llo--loo---')
                        ->slugify()
                        ->get(),
                    'hell-llo-loo',
                ],
                [
                    Str('-__hell-__-llo-__-loo---____')
                        ->slugify()
                        ->get(),
                    'hell-llo-loo',
                ],
            ]
        );
    }

    public function testClone()
    {

        $original = Str('String');
        $cloned = $original->getClone();

        $this->foreachSame([
                               [json_encode($original), json_encode($cloned)],
                               [gettype($original), gettype($cloned)],
                               [get_class($original), get_class($cloned)],
                               [get_class_methods($original), get_class_methods($cloned)],
                               [get_class_vars($original), get_class_vars($cloned)],
                           ]);
    }

    public function testShuffleCharacters()
    {

        $original = 'sdfghtyui opl';

        $originalArray = Str($original)->getCharactersArray();

        $shuffled = Str($original)->shuffleCharacters();

        $shuffledArray = $shuffled->getCharactersArray();

        $this->assertEquals($shuffled->getLength(), mb_strlen($original, 'UTF-8'));

        $this->assertNotEquals($original, $shuffled->get());

        foreach ($originalArray as $value) {
            $this->assertTrue(in_array($value, $shuffledArray));
        }
    }

    public function testFooterYears()
    {
        $currentYear = new \DateTime();
        $currentYear = $currentYear->format('Y');

        $this->foreachSame(
            [
                [
                    StringHelper::getFooterYears($currentYear - 100),
                    ($currentYear - 100) . '—' . $currentYear,
                ],
                [
                    StringHelper::getFooterYears($currentYear),
                    $currentYear,
                ],
            ]
        );
    }

    public function testRemoveTags()
    {
        $html = Str(file_get_contents(static::getPackagePath('tests/files/html.html')))
            ->removeTags()
            ->trimSpaces();

        $this->assertEquals($html, 'PHP: mb_ereg - Manual');

        $html = Str(file_get_contents(static::getPackagePath('tests/files/html.html')))
            ->removeTags('<title>')
            ->trimSpaces();

        $this->assertEquals($html, '<title>PHP: mb_ereg - Manual</title>');
    }

    public function testLevenshtein()
    {
        $this->foreachSame(
            [
                [Str('123sdadwdwedwdwdwdwwdw')->getLevenshteinDistance('12345'), 19],
                [Str('12345')->getLevenshteinDistance('12345'), 0],
                [Str('12')->getLevenshteinDistance('1'), 1],
                [Str('12')->getLevenshteinDistance(''), 2],
                [Str('12')->getLevenshteinDistance('12'), 0],
                [Str('')->getLevenshteinDistance('12'), 2],
                [Str('')->getLevenshteinDistance(''), 0],
                [Str('12привет')->getLevenshteinDistance('1'), 7],
            ]
        );
    }

    public function testToCharactersArray()
    {

        $this->assertTrue(
            is_array(
                Str('0123456789 привет1')->getCharactersArray()
            )
        );

        $this->foreachSame(
            [
                [
                    Str('0123456789  привет1')->getCharactersArray(),
                    [
                        '0',
                        '1',
                        '2',
                        '3',
                        '4',
                        '5',
                        '6',
                        '7',
                        '8',
                        '9',
                        ' ',
                        ' ',
                        'п',
                        'р',
                        'и',
                        'в',
                        'е',
                        'т',
                        '1',
                    ],
                ],
                [Str('')->getCharactersArray(), []],
                [
                    Str("1\n2\n3\n4\n6")
                        ->getCharactersArray(),
                    ['1', "\n", '2', "\n", '3', "\n", '4', "\n", '6'],
                ],
            ]
        );

    }

    public function testToLinesArray()
    {

        $text =
            "Ghbпри ваыв выввцвцвц" . PHP_EOL . "" . PHP_EOL . "" . PHP_EOL . "цвйцвцйвцй" . PHP_EOL . "" . PHP_EOL . ""
            . PHP_EOL . "йцвцйвйцв";

        $this->assertEquals(
            Str($text)->getLinesArray(), [
                                           'Ghbпри ваыв выввцвцвц',
                                           '',
                                           '',
                                           'цвйцвцйвцй',
                                           '',
                                           '',
                                           'йцвцйвйцв',
                                       ]
        );

        $text = "Ghbпри";

        $this->assertEquals(
            Str($text)->getLinesArray(), [
                                           'Ghbпри',
                                       ]
        );
    }

    public function testTrim()
    {
        $this->foreachSame(
            [
                [
                    Str('   sup  er   ')
                        ->trimSpacesLeft()
                        ->get(),
                    'sup  er   ',
                ],
                [
                    Str('   sup  er   ')
                        ->trimSpacesRight()
                        ->get(),
                    '   sup  er',
                ],
                [
                    Str('   s         u  p  er   ')
                        ->trimSpaces()
                        ->get(),
                    's u p er',
                ],
            ]
        );
    }

    public function testPaginationInfo()
    {
        $this->foreachSame(
            [
                [StringHelper::getScrollPaginationInfo(10, 1, 0), '1 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 1), '2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 2), '3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 3), '4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 4), '5 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 5), '6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 6), '7 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 7), '8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 8), '9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 9), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 0), '1, 2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 2), '3, 4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 4), '5, 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 6), '7, 8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 8), '9, 10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 0), '1 - 3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 3), '4 - 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 6), '7 - 9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 9), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(11, 3, 0), '1 - 3 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 3), '4 - 6 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 6), '7 - 9 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 9), '10, 11 / 11'],
                [StringHelper::getScrollPaginationInfo(12, 3, 0), '1 - 3 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 3), '4 - 6 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 6), '7 - 9 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 9), '10 - 12 / 12'],
                [StringHelper::getScrollPaginationInfo(13, 3, 0), '1 - 3 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 3), '4 - 6 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 6), '7 - 9 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 9), '10 - 12 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 12), '13 / 13'],
                [StringHelper::getScrollPaginationInfo(50, 10, 0), '1 - 10 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 10), '11 - 20 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 20), '21 - 30 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 30), '31 - 40 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 40), '41 - 50 / 50'],
            ]
        );
    }

    public function testPaginationInfoComma()
    {
        $this->foreachSame(
            [
                [StringHelper::getScrollPaginationInfo(10, 1, 0, '.'), '1 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 1, '.'), '2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 2, '.'), '3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 3, '.'), '4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 4, '.'), '5 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 5, '.'), '6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 6, '.'), '7 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 7, '.'), '8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 8, '.'), '9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 9, '.'), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 0, '.'), '1.2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 2, '.'), '3.4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 4, '.'), '5.6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 6, '.'), '7.8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 8, '.'), '9.10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 0, '.'), '1 - 3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 3, '.'), '4 - 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 6, '.'), '7 - 9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 9, '.'), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(11, 3, 0, '.'), '1 - 3 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 3, '.'), '4 - 6 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 6, '.'), '7 - 9 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 9, '.'), '10.11 / 11'],
                [StringHelper::getScrollPaginationInfo(12, 3, 0, '.'), '1 - 3 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 3, '.'), '4 - 6 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 6, '.'), '7 - 9 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 9, '.'), '10 - 12 / 12'],
                [StringHelper::getScrollPaginationInfo(13, 3, 0, '.'), '1 - 3 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 3, '.'), '4 - 6 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 6, '.'), '7 - 9 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 9, '.'), '10 - 12 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 12, '.'), '13 / 13'],
                [StringHelper::getScrollPaginationInfo(50, 10, 0, '.'), '1 - 10 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 10, '.'), '11 - 20 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 20, '.'), '21 - 30 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 30, '.'), '31 - 40 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 40, '.'), '41 - 50 / 50'],
            ]
        );
    }

    public function testPaginationInfoPeriod()
    {
        $this->foreachSame(
            [
                [StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', '+'), '1 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', '+'), '2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', '+'), '3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', '+'), '4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', '+'), '5 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', '+'), '6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', '+'), '7 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', '+'), '8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', '+'), '9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', '+'), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', '+'), '1, 2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', '+'), '3, 4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', '+'), '5, 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', '+'), '7, 8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', '+'), '9, 10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', '+'), '1+3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', '+'), '4+6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', '+'), '7+9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', '+'), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', '+'), '1+3 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', '+'), '4+6 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', '+'), '7+9 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', '+'), '10, 11 / 11'],
                [StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', '+'), '1+3 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', '+'), '4+6 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', '+'), '7+9 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', '+'), '10+12 / 12'],
                [StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', '+'), '1+3 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', '+'), '4+6 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', '+'), '7+9 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', '+'), '10+12 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', '+'), '13 / 13'],
                [StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', '+'), '1+10 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', '+'), '11+20 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', '+'), '21+30 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', '+'), '31+40 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', '+'), '41+50 / 50'],
            ]
        );
    }

    public function testPaginationInfoFrom()
    {
        $this->foreachSame(
            [
                [StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', ' - ', ' / '), '1 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', ' - ', ' / '), '2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', ' - ', ' / '), '3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', ' - ', ' / '), '4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', ' - ', ' / '), '5 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', ' - ', ' / '), '6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', ' - ', ' / '), '7 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', ' - ', ' / '), '8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', ' - ', ' / '), '9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', ' - ', ' / '), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', ' - ', ' / '), '1, 2 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', ' - ', ' / '), '3, 4 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', ' - ', ' / '), '5, 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', ' - ', ' / '), '7, 8 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', ' - ', ' / '), '9, 10 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', ' - ', ' / '), '10 / 10'],
                [StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', ' - ', ' / '), '10, 11 / 11'],
                [StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 12'],
                [StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', ' - ', ' / '), '13 / 13'],
                [StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', ' - ', ' / '), '1 - 10 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', ' - ', ' / '), '11 - 20 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', ' - ', ' / '), '21 - 30 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', ' - ', ' / '), '31 - 40 / 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', ' - ', ' / '), '41 - 50 / 50'],
            ]
        );
    }

    public function testPaginationInfoCommaPeriodFrom()
    {
        $this->foreachSame(
            [
                [StringHelper::getScrollPaginationInfo(10, 1, 0, ',,', '--', ' from '), '1 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 1, ',,', '--', ' from '), '2 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 2, ',,', '--', ' from '), '3 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 3, ',,', '--', ' from '), '4 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 4, ',,', '--', ' from '), '5 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 5, ',,', '--', ' from '), '6 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 6, ',,', '--', ' from '), '7 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 7, ',,', '--', ' from '), '8 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 8, ',,', '--', ' from '), '9 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 1, 9, ',,', '--', ' from '), '10 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 0, ',,', '--', ' from '), '1,,2 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 2, ',,', '--', ' from '), '3,,4 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 4, ',,', '--', ' from '), '5,,6 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 6, ',,', '--', ' from '), '7,,8 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 2, 8, ',,', '--', ' from '), '9,,10 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 0, ',,', '--', ' from '), '1--3 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 3, ',,', '--', ' from '), '4--6 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 6, ',,', '--', ' from '), '7--9 from 10'],
                [StringHelper::getScrollPaginationInfo(10, 3, 9, ',,', '--', ' from '), '10 from 10'],
                [StringHelper::getScrollPaginationInfo(11, 3, 0, ',,', '--', ' from '), '1--3 from 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 3, ',,', '--', ' from '), '4--6 from 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 6, ',,', '--', ' from '), '7--9 from 11'],
                [StringHelper::getScrollPaginationInfo(11, 3, 9, ',,', '--', ' from '), '10,,11 from 11'],
                [StringHelper::getScrollPaginationInfo(12, 3, 0, ',,', '--', ' from '), '1--3 from 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 3, ',,', '--', ' from '), '4--6 from 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 6, ',,', '--', ' from '), '7--9 from 12'],
                [StringHelper::getScrollPaginationInfo(12, 3, 9, ',,', '--', ' from '), '10--12 from 12'],
                [StringHelper::getScrollPaginationInfo(13, 3, 0, ',,', '--', ' from '), '1--3 from 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 3, ',,', '--', ' from '), '4--6 from 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 6, ',,', '--', ' from '), '7--9 from 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 9, ',,', '--', ' from '), '10--12 from 13'],
                [StringHelper::getScrollPaginationInfo(13, 3, 12, ',,', '--', ' from '), '13 from 13'],
                [StringHelper::getScrollPaginationInfo(50, 10, 0, ',,', '--', ' from '), '1--10 from 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 10, ',,', '--', ' from '), '11--20 from 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 20, ',,', '--', ' from '), '21--30 from 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 30, ',,', '--', ' from '), '31--40 from 50'],
                [StringHelper::getScrollPaginationInfo(50, 10, 40, ',,', '--', ' from '), '41--50 from 50'],
            ]
        );
    }

    public function testPreview()
    {
        $text = '<a><p style="display:none">some preview   text </p>   </a>';

        $this->foreachSame(
            [
                [Str($text)->getPreview(-10000000), '...'],
                [Str($text)->getPreview(-1000), '...'],
                [Str($text)->getPreview(-1), '...'],
                [Str($text)->getPreview(0), '...'],
                [Str($text)->getPreview(1), '...'],
                [Str($text)->getPreview(2), '...'],
                [Str($text)->getPreview(3), '...'],
                [Str($text)->getPreview(4), '...'],
                [Str($text)->getPreview(5), '...'],
                [Str($text)->getPreview(6), '...'],
                [Str($text)->getPreview(7), 'some...'],
                [Str($text)->getPreview(8), 'some...'],
                [Str($text)->getPreview(9), 'some...'],
                [Str($text)->getPreview(10), 'some...'],
                [Str($text)->getPreview(11), 'some...'],
                [Str($text)->getPreview(12), 'some...'],
                [Str($text)->getPreview(13), 'some...'],
                [Str($text)->getPreview(14), 'some...'],
                [Str($text)->getPreview(15), 'some preview...'],
                [Str($text)->getPreview(16), 'some preview...'],
                [Str($text)->getPreview(17), 'some preview text'],
                [Str($text)->getPreview(18), 'some preview text'],
                [Str($text)->getPreview(19), 'some preview text'],
                [Str($text)->getPreview(20), 'some preview text'],
                [Str($text)->getPreview(2000), 'some preview text'],
                [Str($text)->getPreview(20000000), 'some preview text'],
                [Str($text)->getPreview(-10000000, '--'), '--'],
                [Str($text)->getPreview(-1000, '--'), '--'],
                [Str($text)->getPreview(-1, '--'), '--'],
                [Str($text)->getPreview(0, '--'), '--'],
                [Str($text)->getPreview(1, '--'), '--'],
                [Str($text)->getPreview(2, '--'), '--'],
                [Str($text)->getPreview(3, '--'), '--'],
                [Str($text)->getPreview(4, '--'), '--'],
                [Str($text)->getPreview(5, '--'), '--'],
                [Str($text)->getPreview(6, '--'), 'some--'],
                [Str($text)->getPreview(7, '--'), 'some--'],
                [Str($text)->getPreview(8, '--'), 'some--'],
                [Str($text)->getPreview(9, '--'), 'some--'],
                [Str($text)->getPreview(10, '--'), 'some--'],
                [Str($text)->getPreview(11, '--'), 'some--'],
                [Str($text)->getPreview(12, '--'), 'some--'],
                [Str($text)->getPreview(13, '--'), 'some--'],
                [Str($text)->getPreview(14, '--'), 'some preview--'],
                [Str($text)->getPreview(15, '--'), 'some preview--'],
                [Str($text)->getPreview(16, '--'), 'some preview--'],
                [Str($text)->getPreview(17, '--'), 'some preview text'],
                [Str($text)->getPreview(18, '--'), 'some preview text'],
                [Str($text)->getPreview(19, '--'), 'some preview text'],
                [Str($text)->getPreview(20, '--'), 'some preview text'],
                [Str($text)->getPreview(2000, '--'), 'some preview text'],
                [Str($text)->getPreview(20000000, '--'), 'some preview text'],
            ]
        );

    }

    public function testPreviewEnd()
    {
        $text = '<a><p style="display:none">some preview   text </p>   </a>';

        $this->foreachSame(
            [
                [Str($text)->getPreview(-10000000, '...', false), '...'],
                [Str($text)->getPreview(-1000, '...', false), '...'],
                [Str($text)->getPreview(-1, '...', false), '...'],
                [Str($text)->getPreview(0, '...', false), '...'],
                [Str($text)->getPreview(1, '...', false), '...'],
                [Str($text)->getPreview(2, '...', false), '...'],
                [Str($text)->getPreview(3, '...', false), '...'],
                [Str($text)->getPreview(4, '...', false), '...'],
                [Str($text)->getPreview(5, '...', false), '...'],
                [Str($text)->getPreview(6, '...', false), '...'],
                [Str($text)->getPreview(7, '...', false), '...text'],
                [Str($text)->getPreview(8, '...', false), '...text'],
                [Str($text)->getPreview(9, '...', false), '...text'],
                [Str($text)->getPreview(10, '...', false), '...text'],
                [Str($text)->getPreview(11, '...', false), '...text'],
                [Str($text)->getPreview(12, '...', false), '...text'],
                [Str($text)->getPreview(13, '...', false), '...text'],
                [Str($text)->getPreview(14, '...', false), '...text'],
                [Str($text)->getPreview(15, '...', false), '...preview text'],
                [Str($text)->getPreview(16, '...', false), '...preview text'],
                [Str($text)->getPreview(17, '...', false), 'some preview text'],
                [Str($text)->getPreview(18, '...', false), 'some preview text'],
                [Str($text)->getPreview(19, '...', false), 'some preview text'],
                [Str($text)->getPreview(20, '...', false), 'some preview text'],
                [Str($text)->getPreview(2000, '...', false), 'some preview text'],
                [Str($text)->getPreview(20000000, '...', false), 'some preview text'],
                [Str($text)->getPreview(-10000000, '--', false), '--'],
                [Str($text)->getPreview(-1000, '--', false), '--'],
                [Str($text)->getPreview(-1, '--', false), '--'],
                [Str($text)->getPreview(0, '--', false), '--'],
                [Str($text)->getPreview(1, '--', false), '--'],
                [Str($text)->getPreview(2, '--', false), '--'],
                [Str($text)->getPreview(3, '--', false), '--'],
                [Str($text)->getPreview(4, '--', false), '--'],
                [Str($text)->getPreview(5, '--', false), '--'],
                [Str($text)->getPreview(6, '--', false), '--text'],
                [Str($text)->getPreview(7, '--', false), '--text'],
                [Str($text)->getPreview(8, '--', false), '--text'],
                [Str($text)->getPreview(9, '--', false), '--text'],
                [Str($text)->getPreview(10, '--', false), '--text'],
                [Str($text)->getPreview(11, '--', false), '--text'],
                [Str($text)->getPreview(12, '--', false), '--text'],
                [Str($text)->getPreview(13, '--', false), '--text'],
                [Str($text)->getPreview(14, '--', false), '--preview text'],
                [Str($text)->getPreview(15, '--', false), '--preview text'],
                [Str($text)->getPreview(16, '--', false), '--preview text'],
                [Str($text)->getPreview(17, '--', false), 'some preview text'],
                [Str($text)->getPreview(18, '--', false), 'some preview text'],
                [Str($text)->getPreview(19, '--', false), 'some preview text'],
                [Str($text)->getPreview(20, '--', false), 'some preview text'],
                [Str($text)->getPreview(2000, '--', false), 'some preview text'],
                [Str($text)->getPreview(20000000, '--', false), 'some preview text'],
            ]
        );

    }

    public function testPreviewPunctuations()
    {
        $text = 'some, pre...   text! ';

        $this->foreachSame(
            [
                [Str($text)->getPreview(-1), '...'],
                [Str($text)->getPreview(0), '...'],
                [Str($text)->getPreview(1), '...'],
                [Str($text)->getPreview(2), '...'],
                [Str($text)->getPreview(3), '...'],
                [Str($text)->getPreview(4), '...'],
                [Str($text)->getPreview(5), '...'],
                [Str($text)->getPreview(6), '...'],
                [Str($text)->getPreview(7), '...'],
                [Str($text)->getPreview(8), 'some...'],
                [Str($text)->getPreview(9), 'some...'],
                [Str($text)->getPreview(10), 'some...'],
                [Str($text)->getPreview(11), 'some...'],
                [Str($text)->getPreview(12), 'some...'],
                [Str($text)->getPreview(13), 'some...'],
                [Str($text)->getPreview(14), 'some...'],
                [Str($text)->getPreview(15), 'some, pre...'],
                [Str($text)->getPreview(16), 'some, pre...'],
                [Str($text)->getPreview(17), 'some, pre...'],
                [Str($text)->getPreview(18), 'some, pre... text!'],
                [Str($text)->getPreview(19), 'some, pre... text!'],
                [Str($text)->getPreview(20), 'some, pre... text!'],
                [Str($text)->getPreview(21), 'some, pre... text!'],
                [Str($text)->getPreview(22), 'some, pre... text!'],
                [Str($text)->getPreview(22000), 'some, pre... text!'],
                [Str($text)->getPreview(-1, '...', false), '...'],
                [Str($text)->getPreview(0, '...', false), '...'],
                [Str($text)->getPreview(1, '...', false), '...'],
                [Str($text)->getPreview(2, '...', false), '...'],
                [Str($text)->getPreview(3, '...', false), '...'],
                [Str($text)->getPreview(4, '...', false), '...'],
                [Str($text)->getPreview(5, '...', false), '...'],
                [Str($text)->getPreview(6, '...', false), '...'],
                [Str($text)->getPreview(7, '...', false), '...'],
                [Str($text)->getPreview(8, '...', false), '...text!'],
                [Str($text)->getPreview(9, '...', false), '...text!'],
                [Str($text)->getPreview(10, '...', false), '...text!'],
                [Str($text)->getPreview(11, '...', false), '...text!'],
                [Str($text)->getPreview(12, '...', false), '...text!'],
                [Str($text)->getPreview(13, '...', false), '...text!'],
                [Str($text)->getPreview(14, '...', false), '...text!'],
                [Str($text)->getPreview(15, '...', false), '...pre... text!'],
                [Str($text)->getPreview(16, '...', false), '...pre... text!'],
                [Str($text)->getPreview(17, '...', false), '...pre... text!'],
                [Str($text)->getPreview(18, '...', false), 'some, pre... text!'],
                [Str($text)->getPreview(19, '...', false), 'some, pre... text!'],
                [Str($text)->getPreview(20, '...', false), 'some, pre... text!'],
                [Str($text)->getPreview(21, '...', false), 'some, pre... text!'],
                [Str($text)->getPreview(22, '...', false), 'some, pre... text!'],
                [Str($text)->getPreview(22000, '...', false), 'some, pre... text!'],
            ]
        );

        $text = 'some, pre___   text! ';

        $this->foreachSame(
            [
                [Str($text)->getPreview(-1), '...'],
                [Str($text)->getPreview(0), '...'],
                [Str($text)->getPreview(1), '...'],
                [Str($text)->getPreview(2), '...'],
                [Str($text)->getPreview(3), '...'],
                [Str($text)->getPreview(4), '...'],
                [Str($text)->getPreview(5), '...'],
                [Str($text)->getPreview(6), '...'],
                [Str($text)->getPreview(7), '...'],
                [Str($text)->getPreview(8), 'some...'],
                [Str($text)->getPreview(9), 'some...'],
                [Str($text)->getPreview(10), 'some...'],
                [Str($text)->getPreview(11), 'some...'],
                [Str($text)->getPreview(12), 'some...'],
                [Str($text)->getPreview(13), 'some...'],
                [Str($text)->getPreview(14), 'some...'],
                [Str($text)->getPreview(15), 'some, pre...'],
                [Str($text)->getPreview(16), 'some, pre...'],
                [Str($text)->getPreview(17), 'some, pre...'],
                [Str($text)->getPreview(18), 'some, pre___ text!'],
                [Str($text)->getPreview(19), 'some, pre___ text!'],
                [Str($text)->getPreview(20), 'some, pre___ text!'],
                [Str($text)->getPreview(21), 'some, pre___ text!'],
                [Str($text)->getPreview(22), 'some, pre___ text!'],
                [Str($text)->getPreview(22000), 'some, pre___ text!'],
                [Str($text)->getPreview(-1, '...', false), '...'],
                [Str($text)->getPreview(0, '...', false), '...'],
                [Str($text)->getPreview(1, '...', false), '...'],
                [Str($text)->getPreview(2, '...', false), '...'],
                [Str($text)->getPreview(3, '...', false), '...'],
                [Str($text)->getPreview(4, '...', false), '...'],
                [Str($text)->getPreview(5, '...', false), '...'],
                [Str($text)->getPreview(6, '...', false), '...'],
                [Str($text)->getPreview(7, '...', false), '...'],
                [Str($text)->getPreview(8, '...', false), '...text!'],
                [Str($text)->getPreview(9, '...', false), '...text!'],
                [Str($text)->getPreview(10, '...', false), '...text!'],
                [Str($text)->getPreview(11, '...', false), '...text!'],
                [Str($text)->getPreview(12, '...', false), '...text!'],
                [Str($text)->getPreview(13, '...', false), '...text!'],
                [Str($text)->getPreview(14, '...', false), '...text!'],
                [Str($text)->getPreview(15, '...', false), '...pre___ text!'],
                [Str($text)->getPreview(16, '...', false), '...pre___ text!'],
                [Str($text)->getPreview(17, '...', false), '...pre___ text!'],
                [Str($text)->getPreview(18, '...', false), 'some, pre___ text!'],
                [Str($text)->getPreview(19, '...', false), 'some, pre___ text!'],
                [Str($text)->getPreview(20, '...', false), 'some, pre___ text!'],
                [Str($text)->getPreview(21, '...', false), 'some, pre___ text!'],
                [Str($text)->getPreview(22, '...', false), 'some, pre___ text!'],
                [Str($text)->getPreview(22000, '...', false), 'some, pre___ text!'],
            ]
        );
    }

    public function testMatches()
    {
        $text = '23sd re23w 23dfrgt23 xsdf 23 23 97 7 86 sds
                 sdfsd 678 9899 9899';

        $text2 = '23sd re23w 23dfrgt23 xsdf 23_23 97 7 86 sds
                 sdfsd 678-9899 9899';

        $this->foreachSame(
            [
                [Str('')->getMatches('\d{2}'), []],
                [Str('dsd')->getMatches(''), []],
                [Str('')->getMatches(''), []],
                [
                    Str($text)->getMatches('\d{4}'),
                    [
                        '9899',
                        '9899',
                    ],
                ],
                [
                    Str($text)->getMatches('\b\S+\b'),
                    [
                        '23sd',
                        're23w',
                        '23dfrgt23',
                        'xsdf',
                        '23',
                        '23',
                        '97',
                        '7',
                        '86',
                        'sds',
                        'sdfsd',
                        '678',
                        '9899',
                        '9899',
                    ],
                ],
                [
                    Str($text2)->getMatches('\b\S+\b'),
                    [
                        '23sd',
                        're23w',
                        '23dfrgt23',
                        'xsdf',
                        '23_23',
                        '97',
                        '7',
                        '86',
                        'sds',
                        'sdfsd',
                        '678-9899',
                        '9899',
                    ],
                ],
                [
                    Str($text)->getMatches('\d+'),
                    [
                        '23',
                        '23',
                        '23',
                        '23',
                        '23',
                        '23',
                        '97',
                        '7',
                        '86',
                        '678',
                        '9899',
                        '9899',
                    ],
                ],
                [
                    Str($text)->getMatches('\w+'),
                    [
                        '23sd',
                        're23w',
                        '23dfrgt23',
                        'xsdf',
                        '23',
                        '23',
                        '97',
                        '7',
                        '86',
                        'sds',
                        'sdfsd',
                        '678',
                        '9899',
                        '9899',
                    ],
                ],
                [Str($text)->getMatches('zzz'), []],
                [
                    Str($text)->getMatches('[^\s]*sd[^\s]*'),
                    [
                        '23sd',
                        'xsdf',
                        'sds',
                        'sdfsd',
                    ],
                ],
            ]
        );

    }

    public function testInsertAtException()
    {
        $this->expectException(InvalidArgumentException::class);
        Str('')->insertAt('', -1);
    }

    public function testInsertAtException2()
    {
        $this->expectException(InvalidArgumentException::class);
        Str('')->insertAt('', -10);
    }

    public function testInsertAtException3()
    {
        $this->expectException(InvalidArgumentException::class);
        Str('123')->insertAt('', 4);
    }

    public function testInsertAtException4()
    {
        $this->expectException(InvalidArgumentException::class);
        Str('123')->insertAt('', 5);
    }

    public function testInsertAt()
    {

        $this->foreachSame([
                               [
                                   Str('')
                                       ->insertAt('', 0)
                                       ->get(),
                                   '',
                               ],
                               [
                                   Str('s')
                                       ->insertAt('tr', 1)
                                       ->get(),
                                   'str',
                               ],
                               [
                                   Str('s')
                                       ->insertAt('tr', 0)
                                       ->get(),
                                   'trs',
                               ],
                               [
                                   Str('sting')
                                       ->insertAt('r', 2)
                                       ->get(),
                                   'string',
                               ],
                               [
                                   Str('')
                                       ->insertAt('r', 0)
                                       ->insertAt('i', 1)
                                       ->insertAt('ng', 2)
                                       ->insertAt('st', 0)
                                       ->get(),
                                   'string',
                               ],
                           ]);

    }

    public function testSpecial()
    {

        $falsies = [
            '-rwxr-xr-x   1 618      618       3971693 Jul 23  2002 adsldrv.exe',
            '-rwxr-xr-x   1 618      618        210896 Jul 23  2002 maneng.exe',
            '-rwxr-xr-x   1 618      618       4020623 May  8  2003 usbdrv22.exe',
            '-rwxr-xr-x   1 618      618       3971693 Jul 23  2002 adsldrv.exe',
            '-rwxr-xr-x   1 618      618        210896 Jul 23  2002 maneng.exe',
            '-rwxr-xr-x   1 618      618       4020623 May  8  2003 usbdrv22.exe',
            '09-23-15  01:04PM                 SITA RFB',
        ];

        $trues = [
            '02-17-16  11:28AM       <DIR>          ProlineDrivers',
            '08-19-15  02:52PM       <DIR>          CITYOFCT',
            '09-23-15  01:04PM       <dir>          SITA RFB',
            'drwxr-sr-x   2 618      618          4096 Nov 13  2002 manual',
            'drwxr-sr-x   2 618      618          4096 Nov 13  2002 manual',
        ];

        foreach ($trues as $true) {
            $this->assertTrue(Str($true)->isStartsWith('dr') || Str($true)->isContainIgnoreCase('<dir>'));
        }

        foreach ($falsies as $false) {
            $this->assertFalse(Str($false)->isStartsWith('dr') && Str($false)->isContainIgnoreCase('<dir>'));
            $this->assertFalse(Str($false)->isStartsWith('dr') || Str($false)->isContainIgnoreCase('<dir>'));
            $this->assertFalse(Str($false)->isStartsWith('dr'));
            $this->assertFalse(Str($false)->isContainIgnoreCase('<dir>'));
        }

    }

    public function testWrap()
    {
        $this->foreachSame([
                               [
                                   StringHelper::load('str')
                                               ->wrap('+')
                                               ->get(),
                                   '+str+',
                               ],
                               [
                                   StringHelper::load('+str+')
                                               ->wrap('+')
                                               ->get(),
                                   '++str++',
                               ],
                               [
                                   StringHelper::load('+str')
                                               ->wrap('+')
                                               ->get(),
                                   '++str+',
                               ],
                               [
                                   StringHelper::load('str+')
                                               ->wrap('+')
                                               ->get(),
                                   '+str++',
                               ],
                           ]);

    }

    public function testUnwrap()
    {
        $this->foreachSame([
                               [
                                   StringHelper::load('str')
                                               ->unwrap('+')
                                               ->get(),
                                   'str',
                               ],
                               [
                                   StringHelper::load('+str')
                                               ->unwrap('+')
                                               ->get(),
                                   'str',
                               ],
                               [
                                   StringHelper::load('str+')
                                               ->unwrap('+')
                                               ->get(),
                                   'str',
                               ],
                               [
                                   StringHelper::load('+str+')
                                               ->unwrap('+')
                                               ->get(),
                                   'str',
                               ],
                               [
                                   StringHelper::load('++str++')
                                               ->unwrap('+')
                                               ->get(),
                                   '+str+',
                               ],
                           ]);

    }

    public function testIsWrapped()
    {
        $this->foreachTrue([
                               StringHelper::load('-str-')
                                           ->isWrappedBy('-'),

                               StringHelper::load('str')
                                           ->isWrappedBy(''),

                               StringHelper::load('+str++')
                                           ->isWrappedBy('+'),
                           ]);

        $this->foreachFalse([
                                StringHelper::load('str')
                                            ->isWrappedBy('+'),

                                StringHelper::load('str')
                                            ->isWrappedBy('s'),

                                StringHelper::load('-str-')
                                            ->isWrappedBy('+'),

                                StringHelper::load('-str')
                                            ->isWrappedBy('-'),

                                StringHelper::load('+str-')
                                            ->isWrappedBy('-'),

                                StringHelper::load('+str-')
                                            ->isWrappedBy('+'),

                                StringHelper::load('str')
                                            ->isWrappedBy('t'),

                                StringHelper::load('str')
                                            ->isWrappedBy('-'),
                            ]);

    }

}
