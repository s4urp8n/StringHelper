<?php
namespace Zver\StringHelper\Traits
{
    
    trait StartsEnds
    {
        
        protected $string = '';
        
        /**
         * Returns TRUE if loaded string is starts with $start string ignore case, FALSE otherwise
         *
         * @param string $start String to search
         *
         * @return boolean Compare result
         */
        public function isStartsWithIgnoreCase($start)
        {
            
            $starts = static::load($start);
            
            if ($starts->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $starts->length())
            {
                
                $substring = $this->getClone()
                                  ->getFirstChars($starts->length());
                
                return $starts->isEqualsIgnoreCase($substring);
            }
            
            return false;
        }
        
        /**
         * Returns TRUE if loaded string is ends with $end string ignore case, FALSE otherwise
         *
         * @param string $end String to compare with loaded string end
         *
         * @return boolean Compare result
         */
        public function isEndsWithIgnoreCase($end)
        {
            
            $ends = static::load($end);
            
            if ($ends->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $ends->length())
            {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());
                
                return $ends->isEqualsIgnoreCase($substr);
            }
            
            return false;
        }
        
        /**
         * Returns TRUE if loaded string is starts with $start string, FALSE otherwise
         *
         * @param string $start String to search
         *
         * @return boolean Compare result
         */
        public function isStartsWith($start)
        {
            
            $starts = static::load($start);
            
            if ($starts->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $starts->length())
            {
                
                $substring = $this->getClone()
                                  ->getFirstChars($starts->length());
                
                return $starts->isEquals($substring);
            }
            
            return false;
        }
        
        /**
         * Returns TRUE if loaded string is ends with $end string, FALSE otherwise
         *
         * @param string $end String to compare with loaded string end
         *
         * @return boolean Compare result
         */
        public function isEndsWith($end)
        {
            
            $ends = static::load($end);
            
            if ($ends->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $ends->length())
            {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());
                
                return $ends->isEquals($substr);
            }
            
            return false;
        }
        
    }
}
