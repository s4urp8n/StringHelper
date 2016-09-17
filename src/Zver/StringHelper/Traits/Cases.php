<?php
namespace Zver\StringHelper\Traits
{
    
    trait Cases
    {
        
        protected $string = '';
        
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
        
    }
}
