<?php
namespace Zver\StringHelper\Traits
{
    
    trait Convert
    {
        
        protected $string = '';
        
        /**
         * Get array of characters of loaded string
         *
         * @return array
         */
        public function getCharactersArray()
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
         * Get  array of lines of loaded string
         *
         * @return array
         */
        public function getLinesArray()
        {
            return $this->split("\r\n|\n");
        }
        
    }
}
