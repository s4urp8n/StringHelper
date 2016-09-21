<?php
namespace Zver\StringHelper\Traits
{
    
    trait Search
    {
        
        protected $string = '';
        
        /**
         * Return position of first occurrence $string in loaded string. If $string not found return FALSE
         *
         * @param string|array|self $string
         * @param integer           $offset
         *
         * @return integer|false
         */
        public function getPositionFromEnd($string, $offset = 0)
        {
            return mb_strrpos(
                $this->get(), static::load($string)
                                    ->get(), $offset, $this->getEncoding()
            );
        }
        
        /**
         * Return position of first occurrence $string in loaded string. If $string not found return FALSE
         *
         * @param string|array|self $string
         * @param integer           $offset
         *
         * @return integer|false
         */
        public function getPositionFromEndIgnoreCase($string, $offset = 0)
        {
            return mb_strripos(
                $this->get(), static::load($string)
                                    ->get(), $offset, $this->getEncoding()
            );
        }
        
        /**
         * Return TRUE if arguments contains in loaded string
         *
         * @return bool
         */
        public function contains()
        {
            $contain = static::load(func_get_args())
                             ->get();
            
            return ($this->getPosition($contain) !== false);
        }
        
        /**
         * Return position of first occurrence $string in loaded string. If $string not found return FALSE
         *
         * @param string|array|static $string
         * @param integer             $offset
         *
         * @return integer|false
         */
        public function getPosition($string, $offset = 0)
        {
            return mb_strpos(
                $this->get(), static::load($string)
                                    ->get(), $offset, $this->getEncoding()
            );
        }
        
        /**
         * Return TRUE if arguments contains in loaded string. Ignore case
         *
         * @return bool
         */
        public function containsIgnoreCase()
        {
            $contain = static::load(func_get_args())
                             ->get();
            
            return ($this->getPositionIgnoreCase($contain) !== false);
        }
        
        /**
         * Return position of first occurrence $string in loaded string. If $string not found return FALSE
         *
         * @param string|array|self $string
         * @param integer           $offset
         *
         * @return integer|false
         */
        public function getPositionIgnoreCase($string, $offset = 0)
        {
            return mb_stripos(
                $this->get(), static::load($string)
                                    ->get(), $offset, $this->getEncoding()
            );
        }
        
    }
}