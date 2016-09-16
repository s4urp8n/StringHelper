<?php

namespace Zver
{
    
    use Zver\Traits\Encoding;
    
    class StringHelper
    {
        
        use Encoding;
        
        /**
         * @var Loaded string
         */
        protected $string = '';
        
        /**
         * StringHelper private constructor, to implement Facade creation
         */
        protected function __construct($string = '')
        {
            $this->string = static::stringify($string);
        }
        
        /**
         * If value is array method convert it to string recursive concatenate it's values and load,
         * if it string it just loaded.
         *
         * @param array $mixed Array or string to load
         *
         * @return string Result string
         */
        protected static function stringify($mixed)
        {
            $result = '';
            
            if (!is_array($mixed))
            {
                $mixed = [$mixed];
            }
            
            foreach ($mixed as $mix)
            {
                if (is_array($mix))
                {
                    $result .= static::stringify($mix);
                }
                else
                {
                    $result .= $mix . '';
                }
            }
            
            return $result;
        }
        
        /**
         * Get class instance
         *
         * @param string|array|self $string
         * @param string            $encoding
         *
         * @return static Current instance of class
         */
        public static function load($string = '')
        {
            return new static($string);
        }
        
        /**
         * Get instance of class loaded with string converted from another encoding
         *
         * @param $string       String
         * @param $fromEncoding Encoding
         *
         * @return static
         */
        public static function loadFromEncoding($string, $fromEncoding)
        {
            return new static(static::convertFromEncoding(static::stringify($string), $fromEncoding));
        }
        
        /**
         * Get result string
         *
         * @return string
         */
        public function get()
        {
            return $this->string;
        }
        
        /**
         * Return result string when using class as string
         *
         * @return string Return result string when using class as string
         */
        public function __toString()
        {
            return $this->get();
        }
        
        public function set($string)
        {
            return static::load($string);
        }
        
        public function setFromEncoding($string, $fromEncoding)
        {
            return static::loadFromEncoding($string, $fromEncoding);
        }
    }
}
