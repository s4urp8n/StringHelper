<?php

use Zver\StringHelper;

class StringHelperCest
{
    
    public function testIsUpperCase(UnitTester $I)
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
            $I->assertTrue(
                StringHelper::load($true)
                            ->isUpperCase()
            );
        }
        
        foreach ($falses as $false)
        {
            $I->assertFalse(
                StringHelper::load($false)
                            ->isUpperCase()
            );
        }
    }
    
    public function testIsLowerCase(UnitTester $I)
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
            $temp = StringHelper::load($true);
            $I->assertTrue($temp->isLowerCase());

            $I->assertSame($temp->get(), $true);
        }
        
        foreach ($falses as $false)
        {
            $temp = StringHelper::load($false);
            $I->assertFalse($temp->isLowerCase());

            $I->assertSame($temp->get(), $false);
        }
    }
    
    public function testIsTitleCase(UnitTester $I)
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
            $temp = StringHelper::load($true);
            $I->assertTrue($temp->isTitleCase());

            $I->assertSame($temp->get(), $true);
        }
        
        foreach ($falses as $false)
        {
            $temp = StringHelper::load($false);
            $I->assertFalse($temp->isTitleCase());

            $I->assertSame($temp->get(), $false);
        }
    }
    
    public function testIsMatchTest(UnitTester $I)
    {
        
        $I->assertTrue(
            StringHelper::load('')
                        ->isMatch('')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isMatch('/d+')
        );
        
        $I->assertTrue(
            StringHelper::load(' 3521')
                        ->isMatch('')
        );
        
        $I->assertTrue(
            StringHelper::load(' 3521')
                        ->isMatch('\d+')
        );
        
        $I->assertFalse(
            StringHelper::load(' 3521')
                        ->isMatch('^\d+$')
        );
        
        $I->assertTrue(
            StringHelper::load('3521')
                        ->isMatch('\d\d\d\d')
        );
        
        $I->assertTrue(
            StringHelper::load('3521')
                        ->isMatch('\d')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isMatch('\d')
        );
        
        $I->assertTrue(
            StringHelper::load('стринг2' . PHP_EOL . 'CNhbyu22')
                        ->isMatch('\w+\s')
        );
        
        $I->assertTrue(
            StringHelper::load('стринг2' . PHP_EOL . 'CNhbyu22')
                        ->isMatch('[A-Z]+')
        );
        
        $I->assertFalse(
            StringHelper::load('2' . PHP_EOL . 'CN22')
                        ->isMatch('[a-z]+')
        );
        
    }
    
    public function testIses(UnitTester $I)
    {
        
        $str = StringHelper::loadFromFile($this->_getTestFile('windows1251.txt'), 'Windows-1251');
        
        $I->assertTrue($str->isMatch('\w+'));
        
    }
    
    public function _getTestFile($file)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $file;
    }
    
    public function testEmpty(UnitTester $I)
    {
        
        $I->assertTrue(
            StringHelper::load('  ... ')
                        ->isEmpty()
        );
        
        $I->assertTrue(
            StringHelper::load('')
                        ->isEmpty()
        );
        
        $I->assertTrue(
            StringHelper::load('      +_)(*&^%$#@!   _')
                        ->isEmpty()
        );
        
        $I->assertTrue(
            StringHelper::load('__')
                        ->isEmpty()
        );
        
        $I->assertTrue(
            StringHelper::load('       _   ')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('0')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('  f     _   ')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('  fdfвава3     _   ')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('  4     _   ')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('  привет     _   ')
                        ->isEmpty()
        );
        
        $I->assertFalse(
            StringHelper::load('привет')
                        ->isEmpty()
        );
        
        $I->assertTrue(
            StringHelper::load('  ... ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('      +_)(*&^%$#@!   _')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('__')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('       _   ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('0')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('  f     _   ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('  fdfвава3     _   ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('  4     _   ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('  привет     _   ')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertFalse(
            StringHelper::load('привет')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('<p></p> <p> ... </p>')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('<p></p>')
                        ->isEmptyWithoutTags()
        );
        
        $I->assertTrue(
            StringHelper::load('      +_)(*&^%$#@! <p wdwdwdwdwd></p>  _')
                        ->isEmptyWithoutTags()
        );
        
    }
    
    public function testCompare(UnitTester $I)
    {
        
        $I->assertTrue(
            StringHelper::load('qwerty')
                        ->isEqualsIgnoreCase('QweRty')
        );
        
        $I->assertFalse(
            StringHelper::load('qwerty')
                        ->isEquals('QweRty')
        );
        
        $I->assertFalse(
            StringHelper::load('qwerty')
                        ->isEquals('dw3ff3f')
        );
        
    }
    
    public function testIsStartsWith(UnitTester $I)
    {
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWith('')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWith('с')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWithIgnoreCase('С')
        );
        
        $I->assertTrue(
            StringHelper::load('Стартс')
                        ->isStartsWith('Стар')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWith('стартс')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isStartsWith('стартсс')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isStartsWith('кпуцйайайцуайца')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isStartsWith('кп')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isStartsWith('у')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWithIgnoreCase('старТс')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isStartsWith('кп')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isStartsWithIgnoreCase('кп')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWith('')
        );
        
        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isStartsWithIgnoreCase('')
        );
    }
    
    public function testIsEndsWith(UnitTester $I)
    {

        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isEndsWith('')
        );

        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isEndsWithIgnoreCase('стАртС')
        );

        $I->assertTrue(
            StringHelper::load('zzzsdfsdf')
                        ->isEndsWith('')
        );

        $I->assertTrue(
            StringHelper::load('zzzsdfsdf')
                        ->isEndsWithIgnoreCase('')
        );

        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isEndsWith('стартс')
        );

        $I->assertTrue(
            StringHelper::load('стартс')
                        ->isEndsWithIgnoreCase('С')
        );

        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isEndsWith('С')
        );

        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isEndsWith('s')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isEndsWith('сстартс')
        );
        
        $I->assertFalse(
            StringHelper::load('стартс')
                        ->isEndsWithIgnoreCase('zzzsdfsdf')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isEndsWith('zzzsdfsdf')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isEndsWithIgnoreCase('zzzsdfsdf')
        );
        
    }
    
    public function testIsEncodingSupported(UnitTester $I)
    {
        $I->assertTrue(StringHelper::isEncodingSupported('UTF-8'));
        $I->assertFalse(StringHelper::isEncodingSupported('gnweufwegweg'));
        $I->assertFalse(StringHelper::isEncodingSupported(''));
    }
    
    public function testGetSupportedEncodings(UnitTester $I)
    {
        $I->assertTrue(is_array(StringHelper::getSupportedEncodings()));
        $I->assertNotEmpty(StringHelper::getSupportedEncodings());
    }
    
    public function testDefaultEncoding(UnitTester $I)
    {
        $I->assertNotEmpty(StringHelper::getDefaultEncoding());
    }
    
    public function testEncodingSet(UnitTester $I)
    {
        $I->assertEquals(
            StringHelper::load('')
                        ->getEncoding(), StringHelper::getDefaultEncoding()
        );
        
        $I->assertEquals(
            StringHelper::load('', 'UTF-8')
                        ->getEncoding(), 'UTF-8'
        );
        
        $I->assertEquals(
            StringHelper::load('', 'Windows-1251')
                        ->getEncoding(), 'Windows-1251'
        );
        
        $I->assertEquals(
            StringHelper::load('', 'UTF-8')
                        ->convertEncoding('Windows-1251')
                        ->getEncoding(), 'Windows-1251'
        );
        
        $original = StringHelper::load('привет日本語', 'UTF-8');
        $originalString = $original->get();
        $convertedString = $original->convertEncoding('Windows-1251')
                                    ->get();
        
        $I->assertNotEquals($originalString, $convertedString);
    }
    
    public function testLoadConstructToStringGetStringifySet(UnitTester $I)
    {
        
        $toLoad = [
            'string',
            [
                'Arr',
                'ay',
            ],
            StringHelper::load('Superstring'),
        ];
        
        $result = 'stringArraySuperstring';
        
        $I->assertEquals(
            StringHelper::load($toLoad)
                        ->get(), $result
        );
        
        $I->assertEquals(
            StringHelper::load('string')
                        ->get(), 'string'
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->set()
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->set($toLoad)
                        ->get(), $result
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->set($toLoad)
                        ->getEncoding(), StringHelper::getDefaultEncoding()
        );
    }
    
    public function testEncodingSavesAllTime(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load()
                        ->getEncoding(), StringHelper::getDefaultEncoding()
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->set('  ')
                        ->getEncoding(), StringHelper::getDefaultEncoding()
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->set('  ')
                        ->getClone()
                        ->getEncoding(), StringHelper::getDefaultEncoding()
        );
        
        $I->assertEquals(
            StringHelper::load('', 'Windows-1251')
                        ->getEncoding(), 'Windows-1251'
        );
        
        $I->assertEquals(
            StringHelper::load('', 'Windows-1251')
                        ->set('  ')
                        ->getEncoding(), 'Windows-1251'
        );
        
        $I->assertEquals(
            StringHelper::load('', 'Windows-1251')
                        ->set('  ')
                        ->getClone()
                        ->getEncoding(), 'Windows-1251'
        );
        
        $I->assertEquals(
            StringHelper::load('', 'Windows-1251')
                        ->getClone()
                        ->getEncoding(), 'Windows-1251'
        );
        
    }
    
    public function testConvertEncoding(UnitTester $I)
    {
        $utf = $this->_getTestFile('utf8.txt');
        $win = $this->_getTestFile('windows1251.txt');
        
        $I->assertEquals(
            StringHelper::loadFromFile($utf, 'UTF-8')
                        ->length(), StringHelper::loadFromFile($win, 'Windows-1251')
                                                ->length()
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($utf, 'UTF-8')
                        ->convertEncoding('Windows-1251')
                        ->getEncoding(), StringHelper::loadFromFile($win, 'Windows-1251')
                                                     ->getEncoding()
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($utf, 'UTF-8')
                        ->convertEncoding('Windows-1251')
                        ->substring(0, 20)
                        ->get(), StringHelper::loadFromFile($win, 'Windows-1251')
                                             ->substring(0, 20)
                                             ->get()
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($utf, 'UTF-8')
                        ->convertEncoding('Windows-1251')
                        ->get(), StringHelper::loadFromFile($win, 'Windows-1251')
                                             ->get()
        );
        
    }
    
    public function testConvertEncodingReplace(UnitTester $I)
    {
        $win = $this->_getTestFile('windows1251.txt');
        
        $I->assertEquals(
            StringHelper::loadFromFile($win, 'Windows-1251')
                        ->replace('\D', '')
                        ->get(), '1234'
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($win, 'Windows-1251')
                        ->replace('[0-9\s]+', '')
                        ->convertEncoding('UTF-8')
                        ->get(), 'СуперТекстСтрокаСтрокаСтрокаСтрока'
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($win, 'Windows-1251')
                        ->replace('[0-9\s]+', '')
                        ->convertEncoding('UTF-8')
                        ->getEncoding(), 'UTF-8'
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($win, 'Windows-1251')
                        ->replace('[0-9\s]+', '')
                        ->getEncoding(), 'Windows-1251'
        );
        
        $I->assertEquals(
            StringHelper::loadFromFile($win, 'Windows-1251')
                        ->convertEncoding('UTF-8')
                        ->replace('[А-я]+', '')
                        ->replace('\s+', '')
                        ->get(), '1234'
        );
    }
    
    public function testMatches(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('')
                        ->matches('\d{2}'), []
        );
        
        $I->assertEquals(
            StringHelper::load('dsd')
                        ->matches(''), []
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->matches(''), []
        );
        
        $text = '23sd re23w 23dfrgt23 xsdf 23 23 97 7 86 sds
                 sdfsd 678 9899 9899';
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->matches('\d{4}'), [
                9899,
                9899,
            ]
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->matches('\d+'), [
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
            ]
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->matches('\w+'), [
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
            ]
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->matches('zzz'), []
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->matches('[^\s]*sd[^\s]*'), [
                '23sd',
                'xsdf',
                'sds',
                'sdfsd',
            ]
        );
        
    }
    
    public function testCases(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('ПРИвЕТ WoRlD')
                        ->toLowerCase()
                        ->get(), 'привет world'
        );
        
        $I->assertEquals(
            StringHelper::load('ПРИвЕТ WoRlD')
                        ->toUpperCase()
                        ->get(), 'ПРИВЕТ WORLD'
        );
        
        $I->assertEquals(
            StringHelper::load('ПРИвЕТ WoRlD')
                        ->toTitleCase()
                        ->get(), 'Привет World'
        );
    }
    
    public function testRandomCase(UnitTester $I)
    {
        
        $I->assertNotEquals(
            StringHelper::load('invertcaseofmybeautifulstringinvertcaseofmybeautifulstring')
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
        
        $I->assertEquals(
            StringHelper::load('invertcaseofmybeautifulstringinvertcaseofmybeautifulstring')
                        ->toRandomCase()
                        ->toRandomCase()
                        ->toRandomCase()
                        ->toRandomCase()
                        ->toRandomCase()
                        ->toLowerCase()
                        ->get(), 'invertcaseofmybeautifulstringinvertcaseofmybeautifulstring'
        );
        
    }
    
    public function testUcFirst(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('привеТ')
                        ->toUpperCaseFirst()
                        ->get(), 'Привет'
        );
        
        $I->assertEquals(
            StringHelper::load('Привет')
                        ->toUpperCaseFirst()
                        ->get(), 'Привет'
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->toUpperCaseFirst()
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->toUpperCaseFirst()
                        ->get(), ''
        );
    }
    
    public function testNl(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load("\n\nHello!\nMy name is Jay.\n\n")
                        ->newlineToBreak()
                        ->get(), "<br />\n<br />\nHello!<br />\nMy name is Jay.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("\n\nÜbérmensch på høyeste!.\n\n")
                        ->newlineToBreak()
                        ->get(), "<br />\n<br />\nÜbérmensch på høyeste!.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("\n\nПривет!\nМеня зовут Джей.\n\n")
                        ->newlineToBreak()
                        ->get(), "<br />\n<br />\nПривет!<br />\nМеня зовут Джей.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("Übérmensch på høyeste!.<br/><br/>")
                        ->breakToNewline()
                        ->get(), "Übérmensch på høyeste!." . PHP_EOL . PHP_EOL
        );
        
        $I->assertEquals(
            StringHelper::load("Привет.<br/><br/>")
                        ->breakToNewline()
                        ->get(), "Привет." . PHP_EOL . PHP_EOL
        );
        
        $I->assertEquals(
            StringHelper::load("\n\nHello!\nMy name is Jay.\n\n")
                        ->nl2br()
                        ->get(), "<br />\n<br />\nHello!<br />\nMy name is Jay.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("\n\nÜbérmensch på høyeste!.\n\n")
                        ->nl2br()
                        ->get(), "<br />\n<br />\nÜbérmensch på høyeste!.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("\n\nПривет!\nМеня зовут Джей.\n\n")
                        ->nl2br()
                        ->get(), "<br />\n<br />\nПривет!<br />\nМеня зовут Джей.<br />\n<br />\n"
        );
        
        $I->assertEquals(
            StringHelper::load("Übérmensch på høyeste!.<br/><br/>")
                        ->br2nl()
                        ->get(), "Übérmensch på høyeste!." . PHP_EOL . PHP_EOL
        );
        
        $I->assertEquals(
            StringHelper::load("Привет.<br/><br/>")
                        ->br2nl()
                        ->get(), "Привет." . PHP_EOL . PHP_EOL
        );
    }
    
    public function testSetBeginning(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load()
                        ->setBeginning('/привет')
                        ->get(), '/привет'
        );
        
        $I->assertEquals(
            StringHelper::load('/суперпривет')
                        ->setBeginning('/суперпривет')
                        ->get(), '/суперпривет'
        );
        
        $I->assertEquals(
            StringHelper::load('/привет')
                        ->setBeginning('/приветW')
                        ->get(), '/приветW/привет'
        );
        
    }
    
    public function testSetEnding(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load()
                        ->setEnding('/привет')
                        ->get(), '/привет'
        );
        
        $I->assertEquals(
            StringHelper::load('/суперпривет')
                        ->setEnding('/суперпривет')
                        ->get(), '/суперпривет'
        );
        
        $I->assertEquals(
            StringHelper::load('/привет')
                        ->setEnding('/приветW')
                        ->get(), '/привет/приветW'
        );
        
    }
    
    public function testJSON(UnitTester $I)
    {
        $I->assertEquals(
            StringHelper::load(json_encode('string'))
                        ->fromJSON()
                        ->get(), 'string'
        );
        
        $I->assertEquals(
            StringHelper::load('string')
                        ->fromJSON()
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->fromJSON()
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->toJSON()
                        ->get(), '""'
        );
        
        $I->assertEquals(
            StringHelper::load('string')
                        ->toJSON()
                        ->get(), '"string"'
        );
        
    }
    
    public function testSerialization(UnitTester $I)
    {
        $str = StringHelper::load('string');
        $serialized = serialize($str);
        $unserialized = unserialize($serialized);
        $I->assertEquals($unserialized->get(), $str->get());
    }
    
    public function testEntities(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('<img src="/e.png" />')
                        ->toHTMLEntities()
                        ->get(), '&lt;img src=&quot;/e.png&quot; /&gt;'
        );
        
        $I->assertEquals(
            StringHelper::load('&lt;img src=&quot;/e.png&quot; /&gt;')
                        ->fromHTMLEntities()
                        ->get(), '<img src="/e.png" />'
        );
        
        $I->assertEquals(
            StringHelper::load('<img src="/e.png" />')
                        ->toHTMLEntities()
                        ->removeEntities()
                        ->get(), 'img src=/e.png /'
        );
    }
    
    public function testURLCoding(UnitTester $I)
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toURL()
                        ->get(), 'www.example.com%2Fadmin%3Fi%3D1%26ref%3Dhttp%3A%2F%2Fex.ru%2Fer'
        );
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toURL()
                        ->fromURL()
                        ->get(), $url
        );
    }
    
    public function testUUE(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('ПриветCat')
                        ->toUUE()
                        ->remove('\s+')
                        ->get(), '/T)_1@-"XT++0M=&"0V%T`'
        );
        
        $I->assertEquals(
            StringHelper::load('ПриветCat')
                        ->toUUE()
                        ->fromUUE()
                        ->get(), 'ПриветCat'
        );
    }
    
    public function testBase64Coding(UnitTester $I)
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/er';
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toBase64()
                        ->get(), 'd3d3LmV4YW1wbGUuY29tL2FkbWluP2k9MSZyZWY9aHR0cDovL2V4LnJ1L2Vy'
        );
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toBase64()
                        ->fromBase64()
                        ->get(), $url
        );
    }
    
    public function testUTF8Coding(UnitTester $I)
    {
        
        $url = 'www.example.com/admin?i=1&ref=http://ex.ru/привет';
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toUTF8()
                        ->get(), 'www.example.com/admin?i=1&ref=http://ex.ru/Ð¿ÑÐ¸Ð²ÐµÑ'
        );
        
        $I->assertEquals(
            StringHelper::load($url)
                        ->toUTF8()
                        ->fromUTF8()
                        ->get(), $url
        );
    }
    
    public function testSerialized(UnitTester $I)
    {
        $I->assertFalse(
            StringHelper::load('123')
                        ->isSerialized()
        );
        
        $I->assertFalse(
            StringHelper::load('прийцавйыв')
                        ->isSerialized()
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->isSerialized()
        );
        
        $I->assertTrue(
            StringHelper::load(
                serialize(
                    [
                        'd2fdqw',
                        '23asdasd',
                    ]
                )
            )
                        ->isSerialized()
        );
    }
    
    public function testPunycode(UnitTester $I)
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
            
            $I->assertTrue(
                StringHelper::load($original)
                            ->toPunyCode()
                            ->isEqualsIgnoreCase($punycode)
            );
            
            $I->assertTrue(
                StringHelper::load($punycode)
                            ->fromPunyCode()
                            ->isEqualsIgnoreCase($original)
            );
            
            $I->assertTrue(
                StringHelper::load($punycode)
                            ->fromPunyCode()
                            ->toPunyCode()
                            ->isEqualsIgnoreCase($punycode)
            );
            
            $I->assertTrue(
                StringHelper::load($original)
                            ->toPunyCode()
                            ->fromPunyCode()
                            ->isEqualsIgnoreCase($original)
            );
        }
    }
    
    public function testLoadFromFile(UnitTester $I)
    {
        
        $file = __DIR__ . DIRECTORY_SEPARATOR . '_' . md5(
                uniqid('', true)
            ) . 'testWrite.txt';
        
        StringHelper::load('1263')
                    ->saveToFile($file);
        
        $I->assertEquals(
            StringHelper::loadFromFile($file)
                        ->get(), '1263'
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->setFromFile($file)
                        ->get(), '1263'
        );
        
        StringHelper::load('привет')
                    ->saveToFile($file);
        
        $I->assertEquals(
            StringHelper::loadFromFile($file)
                        ->get(), 'привет'
        );
        
        unlink($file);
        
    }
    
    public function testSaveToFile(UnitTester $I)
    {
        
        $file = __DIR__ . DIRECTORY_SEPARATOR . '_' . md5(
                uniqid('', true)
            ) . 'testWrite.txt';
        
        StringHelper::load('1263')
                    ->saveToFile($file);
        
        $I->assertEquals(
            StringHelper::load()
                        ->setFromFile($file)
                        ->get(), '1263'
        );
        
        StringHelper::load('1263')
                    ->appendToFile($file);
        
        $I->assertEquals(
            StringHelper::load()
                        ->setFromFile($file)
                        ->get(), '12631263'
        );
        
        StringHelper::load('привет')
                    ->saveToFile($file);
        
        $I->assertEquals(
            StringHelper::load()
                        ->setFromFile($file)
                        ->get(), 'привет'
        );
        
        unlink($file);
        
    }
    
    public function testFill(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('x')
                        ->fillLeft('s', 5)
                        ->get(), 'ssssx'
        );
        
        $I->assertEquals(
            StringHelper::load('x')
                        ->fillLeft(' ', 5)
                        ->get(), '    x'
        );
        
        $I->assertEquals(
            StringHelper::load('x')
                        ->fillLeft('s2', 5)
                        ->get(), 's2s2x'
        );
        
        $I->assertEquals(
            StringHelper::load('x')
                        ->fillLeft('s', 1)
                        ->get(), 'x'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillLeft('п2', 5)
                        ->get(), 'п2п2а'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillLeft('п23', 5)
                        ->get(), 'п23па'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillLeft('п', 1)
                        ->get(), 'а'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillLeft('', -22)
                        ->get(), 'а'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillRight('п', 1)
                        ->get(), 'а'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillRight('п', 2)
                        ->get(), 'ап'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillRight('п23', 10)
                        ->get(), 'ап23п23п23'
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->fillRight('', 2)
                        ->get(), 'а'
        );
    }
    
    public function testContains(UnitTester $I)
    {
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->contains('l')
        );
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->contains('hello')
        );
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->containsIgnoreCase('HELLO')
        );
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->contains('o')
        );
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->contains('h')
        );
        
        $I->assertFalse(
            StringHelper::load('hello')
                        ->contains('L')
        );
        
        $I->assertFalse(
            StringHelper::load('hello')
                        ->contains('Ll')
        );
        
        $I->assertTrue(
            StringHelper::load('hello')
                        ->containsIgnoreCase('L')
        );
        
        $I->assertFalse(
            StringHelper::load('hello')
                        ->containsIgnoreCase('z')
        );
    }
    
    public function testGetPosition(UnitTester $I)
    {
        
        $I->assertFalse(
            StringHelper::load('')
                        ->getPosition('l')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->getPositionFromEnd('l')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->getPositionIgnoreCase('l')
        );
        
        $I->assertFalse(
            StringHelper::load('')
                        ->getPositionFromEndIgnoreCase('l')
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionFromEnd('l'), 3
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionFromEndIgnoreCase('l'), 3
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionIgnoreCase('L'), 2
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionFromEndIgnoreCase('h'), false
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionFromEndIgnoreCase('H'), 0
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionIgnoreCase('l'), 2
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionFromEndIgnoreCase('L'), 3
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionIgnoreCase('L'), 2
        );
        
        $I->assertEquals(
            StringHelper::load('Hello')
                        ->getPositionIgnoreCase('F'), false
        );
    }
    
    public function testLen(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('helloпривет')
                        ->length(), 11
        );
        
        $I->assertEquals(
            StringHelper::load('а')
                        ->length(), 1
        );
        
        $I->assertEquals(
            StringHelper::load('привет日本語')
                        ->length(), 9
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->length(), 0
        );
    }
    
    public function testSubstringCount(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')
                        ->getSubstringCount('s'), 4
        );
        
        $I->assertEquals(
            StringHelper::load('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')
                        ->getSubstringCount('.'), 3
        );
        
        $I->assertEquals(
            StringHelper::load('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')
                        ->getSubstringCount('?'), 1
        );
        
        $I->assertEquals(
            StringHelper::load('а b. sd sd? sdsd! Привет! Пока.. Мне Снова 17')
                        ->getSubstringCount('!'), 2
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->getSubstringCount('dwd'), 0
        );
    }
    
    public function testSubstring(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('h')
                        ->substring()
                        ->get(), 'h'
        );
        
        $I->assertEquals(
            StringHelper::load('hh')
                        ->substring(1)
                        ->get(), 'h'
        );
        
        $I->assertEquals(
            StringHelper::load('hh')
                        ->substring(0)
                        ->get(), 'hh'
        );
        
        $I->assertEquals(
            StringHelper::load('1234567890')
                        ->substring(-3)
                        ->get(), '890'
        );
        
        $I->assertEquals(
            StringHelper::load('1234567890')
                        ->substring(-30)
                        ->get(), '1234567890'
        );
        
        $I->assertEquals(
            StringHelper::load('1234567890')
                        ->substring(-30, 90)
                        ->get(), '1234567890'
        );
        
        $I->assertEquals(
            StringHelper::load('1234567890')
                        ->substring(3, 3)
                        ->get(), '456'
        );
        
        $I->assertEquals(
            StringHelper::load('1234567890')
                        ->substring(3, 13)
                        ->get(), '4567890'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getFirst(0)
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getFirst(-5)
                        ->get(), 'tring'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getFirst(5)
                        ->get(), 'super'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getFirst(500)
                        ->get(), 'superstring'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getFirst(-500)
                        ->get(), 'superstring'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getLast(6)
                        ->get(), 'string'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getLast(-5)
                        ->get(), 'super'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getLast(0)
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getLast(600)
                        ->get(), 'superstring'
        );
        
        $I->assertEquals(
            StringHelper::load('superstring')
                        ->getLast(-600)
                        ->get(), 'superstring'
        );
    }
    
    public function testSplit(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('1 2 3 4 5        6 7 8 9_0')
                        ->split('[\s_]+'), [
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
        
        $I->assertEquals(
            StringHelper::load('1 2 3 4 5 6 7 8 9_0')
                        ->split('x'), ['1 2 3 4 5 6 7 8 9_0']
        );
    }
    
    public function testReplaceRemove(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('\s+|\d+', '')
                        ->get(), 'qwerty'
        );
        
        $I->assertEquals(
            StringHelper::load('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->remove('\s+|\d+')
                        ->get(), 'qwerty'
        );
        
        $I->assertEquals(
            StringHelper::load('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('\d', ' ')
                        ->get(), '     qwe    r   t   y         '
        );
        
        $I->assertEquals(
            StringHelper::load('12qweQWE35')
                        ->replace('[qwe]+', '')
                        ->get(), '12QWE35'
        );
        
        $I->assertEquals(
            StringHelper::load('12qweQWE35')
                        ->replace('[qweQWE]+', '')
                        ->get(), '1235'
        );
        
        $I->assertEquals(
            StringHelper::load('12345qwe2 4 r 5 t4 6y75 46 35 ')
                        ->replace('', ' ')
                        ->get(), ' 1 2 3 4 5 q w e 2   4   r   5   t 4   6 y 7 5   4 6   3 5   '
        );
        
    }
    
    public function testConcatAppendPrepend(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('l')
                        ->concat(
                            'e', 't', StringHelper::load('ter'), [
                                   ' ',
                                   'for',
                                   [
                                       ' ',
                                       'm',
                                       'e',
                                   ],
                               ]
                        )
                        ->get(), 'letter for me'
        );
        
        $I->assertEquals(
            StringHelper::load('l')
                        ->concat()
                        ->get(), 'l'
        );
        
        $I->assertEquals(
            StringHelper::load('1')
                        ->concat('1')
                        ->append('2')
                        ->prepend('3')
                        ->get(), '3112'
        );
    }
    
    public function testReverse(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('12345')
                        ->reverse()
                        ->get(), '54321'
        );
        
        $I->assertEquals(
            StringHelper::load('тевирп')
                        ->reverse()
                        ->get(), 'привет'
        );
        
        $I->assertEquals(
            StringHelper::load('olleh')
                        ->reverse()
                        ->get(), 'hello'
        );
    }
    
    public function testRepeat(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('12345')
                        ->repeat(3)
                        ->get(), '123451234512345'
        );
        
        $I->assertEquals(
            StringHelper::load('ыh')
                        ->repeat(3)
                        ->get(), 'ыhыhыh'
        );
        
        $I->assertEquals(
            StringHelper::load('привет')
                        ->repeat(5)
                        ->get(), 'приветприветприветприветпривет'
        );
        
        $I->assertEquals(
            StringHelper::load('h')
                        ->repeat(1)
                        ->get(), 'h'
        );
        
        $I->assertEquals(
            StringHelper::load('h')
                        ->repeat(0)
                        ->get(), 'h'
        );
        
        $I->assertEquals(
            StringHelper::load('h')
                        ->repeat(-1)
                        ->get(), 'h'
        );
    }
    
    public function testGetParts(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getParts(
                            [
                                2,
                                1,
                                0,
                            ], '-', ':'
                        )
                        ->get(), '01:11:2011'
        );
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getParts([2], '-', ':')
                        ->get(), '01'
        );
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getParts(2, '-', ':')
                        ->get(), '01'
        );
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getParts(0, '-', ':')
                        ->get(), '2011'
        );
        
        $I->assertEquals(
            StringHelper::load('2011 11 01')
                        ->getParts()
                        ->get(), '2011'
        );
        
        $I->assertEquals(
            StringHelper::load('2011 11 01')
                        ->getParts(0)
                        ->get(), '2011'
        );
        
        $I->assertEquals(
            StringHelper::load('2011 11 01')
                        ->getParts(1)
                        ->get(), '11'
        );
        
        $I->assertEquals(
            StringHelper::load('2011 11 01')
                        ->getParts(2)
                        ->get(), '01'
        );
        
        $I->assertEquals(
            StringHelper::load('2011 11 01')
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
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getFirstPart('-')
                        ->get(), '2011'
        );
        
        $I->assertEquals(
            StringHelper::load('2011')
                        ->getFirstPart('-')
                        ->get(), '2011'
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->getFirstPart('-')
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('2011-11-01')
                        ->getLastPart('-')
                        ->get(), '01'
        );
        
        $I->assertEquals(
            StringHelper::load('2011')
                        ->getLastPart('-')
                        ->get(), '2011'
        );
    }
    
    public function testRemoveBeginningEnding(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('c3string')
                        ->removeBeginning('c3')
                        ->get(), 'string'
        );
        
        $I->assertEquals(
            StringHelper::load('c3string')
                        ->removeBeginning('c3string')
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('sd3dfgfdgfdg')
                        ->removeBeginning('3')
                        ->get(), 'sd3dfgfdgfdg'
        );
        
        $I->assertEquals(
            StringHelper::load('c3string')
                        ->removeEnding('g')
                        ->get(), 'c3strin'
        );
        
        $I->assertEquals(
            StringHelper::load('c3string')
                        ->removeEnding('c3string')
                        ->get(), ''
        );
        
        $I->assertEquals(
            StringHelper::load('sd3dfgfdgfdg')
                        ->removeEnding('4444')
                        ->get(), 'sd3dfgfdgfdg'
        );
        
    }
    
    public function testTransliteration(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('ああああああああ"Привет-лунатикам.!? :78 Хорошо, плохо()[]{}うう')
                        ->transliterate()
                        ->get(), 'aaaaaaaa"Privet-lunatikam.!? :78 Horoso, ploho()[]{}uu'
        );
        
        $I->assertEquals(
            StringHelper::load('Привет-лунатикам 日本語! 蓋 私、，…‥。「　」『　』')
                        ->transliterate()
                        ->get(), 'Privet-lunatikam ri ben yu! gai si,,......'
        );
        
        $I->assertEquals(
            StringHelper::load(
                'Возвращает строку string, в которой первый символ переведен в верхний регистр, если этот символ буквенный.'
            )
                        ->transliterate()
                        ->get(),
            'Vozvrasaet stroku string, v kotoroj pervyj simvol pereveden v verhnij registr, esli etot simvol bukvennyj.'
        );
    }
    
    public function testSlugify(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load(
                'Привет-лунатикlunatikam.!? :78 Horoso, ploho()[]{}ам 日本語! ' . 'A æ_Übérmensch på høyeste nivå! '
                . 'И я_люблю PHP! Есть?'
            )
                        ->slugify()
                        ->get(),
            'privet-lunatiklunatikam-78-horoso-ploho-am-ri-ben-yu-a-ae-ubermensch-pa-hoyeste-niva-i-a-lublu-php-est'
        );
        
        $I->assertEquals(
            StringHelper::load('Привет-лунатикам 日本語! 蓋 私、，…‥。「　」『　』')
                        ->slugify()
                        ->get(), 'privet-lunatikam-ri-ben-yu-gai-si'
        );
        
        $I->assertEquals(
            'sensio', StringHelper::load('SenSio')
                                  ->slugify()
        );
        $I->assertEquals(
            'sensio-labs', StringHelper::load('sensio labs')
                                       ->slugify()
        );
        $I->assertEquals(
            'sensio-labs', StringHelper::load('sensio   labs')
                                       ->slugify()
        );
        $I->assertEquals(
            'paris-france', StringHelper::load('paris,france')
                                        ->slugify()
        );
        $I->assertEquals(
            'sensio', StringHelper::load('  sensio')
                                  ->slugify()
        );
        $I->assertEquals(
            'sensio', StringHelper::load('sensio  ')
                                  ->slugify()
        );
        $I->assertEquals(
            '', StringHelper::load('')
                            ->slugify()
        );
    }
    
    public function testHyphenate(UnitTester $I)
    {
        $I->assertEquals(
            StringHelper::load('- __ under score  me ')
                        ->hyphenate()
                        ->get(), '-under-score-me-'
        );
        $I->assertEquals(
            StringHelper::load('')
                        ->hyphenate()
                        ->get(), ''
        );
    }
    
    public function testUnderscore(UnitTester $I)
    {
        $I->assertEquals(
            StringHelper::load('_ - under score  me ')
                        ->underscore()
                        ->get(), '_under_score_me_'
        );
        $I->assertEquals(
            StringHelper::load('')
                        ->underscore()
                        ->get(), ''
        );
    }
    
    public function testShuffleCharacters(UnitTester $I)
    {
        
        $original = 'sdfghtyui opl';
        
        $originalArray = StringHelper::load($original)
                                     ->toCharactersArray();
        
        $shuffled = StringHelper::load($original)
                                ->shuffleCharacters();
        
        $shuffledArray = $shuffled->toCharactersArray();
        
        $I->assertEquals($shuffled->length(), mb_strlen($original, 'UTF-8'));
        
        $I->assertNotEquals($original, $shuffled->get());
        
        foreach ($originalArray as $value)
        {
            $I->assertEquals(in_array($value, $shuffledArray), true);
        }
    }
    
    public function testFooterYears(UnitTester $I)
    {
        $currentYear = new \DateTime();
        $currentYear = $currentYear->format('Y');
        
        $I->assertEquals(
            StringHelper::load()
                        ->footerYears($currentYear - 100)
                        ->get(), ($currentYear - 100) . '—' . $currentYear
        );
        
        $I->assertEquals(
            StringHelper::load()
                        ->footerYears($currentYear)
                        ->get(), $currentYear
        );
    }
    
    public function testRemoveTags(UnitTester $I)
    {
        $html = StringHelper::loadFromFile($this->_getTestFile('html.html'))
                            ->removeTags()
                            ->trimSpaces();
        
        $I->assertEquals($html, 'PHP: mb_ereg - Manual');
    }
    
    public function testSoundex(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('Lukasiewicz')
                        ->soundex()
                        ->get(), 'L222'
        );
        
        $I->assertEquals(
            StringHelper::load('hello')
                        ->soundex()
                        ->get(), 'H400'
        );
        
        $I->assertEquals(
            StringHelper::load('hell')
                        ->soundex()
                        ->get(), 'H400'
        );
        
        $I->assertEquals(
            StringHelper::load('he')
                        ->soundex()
                        ->get(), 'H000'
        );
        
        $I->assertEquals(
            StringHelper::load('she')
                        ->soundex()
                        ->get(), 'S000'
        );
        
        $I->assertEquals(
            StringHelper::load('привет')
                        ->soundex()
                        ->get(), 'P613'
        );
        
        $I->assertEquals(
            StringHelper::load('пока')
                        ->soundex()
                        ->get(), 'P200'
        );
        
        $I->assertEquals(
            StringHelper::load('letter')
                        ->soundex()
                        ->get(), 'L360'
        );
        
        $I->assertEquals(
            StringHelper::load('Съешь еще этих мягких французских булочек да выпей чаю')
                        ->soundex()
                        ->get(), 'S200E200E300M200F652B422D000V120C000'
        );
    }
    
    public function testMetaphone(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('Lukasiewicz')
                        ->metaphone()
                        ->get(), 'LKSWKS'
        );
        
        $I->assertEquals(
            StringHelper::load('hello')
                        ->metaphone()
                        ->get(), 'HL'
        );
        
        $I->assertEquals(
            StringHelper::load('hell')
                        ->metaphone()
                        ->get(), 'HL'
        );
        
        $I->assertEquals(
            StringHelper::load('he')
                        ->metaphone()
                        ->get(), 'H'
        );
        
        $I->assertEquals(
            StringHelper::load('she')
                        ->metaphone()
                        ->get(), 'X'
        );
        
        $I->assertEquals(
            StringHelper::load('привет')
                        ->metaphone()
                        ->get(), 'PRFT'
        );
        
        $I->assertEquals(
            StringHelper::load('пока')
                        ->metaphone()
                        ->get(), 'PK'
        );
        
        $I->assertEquals(
            StringHelper::load('letter')
                        ->metaphone()
                        ->get(), 'LTR'
        );
        
        $I->assertEquals(
            StringHelper::load('съешь еще этих мягких французских булочек да выпей чаю')
                        ->metaphone()
                        ->get(), 'SSESETMKKFRNKSSKBLSKTFPJK'
        );
        
    }
    
    public function testLevenshtein(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('123sdadwdwedwdwdwdwwdw')
                        ->levenshtein('12345')
                        ->get(), 19
        );
        
        $I->assertEquals(
            StringHelper::load('12345')
                        ->levenshtein('12345')
                        ->get(), 0
        );
        
        $I->assertEquals(
            StringHelper::load('12')
                        ->levenshtein('1')
                        ->get(), 1
        );
        
        $I->assertEquals(
            StringHelper::load('12')
                        ->levenshtein('')
                        ->get(), 2
        );
        
        $I->assertEquals(
            StringHelper::load('12')
                        ->levenshtein('12')
                        ->get(), 0
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->levenshtein('12')
                        ->get(), 2
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->levenshtein('')
                        ->get(), 0
        );
        
        $I->assertEquals(
            StringHelper::load('12привет')
                        ->levenshtein('1')
                        ->get(), 7
        );
    }
    
    public function testToCharactersArray(UnitTester $I)
    {
        
        $I->assertEquals(
            is_array(
                StringHelper::load('0123456789 привет1')
                            ->toCharactersArray()
            ), true
        );
        
        $I->assertEquals(
            StringHelper::load('0123456789  привет1')
                        ->toCharactersArray(), [
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
        
        $I->assertEquals(
            StringHelper::load('')
                        ->toCharactersArray(), []
        );
        
    }
    
    public function testToLinesArray(UnitTester $I)
    {
        
        $text =
            "Ghbпри ваыв выввцвцвц" . PHP_EOL . "" . PHP_EOL . "" . PHP_EOL . "цвйцвцйвцй" . PHP_EOL . "" . PHP_EOL . ""
            . PHP_EOL . "йцвцйвйцв";
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->toLinesArray(), [
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
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->toLinesArray(), [
                'Ghbпри',
            ]
        );
    }
    
    public function testTrim(UnitTester $I)
    {
        
        $I->assertEquals(
            StringHelper::load('   sup  er   ')
                        ->trimSpacesLeft()
                        ->get(), 'sup  er   '
        );
        
        $I->assertEquals(
            StringHelper::load('   sup  er   ')
                        ->trimSpacesRight()
                        ->get(), '   sup  er'
        );
        
        $I->assertEquals(
            StringHelper::load('   s         u  p  er   ')
                        ->trimSpaces()
                        ->get(), 's u p er'
        );
    }
    
    public function testPreview(UnitTester $I)
    {
        $text = '<a><p style="display:none">some preview   text </p>   </a>';
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-10000000), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1000), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15), 'some preview...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16), 'some preview...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2000), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20000000), 'some preview text'
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-10000000, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1000, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5, '--'), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13, '--'), 'some--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14, '--'), 'some preview--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15, '--'), 'some preview--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16, '--'), 'some preview--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17, '--'), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18, '--'), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19, '--'), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20, '--'), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2000, '--'), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20000000, '--'), 'some preview text'
        );
        
    }
    
    public function testPreviewEnd(UnitTester $I)
    {
        $text = '<a><p style="display:none">some preview   text </p>   </a>';
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-10000000, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1000, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14, '...', false), '...text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15, '...', false), '...preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16, '...', false), '...preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17, '...', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18, '...', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19, '...', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20, '...', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2000, '...', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20000000, '...', false), 'some preview text'
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-10000000, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1000, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5, '--', false), '--'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13, '--', false), '--text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14, '--', false), '--preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15, '--', false), '--preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16, '--', false), '--preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17, '--', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18, '--', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19, '--', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20, '--', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2000, '--', false), 'some preview text'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20000000, '--', false), 'some preview text'
        );
        
    }
    
    public function testPreviewPunctuations(UnitTester $I)
    {
        $text = 'some, pre...   text! ';
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(21), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22000), 'some, pre... text!'
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15, '...', false), '...pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16, '...', false), '...pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17, '...', false), '...pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18, '...', false), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19, '...', false), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20, '...', false), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(21, '...', false), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22, '...', false), 'some, pre... text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22000, '...', false), 'some, pre... text!'
        );
        
        $text = 'some, pre___   text! ';
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14), 'some...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17), 'some, pre...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(21), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22000), 'some, pre___ text!'
        );
        
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(-1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(0, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(1, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(2, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(3, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(4, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(5, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(6, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(7, '...', false), '...'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(8, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(9, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(10, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(11, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(12, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(13, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(14, '...', false), '...text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(15, '...', false), '...pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(16, '...', false), '...pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(17, '...', false), '...pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(18, '...', false), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(19, '...', false), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(20, '...', false), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(21, '...', false), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22, '...', false), 'some, pre___ text!'
        );
        $I->assertEquals(
            StringHelper::load($text)
                        ->getPreview(22000, '...', false), 'some, pre___ text!'
        );
    }
    
    public function testSpanify(UnitTester $I)
    {
        $I->assertEquals(
            StringHelper::load('')
                        ->spanify()
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load(' ')
                        ->spanify()
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('    ')
                        ->spanify()
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('             ')
                        ->spanify()
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('one')
                        ->spanify()
                        ->get(),
            '<span class="word"><span class="char">o</span><span class="char">n</span><span class="char">e</span></span>'
        );
        $I->assertEquals(
            StringHelper::load('one    one                 ')
                        ->spanify()
                        ->get(),
            '<span class="word"><span class="char">o</span><span class="char">n</span><span class="char">e</span></span><span class="space"> </span><span class="word"><span class="char">o</span><span class="char">n</span><span class="char">e</span></span>'
        );
        
        $I->assertEquals(
            StringHelper::load('')
                        ->spanify('prefix-')
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load(' ')
                        ->spanify('prefix-')
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('    ')
                        ->spanify('prefix-')
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('             ')
                        ->spanify('prefix-')
                        ->get(), ''
        );
        $I->assertEquals(
            StringHelper::load('one')
                        ->spanify('prefix-')
                        ->get(),
            '<span class="prefix-word"><span class="prefix-char">o</span><span class="prefix-char">n</span><span class="prefix-char">e</span></span>'
        );
        $I->assertEquals(
            StringHelper::load('one    one                 ')
                        ->spanify('prefix-')
                        ->get(),
            '<span class="prefix-word"><span class="prefix-char">o</span><span class="prefix-char">n</span><span class="prefix-char">e</span></span><span class="prefix-space"> </span><span class="prefix-word"><span class="prefix-char">o</span><span class="prefix-char">n</span><span class="prefix-char">e</span></span>'
        );
        
    }
    
    public function testPaginationInfo(UnitTester $I)
    {
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0), '1 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1), '2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2), '3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3), '4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4), '5 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5), '6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6), '7 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7), '8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8), '9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0), '1, 2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2), '3, 4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4), '5, 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6), '7, 8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8), '9, 10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0), '1 - 3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3), '4 - 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6), '7 - 9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0), '1 - 3 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3), '4 - 6 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6), '7 - 9 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9), '10, 11 / 11');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0), '1 - 3 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3), '4 - 6 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6), '7 - 9 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9), '10 - 12 / 12');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0), '1 - 3 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3), '4 - 6 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6), '7 - 9 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9), '10 - 12 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12), '13 / 13');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0), '1 - 10 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10), '11 - 20 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20), '21 - 30 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30), '31 - 40 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40), '41 - 50 / 50');
    }
    
    public function testPaginationInfoComma(UnitTester $I)
    {
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, '.'), '1 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, '.'), '2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, '.'), '3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, '.'), '4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, '.'), '5 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, '.'), '6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, '.'), '7 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, '.'), '8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, '.'), '9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, '.'), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, '.'), '1.2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, '.'), '3.4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, '.'), '5.6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, '.'), '7.8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, '.'), '9.10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, '.'), '1 - 3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, '.'), '4 - 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, '.'), '7 - 9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, '.'), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, '.'), '1 - 3 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, '.'), '4 - 6 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, '.'), '7 - 9 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, '.'), '10.11 / 11');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, '.'), '1 - 3 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, '.'), '4 - 6 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, '.'), '7 - 9 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, '.'), '10 - 12 / 12');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, '.'), '1 - 3 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, '.'), '4 - 6 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, '.'), '7 - 9 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, '.'), '10 - 12 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, '.'), '13 / 13');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, '.'), '1 - 10 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, '.'), '11 - 20 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, '.'), '21 - 30 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, '.'), '31 - 40 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, '.'), '41 - 50 / 50');
    }
    
    public function testPaginationInfoPeriod(UnitTester $I)
    {
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', '+'), '1 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', '+'), '2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', '+'), '3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', '+'), '4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', '+'), '5 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', '+'), '6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', '+'), '7 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', '+'), '8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', '+'), '9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', '+'), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', '+'), '1, 2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', '+'), '3, 4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', '+'), '5, 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', '+'), '7, 8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', '+'), '9, 10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', '+'), '1+3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', '+'), '4+6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', '+'), '7+9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', '+'), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', '+'), '1+3 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', '+'), '4+6 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', '+'), '7+9 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', '+'), '10, 11 / 11');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', '+'), '1+3 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', '+'), '4+6 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', '+'), '7+9 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', '+'), '10+12 / 12');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', '+'), '1+3 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', '+'), '4+6 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', '+'), '7+9 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', '+'), '10+12 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', '+'), '13 / 13');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', '+'), '1+10 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', '+'), '11+20 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', '+'), '21+30 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', '+'), '31+40 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', '+'), '41+50 / 50');
    }
    
    public function testPaginationInfoFrom(UnitTester $I)
    {
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ', ', ' - ', ' / '), '1 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ', ', ' - ', ' / '), '2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ', ', ' - ', ' / '), '3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ', ', ' - ', ' / '), '4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ', ', ' - ', ' / '), '5 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ', ', ' - ', ' / '), '6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ', ', ' - ', ' / '), '7 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ', ', ' - ', ' / '), '8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ', ', ' - ', ' / '), '9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ', ', ' - ', ' / '), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ', ', ' - ', ' / '), '1, 2 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ', ', ' - ', ' / '), '3, 4 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ', ', ' - ', ' / '), '5, 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ', ', ' - ', ' / '), '7, 8 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ', ', ' - ', ' / '), '9, 10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ', ', ' - ', ' / '), '10 / 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ', ', ' - ', ' / '), '10, 11 / 11');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 12');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ', ', ' - ', ' / '), '1 - 3 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ', ', ' - ', ' / '), '4 - 6 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ', ', ' - ', ' / '), '7 - 9 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ', ', ' - ', ' / '), '10 - 12 / 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ', ', ' - ', ' / '), '13 / 13');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ', ', ' - ', ' / '), '1 - 10 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ', ', ' - ', ' / '), '11 - 20 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ', ', ' - ', ' / '), '21 - 30 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ', ', ' - ', ' / '), '31 - 40 / 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ', ', ' - ', ' / '), '41 - 50 / 50');
    }
    
    public function testPaginationInfoCommaPeriodFrom(UnitTester $I)
    {
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 0, ',,', '--', ' from '), '1 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 1, ',,', '--', ' from '), '2 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 2, ',,', '--', ' from '), '3 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 3, ',,', '--', ' from '), '4 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 4, ',,', '--', ' from '), '5 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 5, ',,', '--', ' from '), '6 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 6, ',,', '--', ' from '), '7 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 7, ',,', '--', ' from '), '8 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 8, ',,', '--', ' from '), '9 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 1, 9, ',,', '--', ' from '), '10 from 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 0, ',,', '--', ' from '), '1,,2 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 2, ',,', '--', ' from '), '3,,4 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 4, ',,', '--', ' from '), '5,,6 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 6, ',,', '--', ' from '), '7,,8 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 2, 8, ',,', '--', ' from '), '9,,10 from 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 0, ',,', '--', ' from '), '1--3 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 3, ',,', '--', ' from '), '4--6 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 6, ',,', '--', ' from '), '7--9 from 10');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(10, 3, 9, ',,', '--', ' from '), '10 from 10');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 0, ',,', '--', ' from '), '1--3 from 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 3, ',,', '--', ' from '), '4--6 from 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 6, ',,', '--', ' from '), '7--9 from 11');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(11, 3, 9, ',,', '--', ' from '), '10,,11 from 11');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 0, ',,', '--', ' from '), '1--3 from 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 3, ',,', '--', ' from '), '4--6 from 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 6, ',,', '--', ' from '), '7--9 from 12');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(12, 3, 9, ',,', '--', ' from '), '10--12 from 12');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 0, ',,', '--', ' from '), '1--3 from 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 3, ',,', '--', ' from '), '4--6 from 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 6, ',,', '--', ' from '), '7--9 from 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 9, ',,', '--', ' from '), '10--12 from 13');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(13, 3, 12, ',,', '--', ' from '), '13 from 13');
        
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 0, ',,', '--', ' from '), '1--10 from 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 10, ',,', '--', ' from '), '11--20 from 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 20, ',,', '--', ' from '), '21--30 from 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 30, ',,', '--', ' from '), '31--40 from 50');
        $I->assertEquals(StringHelper::getScrollPaginationInfo(50, 10, 40, ',,', '--', ' from '), '41--50 from 50');
    }

    public function testEqualsSomeAndEqualsIgnoreCase(UnitTester $I)
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
            $I->assertEquals(
                $testData['result'], StringHelper::load($testData['str'])
                                                 ->isEqualsSome($testData['values'])
            );
        }

        foreach ($testDataEqualsSomeIgnoreCase as $testData)
        {
            $I->assertEquals(
                $testData['result'], StringHelper::load($testData['str'])
                                                 ->isEqualsSomeIgnoreCase($testData['values'])
            );
        }

    }
    
}
