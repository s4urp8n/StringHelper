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
        
        /**
         * Get new instance of self equals current instance
         *
         * @return self Return new instance with loaded string equals current instance
         */
        public function getClone()
        {
            return static::load($this->get());
        }
        
        /**
         * Return true if loaded string in upper case, false otherwise
         *
         * @return bool
         */
        public function isUpperCase()
        {
            return ($this->getClone()
                         ->toUpperCase()
                         ->isEquals($this->get()));
        }
        
        /**
         * Return true if loaded string in lower case, false otherwise
         *
         * @return bool
         */
        public function isLowerCase()
        {
            return ($this->getClone()
                         ->toLowerCase()
                         ->isEquals($this->get()));
        }
        
        /**
         * Return true if loaded string in title case, false otherwise
         *
         * @return bool
         */
        public function isTitleCase()
        {
            return ($this->getClone()
                         ->toTitleCase()
                         ->isEquals($this->get()));
        }
        
        /**
         * Convert case of loaded string to title case (every word start with uppercase first letter)
         *
         * @return self Current instance
         */
        public function toTitleCase()
        {
            return $this->set(mb_convert_case($this->get(), MB_CASE_TITLE, $this->getEncoding()));
        }
        
        /**
         * Randomize case of loaded string
         *
         * @return self Current instance
         */
        public function toRandomCase()
        {
            $characters = $this->toCharactersArray();
            $temp = static::load();
            foreach ($characters as $index => $character)
            {
                $temp->set($character);
                if (rand(0, 9) >= 5)
                {
                    $temp->toUpperCase();
                }
                else
                {
                    $temp->toLowerCase();
                }
                $characters[$index] = $temp->get();
            }
            
            return $this->set(implode('', $characters));
        }
        
        /**
         * Convert case of loaded string to uppercase
         *
         * @return self Current instance
         */
        public function toUpperCase()
        {
            return $this->set(mb_strtoupper($this->get(), $this->getEncoding()));
        }
        
        /**
         * Set first character to uppercase, others to lowercase
         *
         * @return self Current instance
         */
        public function toUpperCaseFirst()
        {
            return $this->set(
                $this->getClone()
                     ->substring(0, 1)
                     ->toUpperCase()
                     ->concat(
                         $this->substring(1)
                              ->toLowerCase()
                     )
            );
        }
        
        /**
         * Convert case of loaded string to lowercase
         *
         * @return self Current instance
         */
        public function toLowerCase()
        {
            return $this->set(mb_strtolower($this->get(), $this->getEncoding()));
        }
        
        /**
         * Return TRUE if loaded string and $string is equals match case
         *
         * @return bool Compare result
         */
        public function isEquals($string)
        {
            return ($this->get() == static::load($string)
                                          ->get());
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
                         ->get() == static::load(func_get_args(), $this->getEncoding())
                                          ->toLowerCase()
                                          ->get());
        }
        
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
        
        /**
         * Alias for concat()
         *
         * @param string|self|array,... Parameter of parameters to append to loaded string
         *
         * @return self Current instance
         */
        public function append()
        {
            return $this->concat(func_get_args());
        }
        
        /**
         * Concatenate arguments with loaded string
         * Arguments placed to end of string
         *
         * @param string|self|array,... Parameter of parameters to concat to loaded string
         *
         * @return self Current instance
         */
        public function concat()
        {
            return $this->set($this->get() . static::load(func_get_args(), $this->getEncoding()));
        }
        
        /**
         * Place merged arguments before loaded string
         *
         * @param string|self|array,... Parameter of parameters to prepend to loaded string
         *
         * @return self Current instance
         */
        public function prepend()
        {
            return $this->set(static::load(func_get_args(), $this->getEncoding()) . $this->get());
        }
        
        /**
         * Get array of characters of loaded string
         *
         * @return array
         */
        public function toCharactersArray()
        {
            $characters = [];
            $length = $this->length();
            for ($i = 0; $i < $length; $i++)
            {
                $characters[] = $this->getClone()
                                     ->substring($i, 1)
                                     ->get();
            }
            
            return $characters;
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
         * Return first $length characters from loaded string
         *
         * @param integer $length Length of characters returned from beginning of loaded string
         *
         * @return self Current instance
         */
        public function getFirst($length)
        {
            if ($length == 0)
            {
                return $this->set('');
            }
            if ($length < 0)
            {
                return $this->getLast(-$length);
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
        public function getLast($length)
        {
            if ($length == 0)
            {
                return $this->set('');
            }
            if ($length < 0)
            {
                return $this->getFirst(-$length);
            }
            
            return $this->substring(-$length);
        }
        
    }
}
