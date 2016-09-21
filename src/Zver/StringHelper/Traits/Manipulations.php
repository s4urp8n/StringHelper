<?php
namespace Zver\StringHelper\Traits
{
    
    trait Manipulations
    {
        
        protected $string = '';
        
        /**
         * Reverse loaded string
         *
         * @return self Current instance
         */
        public function reverse()
        {
            return $this->set(array_reverse($this->getCharactersArray()));
        }
        
        /**
         * Return loaded string repeated $n times
         * If $n<=1 method don't have effect
         *
         * @param integer $n Times to repeat string
         *
         * @return self Current instance
         */
        public function repeat($times)
        {
            if ($times >= 1)
            {
                $this->string = str_repeat($this->string, $times);
            }
            
            return $this;
        }
        
        /**
         * Trim whitespaces from string
         *
         * @return self Current instance
         */
        public function trimSpaces()
        {
            return $this->trimSpacesLeft()
                        ->trimSpacesRight()
                        ->replace('\s+', ' ');
        }
        
        /**
         * Trim whitespaces from the right
         *
         * @return self Current instance
         */
        public function trimSpacesRight()
        {
            return $this->remove('\s+$');
        }
        
        /**
         * Trim whitespaces from the left
         *
         * @return self Current instance
         */
        public function trimSpacesLeft()
        {
            return $this->remove('^\s+');
        }
        
        /**
         * Remove tags from loaded string
         *
         * @param string $allowableTags Tags allowed to leave in string
         *
         * @return self Current instance
         */
        public function removeTags($allowableTags = '')
        {
            return $this->set(strip_tags($this->get(), $allowableTags));
        }
        
        /**
         * Fill loaded string to $length using $filler from right
         *
         * @param string  $filler
         * @param integer $length
         *
         * @return self Current instance
         */
        public function fillRight($filler, $length)
        {
            $fillLen = $length - $this->length();
            if ($fillLen > 0 && !empty($filler))
            {
                $this->string .= static::load($filler)
                                       ->repeat($fillLen)
                                       ->substring(0, $fillLen);
            }
            
            return $this;
        }
        
        /**
         * Fill loaded string to $length using $filler from left
         *
         * @param string  $filler
         * @param integer $length
         *
         * @return self Current instance
         */
        public function fillLeft($filler, $length)
        {
            $fillLen = $length - $this->length();
            if ($fillLen > 0 && !empty($filler))
            {
                $this->string = static::load($filler)
                                      ->repeat($fillLen)
                                      ->substring(0, $fillLen)
                                      ->concat($this->string);
            }
            
            return $this;
        }
    }
}
