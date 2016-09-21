<?php
namespace Zver\StringHelper\Traits
{
    
    trait BeginningEnding
    {
        
        protected $string = '';
        
        /**
         * Set beginning of loaded string if it not exist
         *
         * @return self Current instance
         */
        public function setBeginning()
        {
            $beginning = static::load(func_get_args());
            if ($this->isStartsWith($beginning))
            {
                return $this;
            }
            
            return $this->prepend($beginning);
        }
        
        /**
         * Set ending of loaded string if it not exist
         *
         * @return self Current instance
         */
        public function setEnding()
        {
            $ending = static::load(func_get_args());
            if ($this->isEndsWith($ending))
            {
                return $this;
            }
            
            return $this->append($ending);
        }
        
        /**
         * Remove beginning of loaded string if it exists
         *
         * @return self Current instance
         */
        public function removeBeginning()
        {
            $beginning = static::load(func_get_args());
            if ($this->isStartsWith($beginning))
            {
                return $this->substring($beginning->length());
            }
            
            return $this;
        }
        
        /**
         * Remove ending from loaded string if it exists
         *
         * @return self Current instance
         */
        public function removeEnding()
        {
            $ending = static::load(func_get_args());
            if ($this->isEndsWith($ending))
            {
                return $this->substring(0, $this->length() - $ending->length());
            }
            
            return $this;
        }
        
    }
}
