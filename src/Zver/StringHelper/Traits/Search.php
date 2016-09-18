<?php
namespace Zver\StringHelper\Traits
{
    
    trait Search
    {
        
        protected $string = '';
        
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
        
    }
}