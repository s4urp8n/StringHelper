<?php
namespace Zver\StringHelper\Traits
{
    
    trait Substring
    {
        
        /**
         * @var Loaded string
         */
        protected $string = '';
        
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
