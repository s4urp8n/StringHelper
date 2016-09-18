<?php
namespace Zver\StringHelper\Traits
{
    
    trait Calculations
    {
        
        protected $string = '';
        
        /**
         * Generate soundex code.
         * If loaded string contains not-latin characters it will be transliterated
         *
         * @return string
         */
        public function soundex()
        {
            $soundex = '';
            $words = $this->trimSpaces()
                          ->transliterate()
                          ->split(' ');
            foreach ($words as $word)
            {
                $soundex .= soundex($word);
            }
            
            return $this->set($soundex);
        }
        
        /**
         * Generate metaphone code.
         * If loaded string contains not-latin characters it will be transliterated
         *
         * @return self Current instance
         */
        public function metaphone()
        {
            $metaphone = '';
            $words = $this->trimSpaces()
                          ->transliterate()
                          ->split(' ');
            foreach ($words as $word)
            {
                $metaphone .= metaphone($word);
            }
            
            return $this->set($metaphone);
        }
        
        /**
         * Get Levenshtein distance between arguments and loaded string
         *
         * @param string|self|array,... Arguments to calc difference
         *
         * @return self Current instance
         */
        public function levenshtein()
        {
            
            $string = static::load(func_get_args())
                            ->get();
            
            $currentLenght = mb_strlen($this->get(), $this->getEncoding());
            $stringLength = mb_strlen($string, $this->getEncoding());
            
            //special cases
            if ($currentLenght == 0)
            {
                return $this->set($stringLength);
            }
            if ($stringLength == 0)
            {
                return $this->set($currentLenght);
            }
            if ($this->get() === $string)
            {
                return $this->set(0);
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
            
            return $this->set($result[$currentLenght][$stringLength]);
        }
    }
}
