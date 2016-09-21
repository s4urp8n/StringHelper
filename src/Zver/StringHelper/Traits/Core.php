<?php
namespace Zver\StringHelper\Traits
{
    
    trait Core
    {
        
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
         * Return result string when using class as string
         *
         * @return string Return result string when using class as string
         */
        public function __toString()
        {
            return $this->get();
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
        
        public function setFromEncoding($string, $fromEncoding)
        {
            return static::loadFromEncoding($string, $fromEncoding);
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
         * Get new instance of self equals current instance
         *
         * @return static Return new instance with loaded string equals current instance
         */
        public function getClone()
        {
            return static::load($this->get());
        }
        
        /**
         * Get class instance
         *
         * @param string|array|static $string
         * @param string              $encoding
         *
         * @return static Current instance of class
         */
        public static function load($string = '')
        {
            return new static($string);
        }
        
        /**
         * Set new value for loaded string
         *
         * @param $string New value
         *
         * @return static
         */
        public function set($string)
        {
            $this->string = static::stringify($string);
            
            return $this;
        }
        
        /**
         * Get length of loaded string
         *
         * @return integer Length of loaded string
         */
        public function length()
        {
            return mb_strlen($this->get(), $this->getEncoding());
        }
        
    }
}
