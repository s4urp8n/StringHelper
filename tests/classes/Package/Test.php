<?php

namespace Package
{
    
    trait Test
    {
        
        public function foreachTrue(array $values)
        {
            foreach ($values as $value)
            {
                $this->assertTrue($value);
            }
        }
        
        public function foreachFalse(array $values)
        {
            foreach ($values as $value)
            {
                $this->assertFalse($value);
            }
        }
        
    }
}