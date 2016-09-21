<?php
namespace Zver\StringHelper\Traits
{
    
    trait Information
    {
        
        protected $string = '';
        
        /**
         * Get count of substring in loaded string
         *
         * @param string|array|static $string Substring to count count
         *
         * @return integer Count of substring in loaded string
         */
        public function getSubstringCount($string)
        {
            return mb_substr_count($this->string, static::load($string), $this->getEncoding());
        }
        
        /**
         * Return TRUE if loaded string is serialized string
         *
         * @return bool
         */
        public function isSerialized()
        {
            $isSerialized = false;
            
            try
            {
                $isSerialized = unserialize($this->get());
                
                //Cannot deserialize
                if ($isSerialized === false)
                {
                    return false;
                }
                
                return true;
            }
            catch (\Exception $e)
            {
                $isSerialized = false;
            }
            
            return $isSerialized;
            
        }
        
        /**
         * Check string for symbolic emptiness
         * Return FALSE if loaded string contains digit or/and letter, TRUE otherwise
         *
         * @return bool
         */
        public function isEmpty()
        {
            return ($this->getClone()
                         ->remove('\W|_')
                         ->length() == 0);
        }
        
        /**
         * Check string for symbolic emptiness without tags
         * Return FALSE if loaded string contains digit or/and letter, TRUE otherwise
         *
         * @return bool
         */
        public function isEmptyWithoutTags()
        {
            return $this->getClone()
                        ->removeTags()
                        ->isEmpty();
        }
        
        /**
         * Return TRUE if loaded string is valid JSON
         *
         * @return bool
         */
        public function isJSON()
        {
            if ($this->length() == 0)
            {
                return false;
            }
            
            json_decode($this->get());
            
            return json_last_error() === JSON_ERROR_NONE;
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
         * Get Levenshtein distance between arguments and loaded string
         *
         * @param string|self|array Other stringable
         *
         * @return integer Levenshtein distance
         */
        public function getLevenshteinDistance($stringable)
        {
            
            $string = static::load($stringable)
                            ->get();
            
            $currentLenght = $this->length();
            $stringLength = static::load($stringable)
                                  ->length();
            
            //special cases
            if ($currentLenght == 0)
            {
                return $stringLength;
            }
            if ($stringLength == 0)
            {
                return $currentLenght;
            }
            if ($this->get() === $string)
            {
                return 0;
            }
            
            $iPos = $jPos = 0;
            $result = [];
            
            for ($iPos = 0; $iPos <= $currentLenght; $iPos++)
            {
                $result[$iPos] = [$iPos];
            }
            
            for ($jPos = 0; $jPos <= $stringLength; $jPos++)
            {
                $result[0][$jPos] = $jPos;
            }
            
            for ($jPos = 1; $jPos <= $stringLength; $jPos++)
            {
                for ($iPos = 1; $iPos <= $currentLenght; $iPos++)
                {
                    if ($this->string[$iPos - 1] == $string[$jPos - 1])
                    {
                        $result[$iPos][$jPos] = $result[$iPos - 1][$jPos - 1];
                    }
                    else
                    {
                        $result[$iPos][$jPos] =
                            min($result[$iPos - 1][$jPos], $result[$iPos][$jPos - 1], $result[$iPos - 1][$jPos - 1])
                            + 1;
                    }
                }
            }
            
            return $result[$currentLenght][$stringLength] * 1;
        }
        
    }
}
