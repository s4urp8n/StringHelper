<?php
namespace Zver\StringHelper\Traits
{
    
    trait Helpers
    {
        
        protected $string = '';
        
        /**
         * Shuffle characters in loaded string
         *
         * @return self Current instance
         */
        public function shuffleCharacters()
        {
            $array = $this->getCharactersArray();
            shuffle($array);
            $this->string = implode('', $array);
            
            return $this;
        }
        
        /**
         * Get text preview of loaded string without tags and redundant spaces.
         * Only whole words will presented in preview.
         *
         * $text = '<a>
         *              <p>
         *                  some preview   text
         *              </p>
         *          </a>';
         *
         * ...->getPreview(-1000) = "..."
         * ...->getPreview(2) = "..."
         * ...->getPreview(3) = "..."
         * ...->getPreview(7) = "some..."
         * ...->getPreview(8) = "some..."
         * ...->getPreview(13) = "some..."
         * ...->getPreview(14) = "some..."
         * ...->getPreview(15) = "some preview..."
         * ...->getPreview(16) = "some preview..."
         * ...->getPreview(17) = "some preview text"
         * ...->getPreview(18) = "some preview text"
         * ...->getPreview(2000) = "some preview text"
         *
         * @param int     $maxChars
         * @param string  $missEnd
         * @param boolean $fromBeginning Leave text from beginning or not
         *
         * @return string
         */
        public function getPreview($maxChars = 100, $missEnd = '...', $fromBeginning = true)
        {
            if ($maxChars < 0)
            {
                $maxChars = 0;
            }
            
            $str = $this->getClone()
                        ->removeTags()
                        ->trimSpaces();
            
            $end = static::load($missEnd, static::getDefaultEncoding());
            
            if ($str->length() <= $maxChars)
            {
                return $str->get();
            }
            
            if ($end->length() >= $maxChars)
            {
                return $end->get();
            }
            
            $preview = static::load();
            
            if ($fromBeginning)
            {
                
                if ($str->getClone()
                        ->getFirstChars($maxChars - $end->length() + 1)
                        ->getLastChars(1) == ' '
                )
                {
                    $preview->set(
                        $str->getFirstChars($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                }
                else
                {
                    $preview->set(
                        $str->getFirstChars($maxChars - $end->length())
                            ->remove('[^\s]+$')
                            ->trimSpaces()
                            ->get()
                    );
                }
                $preview->remove('[\W_]+$')
                        ->concat($end);
            }
            else
            {
                if ($str->getClone()
                        ->getLastChars($maxChars - $end->length() + 1)
                        ->getFirstChars(1) == ' '
                )
                {
                    $preview->set(
                        $str->getLastChars($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                }
                else
                {
                    $preview->set(
                        $str->getLastChars($maxChars - $end->length())
                            ->remove('^[^\s]+')
                            ->trimSpaces()
                            ->get()
                    );
                }
                $preview->remove('^[\W_]+')
                        ->prepend($end);
            }
            
            return $preview->get();
            
        }
        
        /**
         * Get slug of string
         *
         * @return self Current instance
         */
        public function slugify()
        {
            return $this->set(transliterator_transliterate('Any-Latin; Latin-ASCII', $this->get()))
                        ->toLowerCase()
                        ->replace('[^a-z0-9 \-]', ' ')
                        ->trimSpaces()
                        ->replace('[-\s_]+', '-', false);
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
        
    }
}
