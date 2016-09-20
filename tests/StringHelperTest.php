<?php

use Zver\StringHelper;

class StringHelperCest extends PHPUnit\Framework\TestCase
{
    
    public function testStringLoadAndGet()
    {
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
        
        foreach ($originals as $original)
        {
            $this->assertInstanceOf(StringHelper::class, Str($original));
            
            $this->assertSame(Str($original[0])->get(), $original[1]);
            
            $this->assertSame(
                Str()
                    ->set($original[0])
                    ->get(), $original[1]
            );
            
            $this->assertSame(
                Str()
                    ->setFromEncoding($original[0], 'UTF-8')
                    ->get(), $original[1]
            );
            
            $this->assertSame(
                Str()->setFromEncoding($original[0], 'UTF-8') . '', $original[1]
            );
            
        }
    }
    
    public function testIsUpperCase()
    {
        $trues = [
            'HIGH',
            'L',
            '',
            ' ',
            '098765432',
        ];
        
        $falses = [
            'lH',
            'lH000',
            'lHg000',
            'lHgj00',
            'lowercase',
        ];
        
        foreach ($trues as $true)
        {
            $this->assertTrue(
                Str($true)->isUpperCase()
            );
        }
        
        foreach ($falses as $false)
        {
            $this->assertFalse(
                Str($false)->isUpperCase()
            );
        }
    }
    
    public function testIsLowerCase()
    {
        $trues = [
            '',
            ' ',
            '098lower',
            'lower',
            '098765432',
            'l',
        ];
        
        $falses = [
            'HIGH',
            'High',
            'hiGh',
            'L',
        ];
        
        foreach ($trues as $true)
        {
            $temp = Str($true);
            $this->assertTrue($temp->isLowerCase());
            
            $this->assertSame($temp->get(), $true);
        }
        
        foreach ($falses as $false)
        {
            $temp = Str($false);
            $this->assertFalse($temp->isLowerCase());
            
            $this->assertSame($temp->get(), $false);
        }
    }
    
    public function testIsTitleCase()
    {
        $trues = [
            '',
            ' ',
            '098 Lower',
            'Lower',
            '098765432',
            'L',
            'Ll',
            'Lower Case None',
        ];
        
        $falses = [
            'lower',
            'Lower case second',
            'l',
            'HIGH',
        ];
        
        foreach ($trues as $true)
        {
            $temp = Str($true);
            $this->assertTrue($temp->isTitleCase());
            
            $this->assertSame($temp->get(), $true);
        }
        
        foreach ($falses as $false)
        {
            $temp = Str($false);
            $this->assertFalse($temp->isTitleCase());
            
            $this->assertSame($temp->get(), $false);
        }
    }
    
    public function testToRandomCase()
    {
        $original = "oRiginalStrinGWithMuchCharactErs";
        
        $this->assertNotEquals(Str($original)->toRandomCase(), $original);
    }
    
    public function testUcFirst()
    {
        
        $this->assertEquals(
            Str('привеТ')
                ->toUpperCaseFirst()
                ->get(), 'Привет'
        );
        
        $this->assertEquals(
            Str('Привет')
                ->toUpperCaseFirst()
                ->get(), 'Привет'
        );
        
        $this->assertEquals(
            Str('')
                ->toUpperCaseFirst()
                ->get(), ''
        );
        
        $this->assertEquals(
            Str()
                ->toUpperCaseFirst()
                ->get(), ''
        );
    }
    
    public function testCases()
    {
        
        $this->assertEquals(
            Str('ПРИвЕТ WoRlD')
                ->toLowerCase()
                ->get(), 'привет world'
        );
        
        $this->assertEquals(
            Str('ПРИвЕТ WoRlD')
                ->toUpperCase()
                ->get(), 'ПРИВЕТ WORLD'
        );
        
        $this->assertEquals(
            Str('ПРИвЕТ WoRlD')
                ->toTitleCase()
                ->get(), 'Привет World'
        );
    }
    
    public function testLen()
    {
        
        $this->assertEquals(
            Str('helloпривет')->length(), 11
        );
        
        $this->assertEquals(
            Str('а')->length(), 1
        );
        
        $this->assertEquals(
            Str('привет日本語')->length(), 9
        );
        
        $this->assertEquals(
            Str('')->length(), 0
        );
        
        $this->assertEquals(
            Str('helloпривет')->len(), 11
        );
        
        $this->assertEquals(
            Str('а')->length(), 1
        );
        
        $this->assertEquals(
            Str('привет日本語')->len(), 9
        );
        
        $this->assertEquals(
            Str('')->len(), 0
        );
    }
    
    public function testSubstring()
    {
        
        $this->assertEquals(
            Str('h')
                ->substring()
                ->get(), 'h'
        );
        
        $this->assertEquals(
            Str('hh')
                ->substring(1)
                ->get(), 'h'
        );
        
        $this->assertEquals(
            Str('hh')
                ->substring(0)
                ->get(), 'hh'
        );
        
        $this->assertEquals(
            Str('1234567890')
                ->substring(-3)
                ->get(), '890'
        );
        
        $this->assertEquals(
            Str('1234567890')
                ->substring(-30)
                ->get(), '1234567890'
        );
        
        $this->assertEquals(
            Str('1234567890')
                ->substring(-30, 90)
                ->get(), '1234567890'
        );
        
        $this->assertEquals(
            Str('1234567890')
                ->substring(3, 3)
                ->get(), '456'
        );
        
        $this->assertEquals(
            Str('1234567890')
                ->substring(3, 13)
                ->get(), '4567890'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirstChars(0)
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirstChars(-5)
                ->get(), 'tring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirstChars(5)
                ->get(), 'super'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirstChars(500)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirstChars(-500)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLastChars(6)
                ->get(), 'string'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLastChars(-5)
                ->get(), 'super'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLastChars(0)
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLastChars(600)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLastChars(-600)
                ->get(), 'superstring'
        );
    }
    
