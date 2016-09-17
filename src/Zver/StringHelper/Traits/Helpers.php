<?php
namespace Zver\StringHelper\Traits
{
    
    trait Helpers
    {
        
        protected $string = '';
        
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
    }
}
