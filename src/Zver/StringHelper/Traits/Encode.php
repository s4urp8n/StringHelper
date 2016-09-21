<?php
namespace Zver\StringHelper\Traits
{
    
    /**
     * Encode-decode methods
     *
     * @package Zver\StringHelper\Traits
     */
    trait Encode
    {
        
        protected $string = '';
        
        /**
         * Encode loaded string to URL-safe string
         *
         * @return self Current instance
         */
        public function toURL()
        {
            return $this->set(rawurlencode($this->get()));
        }
        
        /**
         * Decode loaded string from URL-safe string to native string
         *
         * @return self Current instance
         */
        public function fromURL()
        {
            return $this->set(rawurldecode($this->get()));
        }
        
        /**
         * Encode loaded string to BASE64
         *
         * @return self Current instance
         */
        public function toBase64()
        {
            return $this->set(base64_encode($this->get()));
        }
        
        /**
         * Decode loaded string from BASE64 string
         *
         * @return self Current instance
         */
        public function fromBase64()
        {
            return $this->set(base64_decode($this->get()));
        }
        
        /**
         * UUE encode loaded string
         *
         * @return self Current instance
         */
        public function toUUE()
        {
            return $this->set(convert_uuencode($this->get()));
        }
        
        /**
         * UUE decode loaded string
         *
         * @return self Current instance
         */
        public function fromUUE()
        {
            return $this->set(convert_uudecode($this->get()));
        }
        
        /**
         * Encode loaded string to UTF-8
         *
         * @return self Current instance
         */
        public function toUTF8()
        {
            return $this->set(utf8_encode($this->get()));
        }
        
        /**
         * Decode loaded string from UTF-8 string
         *
         * @return self Current instance
         */
        public function fromUTF8()
        {
            return $this->set(utf8_decode($this->get()));
        }
        
        /**
         * Encode html entities presented in loaded string
         *
         * @param integer $flags Entities flag
         * @param bool    $doubleEncode
         *
         * @return self
         * @see http://php.net/manual/ru/function.htmlentities.php
         */
        public function toHTMLEntities($flags = ENT_QUOTES)
        {
            return $this->set(htmlentities($this->get(), $flags, $this->getEncoding()));
        }
        
        /**
         * Decode encoded entities presents in loaded string
         *
         * @param integer $flags Entities flags
         *
         * @return self Current instance
         * @see http://php.net/manual/ru/function.html-entity-decode.php
         */
        public function fromHTMLEntities($flags = ENT_QUOTES)
        {
            return $this->set(html_entity_decode($this->get(), $flags, $this->getEncoding()));
        }
        
        /**
         * Decode loaded string from JSON
         *
         * @return self
         */
        public function fromJSON()
        {
            if ($this->isJSON())
            {
                return $this->set(json_decode($this->get()));
            }
            else
            {
                return $this->set("");
            }
        }
        
        /**
         * Encode loaded string as JSON
         *
         * @return self
         */
        public function toJSON()
        {
            return $this->set(json_encode($this->get()));
        }
        
        /**
         * Get UTF-8 string from punycode encoded string
         *
         * @return self Current instance
         */
        public function fromPunyCode()
        {
            return $this->set(idn_to_utf8($this->get()));
        }
        
        /**
         * Get punycode encoded string from loaded string. Encoding will set to and string converted to UTF-8
         *
         * @return self Current instance
         */
        public function toPunyCode()
        {
            return $this->toLowerCase()
                        ->set(idn_to_ascii($this->get()));
        }
    }
}
