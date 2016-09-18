<?php
namespace Zver\StringHelper\Traits
{
    
    trait Manipulations
    {
        
        protected $string = '';
        
        /**
         * Alias for function newlineToBreak
         *
         * @return self Current instance
         */
        public function nl2br()
        {
            return $this->newlineToBreak();
        }
        
        /**
         * Add <br/> tag before any newline character
         *
         * @return self Current instance
         */
        public function newlineToBreak()
        {
            return $this->set(nl2br($this->get()));
        }
        
        /**
         * Alias for function breakToNewline
         *
         * @return self Current instance
         */
        public function br2nl()
        {
            return $this->breakToNewline();
        }
        
        /**
         * Convert all <br/> tags to current platform end of line character
         *
         * @return self Current instance
         */
        public function breakToNewline()
        {
            return $this->replace('\<br(\s*)?\/?\>', PHP_EOL);
        }
        
        /**
         * Replace whitespaces with underscore symbol "_"
         *
         * @return self Current instance
         */
        public function underscore()
        {
            return $this->replace('[-_\s]+', '_', false);
        }
        
        /**
         * Get slug of string
         *
         * @return self Current instance
         */
        public function slugify()
        {
            return $this->toLowerCase()
                        ->transliterate()
                        ->replace('[^a-z0-9 \-]', ' ')
                        ->trimSpaces()
                        ->hyphenate();
        }
        
        /**
         * Replace whitespaces with hyphen symbol "-"
         *
         * @return self Current instance
         */
        public function hyphenate()
        {
            return $this->replace('[-\s_]+', '-', false);
        }
        
        /**
         * Trim whitespaces from string
         *
         * @return self Current instance
         */
        public function trimSpaces()
        {
            return $this->trimSpacesLeft()
                        ->trimSpacesRight()
                        ->replace('\s+', ' ');
        }
        
        /**
         * Get transliterated string.
         *
         * @return self
         */
        public function transliterate()
        {
            return $this->set(transliterator_transliterate('Any-Latin; Latin-ASCII', $this->get()))
                        ->trimSpaces();
            
        }
        
        /**
         * Trim whitespaces from the right
         *
         * @return self Current instance
         */
        public function trimSpacesRight()
        {
            return $this->remove('\s+$');
        }
        
        /**
         * Trim whitespaces from the left
         *
         * @return self Current instance
         */
        public function trimSpacesLeft()
        {
            return $this->remove('^\s+');
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
        
        /**
         * Wrap every word and letter to span.
         * Words wrapped with class "word".
         * Letters wrapped with class "char".
         * Spaces wrapped with class "space".
         *
         * @param string $classPrefix Prefix to class names
         *
         * @return \Str\Str
         */
        public function spanify($classPrefix = '')
        {
            if ($this->isEmptyWithoutTags())
            {
                return $this->set('', $this->getEncoding());
            }
            
            $spanify = static::load('', $this->getEncoding());
            
            $words = $this->getClone()
                          ->trimSpaces()
                          ->split('\s');
            
            $last = count($words) - 1;
            foreach ($words as $index => $word)
            {
                $spanify->concat('<span class="' . $classPrefix . 'word">');
                $letters = static::load($word, $this->getEncoding())
                                 ->getCharactersArray();
                foreach ($letters as $letter)
                {
                    $spanify->concat('<span class="' . $classPrefix . 'char">')
                            ->concat($letter)
                            ->concat('</span>');
                }
                $spanify->concat('</span>');
                
                if ($index != $last)
                {
                    $spanify->concat('<span class="' . $classPrefix . 'space">')
                            ->concat(' ')
                            ->concat('</span>');
                }
            }
            
            return $spanify;
        }
        
        /**
         * Remove tags from loaded string
         *
         * @param string $allowableTags Tags allowed to leave in string
         *
         * @return self Current instance
         */
        public function removeTags($allowableTags = '')
        {
            return $this->set(strip_tags($this->get(), $allowableTags));
        }
    }
}