    public function testConcatAppendPrepend()
    {
        
        $this->assertEquals(
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
                ->get(), 'letter for me'
        );
        
        $this->assertEquals(
            Str('l')
                ->concat('')
                ->get(), 'l'
        );
        
        $this->assertEquals(
            Str('1')
                ->concat('1')
                ->append('2')
                ->prepend('3')
                ->get(), '3112'
        );
    }
    
    public function testEqualsSomeAndEqualsIgnoreCase()
    {
        $values = ['str', 'count', 'me'];
        $valuesIgnoreCase = ['StR', 'coUNt', 'mE'];
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
        ];
        
        foreach ($testDataEqualsSome as $testData)
        {
            $this->assertEquals(
                $testData['result'], Str($testData['str'])->isEqualsSome($testData['values'])
            );
        }
        
        foreach ($testDataEqualsSomeIgnoreCase as $testData)
        {
            $this->assertEquals(
                $testData['result'], Str($testData['str'])->isEqualsSomeIgnoreCase($testData['values'])
            );
        }
        
    }
    
    public function testIsMatchTest()
    {
        
        $this->assertTrue(
            Str('')->isMatch('')
        );
        
        $this->assertFalse(
            Str('')->isMatch('/d+')
        );
        
        $this->assertTrue(
            Str(' 3521')->isMatch('')
        );
        
        $this->assertTrue(
            Str(' 3521')->isMatch('\d+')
        );
        
        $this->assertFalse(
            Str(' 3521')->isMatch('^\d+$')
        );
        
        $this->assertTrue(
            Str('3521')->isMatch('\d\d\d\d')
        );
        
        $this->assertTrue(
            Str('3521')->isMatch('\d')
        );
        
        $this->assertFalse(
            Str('')->isMatch('\d')
        );
        
        $this->assertTrue(
            Str('стринг2' . PHP_EOL . 'CNhbyu22')->isMatch('\w+\s')
        );
        
        $this->assertTrue(
            Str('стринг2' . PHP_EOL . 'CNhbyu22')->isMatch('[A-Z]+')
        );
        
        $this->assertFalse(
            Str('2' . PHP_EOL . 'CN22')->isMatch('[a-z]+')
        );
        
    }
    
    public function testEmpty()
    {
        
        $this->assertTrue(
            Str('  ... ')->isEmpty()
        );
        
        $this->assertTrue(
            Str('')->isEmpty()
        );
        
        $this->assertTrue(
            Str('      +_)(*&^%$#@!   _')->isEmpty()
        );
        
        $this->assertTrue(
            Str('__')->isEmpty()
        );
        
        $this->assertTrue(
            Str('       _   ')->isEmpty()
        );
        
        $this->assertFalse(
            Str('0')->isEmpty()
        );
        
        $this->assertFalse(
            Str('  f     _   ')->isEmpty()
        );
        
        $this->assertFalse(
            Str('  fdfвава3     _   ')->isEmpty()
        );
        
        $this->assertFalse(
            Str('  4     _   ')->isEmpty()
        );
        
        $this->assertFalse(
            Str('  привет     _   ')->isEmpty()
        );
        
        $this->assertFalse(
            Str('привет')->isEmpty()
        );
        
        $this->assertTrue(
            Str('  ... ')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('      +_)(*&^%$#@!   _')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('__')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('       _   ')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('0')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('  f     _   ')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('  fdfвава3     _   ')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('  4     _   ')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('  привет     _   ')->isEmptyWithoutTags()
        );
        
        $this->assertFalse(
            Str('привет')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('<p></p> <p> ... </p>')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('<p></p>')->isEmptyWithoutTags()
        );
        
        $this->assertTrue(
            Str('      +_)(*&^%$#@! <p wdwdwdwdwd></p>  _')->isEmptyWithoutTags()
        );
        
    }
    
    public function testCompare()
    {
        
        $this->assertTrue(
            Str('qwerty')->isEqualsIgnoreCase('QweRty')
        );
        
        $this->assertFalse(
            Str('qwerty')->isEquals('QweRty')
        );
        
        $this->assertFalse(
            Str('qwerty')->isEquals('dw3ff3f')
        );
        
    }
    
    public function testIsStartsWith()
    {
        
        $this->assertTrue(
            Str('стартс')->isStartsWith('')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWith('с')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWithIgnoreCase('С')
        );
        
        $this->assertTrue(
            Str('Стартс')->isStartsWith('Стар')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWith('стартс')
        );
        
        $this->assertFalse(
            Str('стартс')->isStartsWith('стартсс')
        );
        
        $this->assertFalse(
            Str('стартс')->isStartsWith('кпуцйайайцуайца')
        );
        
        $this->assertFalse(
            Str('стартс')->isStartsWith('кп')
        );
        
        $this->assertFalse(
            Str('стартс')->isStartsWith('у')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWithIgnoreCase('старТс')
        );
        
        $this->assertFalse(
            Str('')->isStartsWith('кп')
        );
        
        $this->assertFalse(
            Str('')->isStartsWithIgnoreCase('кп')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWith('')
        );
        
        $this->assertTrue(
            Str('стартс')->isStartsWithIgnoreCase('')
        );
    }
    
    public function testIsEndsWith()
    {
        
        $this->assertTrue(
            Str('стартс')->isEndsWith('')
        );
        
        $this->assertTrue(
            Str('стартс')->isEndsWithIgnoreCase('стАртС')
        );
        
        $this->assertTrue(
            Str('zzzsdfsdf')->isEndsWith('')
        );
        
        $this->assertTrue(
            Str('zzzsdfsdf')->isEndsWithIgnoreCase('')
        );
        
        $this->assertTrue(
            Str('стартс')->isEndsWith('стартс')
        );
        
        $this->assertTrue(
            Str('стартс')->isEndsWithIgnoreCase('С')
        );
        
        $this->assertFalse(
            Str('стартс')->isEndsWith('С')
        );
        
        $this->assertFalse(
            Str('стартс')->isEndsWith('s')
        );
        
        $this->assertFalse(
            Str('стартс')->isEndsWith('сстартс')
        );
        
        $this->assertFalse(
            Str('стартс')->isEndsWithIgnoreCase('zzzsdfsdf')
        );
        
        $this->assertFalse(
            Str('')->isEndsWith('zzzsdfsdf')
        );
        
        $this->assertFalse(
            Str('')->isEndsWithIgnoreCase('zzzsdfsdf')
        );
        
    }
    
    public function testLoadConstructToStringGetStringifySet()
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
        
        $this->assertEquals(
            Str($toLoad)->get(), $result
        );
        
        $this->assertEquals(
            Str('string')->get(), 'string'
        );
        
        $this->assertEquals(
            Str()->get(), ''
        );
        
        $this->assertEquals(
            Str()
                ->set('')
                ->get(), ''
        );
        
        $this->assertEquals(
            Str()
                ->set($toLoad)
                ->get(), $result
        );
        
        $this->assertEquals(
            Str()
                ->set($toLoad)
                ->getEncoding(), StringHelper::getDefaultEncoding()
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
        
        //$this->assertEquals(
        //    Str('invertcaseofmybeautifulstringinvertcaseofmybeautifulstring')
        //        ->toRandomCase()
        //        ->toRandomCase()
        //        ->toRandomCase()
        //        ->toRandomCase()
        //        ->toRandomCase()
        //        ->toLowerCase()
        //        ->get(), 'invertcaseofmybeautifulstringinvertcaseofmybeautifulstring'
        //);
        
    }
    
    public function testNl()
    {
        
        $this->assertEquals(
            Str("\n\nHello!\nMy name is Jay.\n\n")
                ->newlineToBreak()
                ->get(), "<br />\n<br />\nHello!<br />\nMy name is Jay.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("\n\nÜbérmensch på høyeste!.\n\n")
                ->newlineToBreak()
                ->get(), "<br />\n<br />\nÜbérmensch på høyeste!.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("\n\nПривет!\nМеня зовут Джей.\n\n")
                ->newlineToBreak()
                ->get(), "<br />\n<br />\nПривет!<br />\nМеня зовут Джей.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("Übérmensch på høyeste!.<br/><br/>")
                ->breakToNewline()
                ->get(), "Übérmensch på høyeste!." . PHP_EOL . PHP_EOL
        );
        
        $this->assertEquals(
            Str("Привет.<br/><br/>")
                ->breakToNewline()
                ->get(), "Привет." . PHP_EOL . PHP_EOL
        );
        
        $this->assertEquals(
            Str("\n\nHello!\nMy name is Jay.\n\n")
                ->nl2br()
                ->get(), "<br />\n<br />\nHello!<br />\nMy name is Jay.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("\n\nÜbérmensch på høyeste!.\n\n")
                ->nl2br()
                ->get(), "<br />\n<br />\nÜbérmensch på høyeste!.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("\n\nПривет!\nМеня зовут Джей.\n\n")
                ->nl2br()
                ->get(), "<br />\n<br />\nПривет!<br />\nМеня зовут Джей.<br />\n<br />\n"
        );
        
        $this->assertEquals(
            Str("Übérmensch på høyeste!.<br/><br/>")
                ->br2nl()
                ->get(), "Übérmensch på høyeste!." . PHP_EOL . PHP_EOL
        );
        
        $this->assertEquals(
            Str("Привет.<br/><br/>")
                ->br2nl()
                ->get(), "Привет." . PHP_EOL . PHP_EOL
        );
    }
    
    public function testSetBeginning()
    {
        
        $this->assertEquals(
            Str()
                ->setBeginning('/привет')
                ->get(), '/привет'
        );
        
        $this->assertEquals(
            Str('/суперпривет')
                ->setBeginning('/суперпривет')
                ->get(), '/суперпривет'
        );
        
        $this->assertEquals(
            Str('/привет')
                ->setBeginning('/приветW')
                ->get(), '/приветW/привет'
        );
        
    }
    
    public function testSetEnding()
    {
        
        $this->assertEquals(
            Str()
                ->setEnding('/привет')
                ->get(), '/привет'
        );
        
        $this->assertEquals(
            Str('/суперпривет')
                ->setEnding('/суперпривет')
                ->get(), '/суперпривет'
        );
        
        $this->assertEquals(
            Str('/привет')
                ->setEnding('/приветW')
                ->get(), '/привет/приветW'
        );
        
    }
    
    public function testJSON()
    {
        $this->assertEquals(
            Str(json_encode('string'))
                ->fromJSON()
                ->get(), 'string'
        );
        
        $this->assertEquals(
            Str('string')
                ->fromJSON()
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('')
                ->fromJSON()
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('')
                ->toJSON()
                ->get(), '""'
        );
        
        $this->assertEquals(
            Str('string')
                ->toJSON()
                ->get(), '"string"'
        );
        
    }
    
    public function testSerialization()
    {
        //$str = Str('string');
        //$serialized = serialize($str);
        //$unserialized = unserialize($serialized);
        //$this->assertEquals($unserialized->get(), $str->get());
    }
    
    public function testEntities()
    {
        
        $this->assertEquals(
            Str('<img src="/e.png" />')
                ->toHTMLEntities()
                ->get(), '&lt;img src=&quot;/e.png&quot; /&gt;'
        );
        
        $this->assertEquals(
            Str('&lt;img src=&quot;/e.png&quot; /&gt;')
                ->fromHTMLEntities()
                ->get(), '<img src="/e.png" />'
        );
        
        $this->assertEquals(
            Str('<img src="/e.png" />')
                ->toHTMLEntities()
                ->removeEntities()
                ->get(), 'img src=/e.png /'
        );
    }
    
    public function testURLCoding()
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        
        $this->assertEquals(
            Str($url)
                ->toURL()
                ->get(), 'www.example.com%2Fadmin%3Fi%3D1%26ref%3Dhttp%3A%2F%2Fex.ru%2Fer'
        );
        
        $this->assertEquals(
            Str($url)
                ->toURL()
                ->fromURL()
                ->get(), $url
        );
    }
    
    public function testUUE()
    {
        
        $this->assertEquals(
            Str('ПриветCat')
                ->toUUE()
                ->remove('\s+')
                ->get(), '/T)_1@-"XT++0M=&"0V%T`'
        );
        
        $this->assertEquals(
            Str('ПриветCat')
                ->toUUE()
                ->fromUUE()
                ->get(), 'ПриветCat'
        );
    }
    
    public function testBase64Coding()
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        
        $this->assertEquals(
            Str($url)
                ->toBase64()
                ->get(), 'd3d3LmV4YW1wbGUuY29tL2FkbWluP2k9MSZyZWY9aHR0cDovL2V4LnJ1L2Vy'
        );
        
        $this->assertEquals(
            Str($url)
                ->toBase64()
                ->fromBase64()
                ->get(), $url
        );
    }
    
    public function testUTF8Coding()
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/привет';
        
        $this->assertEquals(
            Str($url)
                ->toUTF8()
                ->get(), 'www.example.com/admin?i=1&ref=http://ex.ru/Ð¿ÑÐ¸Ð²ÐµÑ'
        );
        
        $this->assertEquals(
            Str($url)
                ->toUTF8()
                ->fromUTF8()
                ->get(), $url
        );
    }
    
    public function testSerialized()
    {
        //$this->assertFalse(
        //    Str('123')->isSerialized()
        //);
        //
        //$this->assertFalse(
        //    Str('прийцавйыв')->isSerialized()
        //);
        //
        //$this->assertFalse(
        //    Str('')->isSerialized()
        //);
        //
        //$this->assertTrue(
        //    Str(
        //        serialize(
        //            [
        //                'd2fdqw',
        //                '23asdasd',
        //            ]
        //        )
        //    )->isSerialized()
        //);
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
        
        foreach ($tests as $original => $punycode)
        {
            
            $this->assertTrue(
                Str($original)
                    ->toPunyCode()
                    ->isEqualsIgnoreCase($punycode)
            );
            
            $this->assertTrue(
                Str($punycode)
                    ->fromPunyCode()
                    ->isEqualsIgnoreCase($original)
            );
            
            $this->assertTrue(
                Str($punycode)
                    ->fromPunyCode()
                    ->toPunyCode()
                    ->isEqualsIgnoreCase($punycode)
            );
            
            $this->assertTrue(
                Str($original)
                    ->toPunyCode()
                    ->fromPunyCode()
                    ->isEqualsIgnoreCase($original)
            );
        }
    }
    
    public function testFill()
    {
        
        $this->assertEquals(
            Str('x')
                ->fillLeft('s', 5)
                ->get(), 'ssssx'
        );
        
        $this->assertEquals(
            Str('x')
                ->fillLeft(' ', 5)
                ->get(), '    x'
        );
        
        $this->assertEquals(
            Str('x')
                ->fillLeft('s2', 5)
                ->get(), 's2s2x'
        );
        
        $this->assertEquals(
            Str('x')
                ->fillLeft('s', 1)
                ->get(), 'x'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillLeft('п2', 5)
                ->get(), 'п2п2а'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillLeft('п23', 5)
                ->get(), 'п23па'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillLeft('п', 1)
                ->get(), 'а'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillLeft('', -22)
                ->get(), 'а'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillRight('п', 1)
                ->get(), 'а'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillRight('п', 2)
                ->get(), 'ап'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillRight('п23', 10)
                ->get(), 'ап23п23п23'
        );
        
        $this->assertEquals(
            Str('а')
                ->fillRight('', 2)
                ->get(), 'а'
        );
    }
    
    public function testContains()
    {
        
        $this->assertTrue(
            Str('hello')->contains('l')
        );
        
        $this->assertTrue(
            Str('hello')->contains('hello')
        );
        
        $this->assertTrue(
            Str('hello')->containsIgnoreCase('HELLO')
        );
        
        $this->assertTrue(
            Str('hello')->contains('o')
        );
        
        $this->assertTrue(
            Str('hello')->contains('h')
        );
        
        $this->assertFalse(
            Str('hello')->contains('L')
        );
        
        $this->assertFalse(
            Str('hello')->contains('Ll')
        );
        
        $this->assertTrue(
            Str('hello')->containsIgnoreCase('L')
        );
        
        $this->assertFalse(
            Str('hello')->containsIgnoreCase('z')
        );
    }
    
    public function testGetPosition()
    {
        
        $this->assertFalse(
            Str('')->getPosition('l')
        );
        
        $this->assertFalse(
            Str('')->getPositionFromEnd('l')
        );
        
        $this->assertFalse(
            Str('')->getPositionIgnoreCase('l')
        );
        
        $this->assertFalse(
            Str('')->getPositionFromEndIgnoreCase('l')
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionFromEnd('l'), 3
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionFromEndIgnoreCase('l'), 3
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionIgnoreCase('L'), 2
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionFromEndIgnoreCase('h'), false
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionFromEndIgnoreCase('H'), 0
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionIgnoreCase('l'), 2
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionFromEndIgnoreCase('L'), 3
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionIgnoreCase('L'), 2
        );
        
        $this->assertEquals(
            Str('Hello')->getPositionIgnoreCase('F'), false
        );
    }
    
    public function testSubstringCount()
    {
        
        $this->assertEquals(
            Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('s'), 4
        );
        
        $this->assertEquals(
            Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('.'), 3
        );
        
        $this->assertEquals(
            Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('?'), 1
        );
        
        $this->assertEquals(
            Str('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')->getSubstringCount('!'), 2
        );
        
        $this->assertEquals(
            Str('')->getSubstringCount('dwd'), 0
        );
    }
    
    public function testSplit()
    {
        
        $this->assertEquals(
            Str('1 2 3 4 5        6 7 8 9_0')->split('[\s_]+'), [
                                                                  1,
                                                                  2,
                                                                  3,
                                                                  4,
                                                                  5,
                                                                  6,
                                                                  7,
                                                                  8,
                                                                  9,
                                                                  0,
                                                              ]
        );
        
        $this->assertEquals(
            Str('1 2 3 4 5 6 7 8 9_0')->split('x'), ['1 2 3 4 5 6 7 8 9_0']
        );
    }
    
    public function testReplaceRemove()
    {
        
        $this->assertEquals(
            Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                ->replace('\s+|\d+', '')
                ->get(), 'qwerty'
        );
        
        $this->assertEquals(
            Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                ->remove('\s+|\d+')
                ->get(), 'qwerty'
        );
        
        $this->assertEquals(
            Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                ->replace('\d', ' ')
                ->get(), '     qwe    r   t   y         '
        );
        
        $this->assertEquals(
            Str('12qweQWE35')
                ->replace('[qwe]+', '')
                ->get(), '12QWE35'
        );
        
        $this->assertEquals(
            Str('12qweQWE35')
                ->replace('[qweQWE]+', '')
                ->get(), '1235'
        );
        
        $this->assertEquals(
            Str('12345qwe2 4 r 5 t4 6y75 46 35 ')
                ->replace('', ' ')
                ->get(), ' 1 2 3 4 5 q w e 2   4   r   5   t 4   6 y 7 5   4 6   3 5   '
        );
        
    }
    
    public function testReverse()
    {
        
        $this->assertEquals(
            Str('12345')
                ->reverse()
                ->get(), '54321'
        );
        
        $this->assertEquals(
            Str('тевирп')
                ->reverse()
                ->get(), 'привет'
        );
        
        $this->assertEquals(
            Str('olleh')
                ->reverse()
                ->get(), 'hello'
        );
    }
    
    public function testRepeat()
    {
        
        $this->assertEquals(
            Str('12345')
                ->repeat(3)
                ->get(), '123451234512345'
        );
        
        $this->assertEquals(
            Str('ыh')
                ->repeat(3)
                ->get(), 'ыhыhыh'
        );
        
        $this->assertEquals(
            Str('привет')
                ->repeat(5)
                ->get(), 'приветприветприветприветпривет'
        );
        
        $this->assertEquals(
            Str('h')
                ->repeat(1)
                ->get(), 'h'
        );
        
        $this->assertEquals(
            Str('h')
                ->repeat(0)
                ->get(), 'h'
        );
        
        $this->assertEquals(
            Str('h')
                ->repeat(-1)
                ->get(), 'h'
        );
    }
    
    public function testGetParts()
    {
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getParts(
                    [
                        2,
                        1,
                        0,
                    ], '-', ':'
                )
                ->get(), '01:11:2011'
        );
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getParts([2], '-', ':')
                ->get(), '01'
        );
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getParts(2, '-', ':')
                ->get(), '01'
        );
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getParts(0, '-', ':')
                ->get(), '2011'
        );
        
        $this->assertEquals(
            Str('2011 11 01')
                ->getParts()
                ->get(), '2011'
        );
        
        $this->assertEquals(
            Str('2011 11 01')
                ->getParts(0)
                ->get(), '2011'
        );
        
        $this->assertEquals(
            Str('2011 11 01')
                ->getParts(1)
                ->get(), '11'
        );
        
        $this->assertEquals(
            Str('2011 11 01')
                ->getParts(2)
                ->get(), '01'
        );
        
        $this->assertEquals(
            Str('2011 11 01')
                ->getParts(
                    [
                        2,
                        2,
                        2,
                        3,
                        0,
                    ]
                )
                ->get(), '01 01 01 2011'
        );
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getFirstPart('-')
                ->get(), '2011'
        );
        
        $this->assertEquals(
            Str('2011')
                ->getFirstPart('-')
                ->get(), '2011'
        );
        
        $this->assertEquals(
            Str()
                ->getFirstPart('-')
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('2011-11-01')
                ->getLastPart('-')
                ->get(), '01'
        );
        
        $this->assertEquals(
            Str('2011')
                ->getLastPart('-')
                ->get(), '2011'
        );
    }
    
    public function testRemoveBeginningEnding()
    {
        
        $this->assertEquals(
            Str('c3string')
                ->removeBeginning('c3')
                ->get(), 'string'
        );
        
        $this->assertEquals(
            Str('c3string')
                ->removeBeginning('c3string')
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('sd3dfgfdgfdg')
                ->removeBeginning('3')
                ->get(), 'sd3dfgfdgfdg'
        );
        
        $this->assertEquals(
            Str('c3string')
                ->removeEnding('g')
                ->get(), 'c3strin'
        );
        
        $this->assertEquals(
            Str('c3string')
                ->removeEnding('c3string')
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('sd3dfgfdgfdg')
                ->removeEnding('4444')
                ->get(), 'sd3dfgfdgfdg'
        );
        
    }
    
    public function testTransliteration()
    {
        
        //$this->assertEquals(
        //    Str('ああああああああ"Привет-лунатикам.!? :78 Хорошо, плохо()[]{}うう')
        //        ->transliterate()
        //        ->get(), 'aaaaaaaa"Privet-lunatikam.!? :78 Horoso, ploho()[]{}uu'
        //);
        //
        //$this->assertEquals(
        //    Str('Привет-лунатикам 日本語! 蓋 私、，…‥。「　」『　』')
        //        ->transliterate()
        //        ->get(), 'Privet-lunatikam ri ben yu! gai si,,......'
        //);
        //
        //$this->assertEquals(
        //    Str(
        //        'Возвращает строку string, в которой первый символ переведен в верхний регистр, если этот символ буквенный.'
        //    )
        //        ->transliterate()
        //        ->get(),
        //    'Vozvrasaet stroku string, v kotoroj pervyj simvol pereveden v verhnij registr, esli etot simvol bukvennyj.'
        //);
    }
    
    public function testSlugify()
    {
        
        $this->assertEquals(
            Str(
                'Привет-лунатикlunatikam.!? :78 Horoso, ploho()[]{}ам 日本語! ' . 'A æ_Übérmensch på høyeste nivå! '
                . 'И я_люблю PHP! Есть?'
            )
                ->slugify()
                ->get(),
            'privet-lunatiklunatikam-78-horoso-ploho-am-ri-ben-yu-a-ae-ubermensch-pa-hoyeste-niva-i-a-lublu-php-est'
        );
        
        $this->assertEquals(
            Str('Привет-лунатикам 日本語! 蓋 私、，…‥。「　」『　』')
                ->slugify()
                ->get(), 'privet-lunatikam-ri-ben-yu-gai-si'
        );
        
        $this->assertEquals(
            'sensio', Str('SenSio')->slugify()
        );
        $this->assertEquals(
            'sensio-labs', Str('sensio labs')->slugify()
        );
        $this->assertEquals(
            'sensio-labs', Str('sensio   labs')->slugify()
        );
        $this->assertEquals(
            'paris-france', Str('paris,france')->slugify()
        );
        $this->assertEquals(
            'sensio', Str('  sensio')->slugify()
        );
        $this->assertEquals(
            'sensio', Str('sensio  ')->slugify()
        );
        $this->assertEquals(
            '', Str('')->slugify()
        );
    }
    
    public function testHyphenate()
    {
        $this->assertEquals(
            Str('- __ under score  me ')
                ->hyphenate()
                ->get(), '-under-score-me-'
        );
        $this->assertEquals(
            Str('')
                ->hyphenate()
                ->get(), ''
        );
    }
    
    public function testUnderscore()
    {
        $this->assertEquals(
            Str('_ - under score  me ')
                ->underscore()
                ->get(), '_under_score_me_'
        );
        $this->assertEquals(
            Str('')
                ->underscore()
                ->get(), ''
        );
    }
    
    public function testShuffleCharacters()
    {
        
        $original = 'sdfghtyui opl';
        
        $originalArray = Str($original)->getCharactersArray();
        
        $shuffled = Str($original)->shuffleCharacters();
        
        $shuffledArray = $shuffled->getCharactersArray();
        
        $this->assertEquals($shuffled->length(), mb_strlen($original, 'UTF-8'));
        
        $this->assertNotEquals($original, $shuffled->get());
        
        foreach ($originalArray as $value)
        {
            $this->assertEquals(in_array($value, $shuffledArray), true);
        }
    }
    
    public function testFooterYears()
    {
        $currentYear = new \DateTime();
        $currentYear = $currentYear->format('Y');
        
        $this->assertEquals(
            Str()
                ->footerYears($currentYear - 100)
                ->get(), ($currentYear - 100) . '—' . $currentYear
        );
        
        $this->assertEquals(
            Str()
                ->footerYears($currentYear)
                ->get(), $currentYear
        );
    }
    
    public function testRemoveTags()
    {
        $html = Str(file_get_contents(packageTestFile('html.html')))
            ->removeTags()
            ->trimSpaces();
        
        $this->assertEquals($html, 'PHP: mb_ereg - Manual');
    }
    
    public function testSoundex()
    {
        
        $this->assertEquals(
            Str('Lukasiewicz')
                ->soundex()
                ->get(), 'L222'
        );
        
        $this->assertEquals(
            Str('hello')
                ->soundex()
                ->get(), 'H400'
        );
        
        $this->assertEquals(
            Str('hell')
                ->soundex()
                ->get(), 'H400'
        );
        
        $this->assertEquals(
            Str('he')
                ->soundex()
                ->get(), 'H000'
        );
        
        $this->assertEquals(
            Str('she')
                ->soundex()
                ->get(), 'S000'
        );
        
        $this->assertEquals(
            Str('привет')
                ->soundex()
                ->get(), 'P613'
        );
        
        $this->assertEquals(
            Str('пока')
                ->soundex()
                ->get(), 'P200'
        );
        
        $this->assertEquals(
            Str('letter')
                ->soundex()
                ->get(), 'L360'
        );
        
        $this->assertEquals(
            Str('Съешь еще этих мягких французских булочек да выпей чаю')
                ->soundex()
                ->get(), 'S200E200E300M200F652B422D000V120C000'
        );
    }
    
    public function testMetaphone()
    {
        
        $this->assertEquals(
            Str('Lukasiewicz')
                ->metaphone()
                ->get(), 'LKSWKS'
        );
        
        $this->assertEquals(
            Str('hello')
                ->metaphone()
                ->get(), 'HL'
        );
        
        $this->assertEquals(
            Str('hell')
                ->metaphone()
                ->get(), 'HL'
        );
        
        $this->assertEquals(
            Str('he')
                ->metaphone()
                ->get(), 'H'
        );
        
        $this->assertEquals(
            Str('she')
                ->metaphone()
                ->get(), 'X'
        );
        
        $this->assertEquals(
            Str('привет')
                ->metaphone()
                ->get(), 'PRFT'
        );
        
        $this->assertEquals(
            Str('пока')
                ->metaphone()
                ->get(), 'PK'
        );
        
        $this->assertEquals(
            Str('letter')
                ->metaphone()
                ->get(), 'LTR'
        );
        
        $this->assertEquals(
            Str('съешь еще этих мягких французских булочек да выпей чаю')
                ->metaphone()
                ->get(), 'SSESETMKKFRNKSSKBLSKTFPJK'
        );
        
    }
    
    public function testLevenshtein()
    {
        
        $this->assertEquals(
            Str('123sdadwdwedwdwdwdwwdw')
                ->levenshtein('12345')
                ->get(), 19
        );
        
        $this->assertEquals(
            Str('12345')
                ->levenshtein('12345')
                ->get(), 0
        );
        
        $this->assertEquals(
            Str('12')
                ->levenshtein('1')
                ->get(), 1
        );
        
        $this->assertEquals(
            Str('12')
                ->levenshtein('')
                ->get(), 2
        );
        
        $this->assertEquals(
            Str('12')
                ->levenshtein('12')
                ->get(), 0
        );
        
        $this->assertEquals(
            Str('')
                ->levenshtein('12')
                ->get(), 2
        );
        
        $this->assertEquals(
            Str('')
                ->levenshtein('')
                ->get(), 0
        );
        
        $this->assertEquals(
            Str('12привет')
                ->levenshtein('1')
                ->get(), 7
        );
    }
    
    public function testToCharactersArray()
    {
        
        $this->assertEquals(
            is_array(
                Str('0123456789 привет1')->getCharactersArray()
            ), true
        );
        
        $this->assertEquals(
            Str('0123456789  привет1')->getCharactersArray(), [
                                                                0,
                                                                1,
                                                                2,
                                                                3,
                                                                4,
                                                                5,
                                                                6,
                                                                7,
                                                                8,
                                                                9,
                                                                ' ',
                                                                ' ',
                                                                'п',
                                                                'р',
                                                                'и',
                                                                'в',
                                                                'е',
                                                                'т',
                                                                1,
                                                            ]
        );
        
        $this->assertEquals(
            Str('')->getCharactersArray(), []
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
        
        $this->assertEquals(
            Str('   sup  er   ')
                ->trimSpacesLeft()
                ->get(), 'sup  er   '
        );
        
        $this->assertEquals(
            Str('   sup  er   ')
                ->trimSpacesRight()
                ->get(), '   sup  er'
        );
        
        $this->assertEquals(
            Str('   s         u  p  er   ')
                ->trimSpaces()
                ->get(), 's u p er'
        );
    }
    
    public function testPaginationInfo()
    {
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0), '1 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1), '2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2), '3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3), '4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4), '5 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5), '6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6), '7 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7), '8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8), '9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0), '1, 2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2), '3, 4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4), '5, 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6), '7, 8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8), '9, 10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0), '1 - 3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3), '4 - 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6), '7 - 9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0), '1 - 3 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3), '4 - 6 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6), '7 - 9 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9), '10, 11 / 11');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0), '1 - 3 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3), '4 - 6 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6), '7 - 9 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9), '10 - 12 / 12');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0), '1 - 3 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3), '4 - 6 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6), '7 - 9 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9), '10 - 12 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12), '13 / 13');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0), '1 - 10 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10), '11 - 20 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20), '21 - 30 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30), '31 - 40 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40), '41 - 50 / 50');
    }
    
    public function testPaginationInfoComma()
    {
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, '.'), '1 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, '.'), '2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, '.'), '3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, '.'), '4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, '.'), '5 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, '.'), '6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, '.'), '7 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, '.'), '8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, '.'), '9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, '.'), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, '.'), '1.2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, '.'), '3.4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, '.'), '5.6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, '.'), '7.8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, '.'), '9.10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, '.'), '1 - 3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, '.'), '4 - 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, '.'), '7 - 9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, '.'), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, '.'), '1 - 3 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, '.'), '4 - 6 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, '.'), '7 - 9 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, '.'), '10.11 / 11');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, '.'), '1 - 3 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, '.'), '4 - 6 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, '.'), '7 - 9 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, '.'), '10 - 12 / 12');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, '.'), '1 - 3 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, '.'), '4 - 6 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, '.'), '7 - 9 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, '.'), '10 - 12 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, '.'), '13 / 13');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, '.'), '1 - 10 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, '.'), '11 - 20 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, '.'), '21 - 30 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, '.'), '31 - 40 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, '.'), '41 - 50 / 50');
    }
    
    public function testPaginationInfoPeriod()
    {
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', '+'), '1 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', '+'), '2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', '+'), '3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', '+'), '4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', '+'), '5 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', '+'), '6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', '+'), '7 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', '+'), '8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', '+'), '9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', '+'), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', '+'), '1, 2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', '+'), '3, 4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', '+'), '5, 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', '+'), '7, 8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', '+'), '9, 10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', '+'), '1+3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', '+'), '4+6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', '+'), '7+9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', '+'), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', '+'), '1+3 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', '+'), '4+6 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', '+'), '7+9 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', '+'), '10, 11 / 11');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', '+'), '1+3 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', '+'), '4+6 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', '+'), '7+9 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', '+'), '10+12 / 12');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', '+'), '1+3 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', '+'), '4+6 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', '+'), '7+9 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', '+'), '10+12 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', '+'), '13 / 13');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', '+'), '1+10 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', '+'), '11+20 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', '+'), '21+30 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', '+'), '31+40 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', '+'), '41+50 / 50');
    }
    
    public function testPaginationInfoFrom()
    {
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', ' - ', ' / '), '1 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', ' - ', ' / '), '2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', ' - ', ' / '), '3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', ' - ', ' / '), '4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', ' - ', ' / '), '5 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', ' - ', ' / '), '6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', ' - ', ' / '), '7 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', ' - ', ' / '), '8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', ' - ', ' / '), '9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', ' - ', ' / '), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', ' - ', ' / '), '1, 2 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', ' - ', ' / '), '3, 4 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', ' - ', ' / '), '5, 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', ' - ', ' / '), '7, 8 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', ' - ', ' / '), '9, 10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', ' - ', ' / '), '10 / 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', ' - ', ' / '), '10, 11 / 11');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 12');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', ' - ', ' / '), '13 / 13');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', ' - ', ' / '), '1 - 10 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', ' - ', ' / '), '11 - 20 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', ' - ', ' / '), '21 - 30 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', ' - ', ' / '), '31 - 40 / 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', ' - ', ' / '), '41 - 50 / 50');
    }
    
    public function testPaginationInfoCommaPeriodFrom()
    {
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ',,', '--', ' from '), '1 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ',,', '--', ' from '), '2 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ',,', '--', ' from '), '3 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ',,', '--', ' from '), '4 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ',,', '--', ' from '), '5 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ',,', '--', ' from '), '6 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ',,', '--', ' from '), '7 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ',,', '--', ' from '), '8 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ',,', '--', ' from '), '9 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ',,', '--', ' from '), '10 from 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ',,', '--', ' from '), '1,,2 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ',,', '--', ' from '), '3,,4 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ',,', '--', ' from '), '5,,6 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ',,', '--', ' from '), '7,,8 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ',,', '--', ' from '), '9,,10 from 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ',,', '--', ' from '), '1--3 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ',,', '--', ' from '), '4--6 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ',,', '--', ' from '), '7--9 from 10');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ',,', '--', ' from '), '10 from 10');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ',,', '--', ' from '), '1--3 from 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ',,', '--', ' from '), '4--6 from 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ',,', '--', ' from '), '7--9 from 11');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ',,', '--', ' from '), '10,,11 from 11');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ',,', '--', ' from '), '1--3 from 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ',,', '--', ' from '), '4--6 from 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ',,', '--', ' from '), '7--9 from 12');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ',,', '--', ' from '), '10--12 from 12');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ',,', '--', ' from '), '1--3 from 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ',,', '--', ' from '), '4--6 from 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ',,', '--', ' from '), '7--9 from 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ',,', '--', ' from '), '10--12 from 13');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ',,', '--', ' from '), '13 from 13');
        
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ',,', '--', ' from '), '1--10 from 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ',,', '--', ' from '), '11--20 from 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ',,', '--', ' from '), '21--30 from 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ',,', '--', ' from '), '31--40 from 50');
        $this->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ',,', '--', ' from '), '41--50 from 50');
    }
}
