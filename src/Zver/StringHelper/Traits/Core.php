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
         * Set new value for loaded string
         *
         * @param $string New value
         *
         * @return static
         */
        public function set($string)
        {
            return static::load($string);
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
        
        /**
         * Get length of loaded string
         *
         * @return integer Length of loaded string
         */
        public function length()
        {
            return mb_strlen($this->get(), $this->getEncoding());
        }
        
        /**
         * Alias for length()
         *
         * @see length()
         *
         */
        public function len()
        {
            return $this->length();
        }
        
        /**
         * Return first $length characters from loaded string
         *
         * @param integer $length Length of characters returned from beginning of loaded string
         *
         * @return self Current instance
         */
        public function getFirstChars($length)
        {
            if ($length == 0)
            {
                return $this->set('');
            }
            if ($length < 0)
            {
                return $this->getLastChars(-$length);
            }
            
            return $this->substring(0, $length);
        }
        
        /**
         * Return last $length characters from loaded string.
         * If $length equals 0 empty string returned.
         * Elsewhere $length is below 0 returns $length characters from beginnings
         *
         * @param integer $length Length of characters returned from end of loaded string
         *
         * @return self Current instance
         */
        public function getLastChars($length)
        {
            if ($length == 0)
            {
                return $this->set('');
            }
            if ($length < 0)
            {
                return $this->getFirstChars(-$length);
            }
            
            return $this->substring(-$length);
        }
        
        /**
         * Get part of string
         *
         * @param integer $start  Start position of substring
         * @param integer $length Length of substring from start position
         *
         * @return self Current instance
         */
        public function substring($start = 0, $length = null)
        {
            return $this->set(mb_substr($this->get(), $start, $length, $this->getEncoding()));
        }
    }
}
