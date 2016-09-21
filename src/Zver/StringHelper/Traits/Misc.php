<?php
namespace Zver\StringHelper\Traits
{
    
    trait Misc
    {
        
        protected $string = '';
        
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
