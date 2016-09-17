<?php
namespace Zver\StringHelper\Traits
{
    
    trait Equals
    {
        
        protected $string = '';
        
        /**
         * Return true if loaded string equals some of value in values array, false otherwise
         *
         * @param array $values
         *
         * @return bool
         */
        public function isEqualsSome(array $values)
        {
            foreach ($values as $value)
            {
                if ($this->isEquals($value))
                {
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Return TRUE if loaded string and $string is equals match case
         *
         * @return bool Compare result
         */
        public function isEquals($string)
        {
            return ($this->get() === static::load($string)
                                           ->get());
        }
        
        /**
         * Return true if loaded string equals ignore case some of value in values array, false otherwise
         *
         * @param array $values
         *
         * @return bool
         */
        public function isEqualsSomeIgnoreCase(array $values)
        {
            foreach ($values as $value)
            {
                if ($this->isEqualsIgnoreCase($value))
                {
                    return true;
                }
            }
            
            return false;
        }
        
        /**
         * Return TRUE if loaded string and $string is equals ignore case
         *
         * @return bool Compare result
         */
        public function isEqualsIgnoreCase()
        {
            return ($this->getClone()
                         ->toLowerCase()
                         ->get() === static::load(func_get_args(), $this->getEncoding())
                                           ->toLowerCase()
                                           ->get());
        }
    }
}
