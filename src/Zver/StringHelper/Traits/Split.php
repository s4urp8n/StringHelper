<?php
namespace Zver\StringHelper\Traits
{
    
    trait Split
    {
        
        protected $string = '';
        
        /**
         * Return first part of string exploded by delimiter
         *
         * @param string $delimiter
         *
         * @return self Current instance
         */
        public function getFirstPart($delimiter = ' ')
        {
            return $this->getParts(0, $delimiter);
        }
        
        /**
         * Returns parts of loaded string imploded by positions
         *
         * @param mixed  $positions Position or positions of part to return
         * @param string $delimiter Delimiter to explode string
         * @param string $glue      If returns multiple parts, parts will imploded with $glue string
         *
         * @return self Current instance
         */
        public function getParts($positions = 0, $delimiter = ' ', $glue = ' ')
        {
            
            if (!is_array($positions))
            {
                $positions = [$positions];
            }
            
            $result = [];
            $parts = explode($delimiter, $this->string);
            
            foreach ($positions as $position)
            {
                if (array_key_exists($position, $parts))
                {
                    $result[] = $parts[$position];
                }
            }
            
            return $this->set(implode($glue, $result));
        }
        
        /**
         * Return last part of string exploded by delimiter
         *
         * @param string $delimiter String separator
         *
         * @return self Current instance
         */
        public function getLastPart($delimiter = ' ')
        {
            $partsCount = count(explode($delimiter, $this->string)) - 1;
            
            return $this->getParts($partsCount, $delimiter);
        }
        
        /**
         * Split string using regular expression
         *
         * @param string  $regexp
         * @param integer $limit
         *
         * @return array
         */
        public function split($regexp, $limit = -1)
        {
            return mb_split($regexp, $this->get(), $limit);
        }
        
    }
}
