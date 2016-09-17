<?php

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
            $this->assertInstanceOf(\Zver\StringHelper::class, Str($original));
            
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
                ->getFirst(0)
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirst(-5)
                ->get(), 'tring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirst(5)
                ->get(), 'super'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirst(500)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getFirst(-500)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLast(6)
                ->get(), 'string'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLast(-5)
                ->get(), 'super'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLast(0)
                ->get(), ''
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLast(600)
                ->get(), 'superstring'
        );
        
        $this->assertEquals(
            Str('superstring')
                ->getLast(-600)
                ->get(), 'superstring'
        );
    }
}
