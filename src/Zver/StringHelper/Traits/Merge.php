<?php
namespace Zver\StringHelper\Traits
{
    
    trait Merge
    {
        
        /**
         * @var Loaded string
         */
        protected $string = '';
        
        /**
         * Alias for concat()
         *
         * @see   concat()
         *
         * @param string|static|array Parameter of parameters to append to loaded string
         *
         * @return self Current instance
         */
        public function append($string)
        {
            return $this->concat($string);
        }
        
        /**
         * Concatenate arguments with loaded string
         * Arguments placed to end of string
         *
         * @param string|static|array Parameter of parameters to concat to loaded string
         *
         * @return self Current instance
         */
        public function concat($string)
        {
            return $this->set($this->get() . static::load($string));
        }
        
        /**
         * Place merged arguments before loaded string
         *
         * @param string|static|array Parameter of parameters to prepend to loaded string
         *
         * @return self Current instance
         */
        public function prepend($string)
        {
            return $this->set(static::load($string) . $this->get());
        }
        
    }
}
