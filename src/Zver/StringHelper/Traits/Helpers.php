<?php
namespace Zver\StringHelper\Traits
{
    
    trait Helpers
    {
        
        protected $string = '';
        
        /**
         * Get information string about current items displayed at current page, like: 1-10 from 200.
         * Useful for pagination modules/plugins.
         *
         * @param        $total_items
         * @param        $items_per_page
         * @param        $offset
         * @param string $commaSign
         * @param string $periodSign
         * @param string $from
         *
         * @return string
         */
        public static function getScrollPaginationInfo(
            $total_items, $items_per_page, $offset, $commaSign = ', ', $periodSign = ' - ', $from = ' / '
        ) {
            $info = '';
            
            $commaCheck = function ($a, $b) use ($commaSign, $periodSign)
            {
                if ($a == $b)
                {
                    return $a;
                }
                if (abs($a - $b) == 1)
                {
                    return min($a, $b) . $commaSign . max($a, $b);
                }
                
                return min($a, $b) . $periodSign . max($a, $b);
            };
            
            if ($items_per_page == 1)
            {
                $info .= $offset + 1;
            }
            else
            {
                //first page
                if ($offset == 0)
                {
                    $info .= $commaCheck(1, $items_per_page);
                }
                //last page
                elseif ($offset + $items_per_page >= $total_items)
                {
                    if ($offset + $items_per_page == $total_items)
                    {
                        $info = $commaCheck($total_items - $items_per_page + 1, $total_items);
                    }
                    else
                    {
                        $info = $commaCheck($total_items - ($total_items - $offset) + 1, $total_items);
                    }
                }
                //other
                else
                {
                    $info = $commaCheck($offset + 1, $offset + $items_per_page);
                }
            }
            $info .= $from . $total_items;
            
            return $info;
        }
        
        /**
         * Get count of substring in loaded string
         *
         * @param string|array|static $string Substring to count count
         *
         * @return integer Count of substring in loaded string
         */
        public function getSubstringCount($string)
        {
            return mb_substr_count($this->string, static::load($string), $this->getEncoding());
        }
        
        /**
         * Reverse loaded string
         *
         * @return self Current instance
         */
        public function reverse()
        {
            return $this->set(array_reverse($this->getCharactersArray()));
        }
        
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
         * Return TRUE if loaded string is serialized string
         *
         * @return bool
         */
        public function isSerialized()
        {
            $isSerialized = false;
            
            try
            {
                $isSerialized = unserialize($this->get());
                
                //Cannot deserialize
                if ($isSerialized === false)
                {
                    return false;
                }
                
                return true;
            }
            catch (\Exception $e)
            {
                $isSerialized = false;
            }
            
            return $isSerialized;
            
        }
        
        /**
         * Returns TRUE if loaded string is starts with $start string ignore case, FALSE otherwise
         *
         * @param string $start String to search
         *
         * @return boolean Compare result
         */
        public function isStartsWithIgnoreCase($start)
        {
            
            $starts = static::load($start);
            
            if ($starts->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $starts->length())
            {
                
                $substring = $this->getClone()
                                  ->getFirstChars($starts->length());
                
                return $starts->isEqualsIgnoreCase($substring);
            }
            
            return false;
        }
        
        /**
         * Returns TRUE if loaded string is ends with $end string ignore case, FALSE otherwise
         *
         * @param string $end String to compare with loaded string end
         *
         * @return boolean Compare result
         */
        public function isEndsWithIgnoreCase($end)
        {
            
            $ends = static::load($end);
            
            if ($ends->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $ends->length())
            {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());
                
                return $ends->isEqualsIgnoreCase($substr);
            }
            
            return false;
        }
        
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
         * Returns TRUE if loaded string is starts with $start string, FALSE otherwise
         *
         * @param string $start String to search
         *
         * @return boolean Compare result
         */
        public function isStartsWith($start)
        {
            
            $starts = static::load($start);
            
            if ($starts->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $starts->length())
            {
                
                $substring = $this->getClone()
                                  ->getFirstChars($starts->length());
                
                return $starts->isEquals($substring);
            }
            
            return false;
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
         * Returns TRUE if loaded string is ends with $end string, FALSE otherwise
         *
         * @param string $end String to compare with loaded string end
         *
         * @return boolean Compare result
         */
        public function isEndsWith($end)
        {
            
            $ends = static::load($end);
            
            if ($ends->length() == 0)
            {
                return true;
            }
            
            if ($this->length() >= $ends->length())
            {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());
                
                return $ends->isEquals($substr);
            }
            
            return false;
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
        
        /**
         * Fill loaded string to $length using $filler from right
         *
         * @param string  $filler
         * @param integer $length
         *
         * @return self Current instance
         */
        public function fillRight($filler, $length)
        {
            $fillLen = $length - $this->length();
            if ($fillLen > 0 && !empty($filler))
            {
                $this->string .= static::load($filler)
                                       ->repeat($fillLen)
                                       ->substring(0, $fillLen);
            }
            
            return $this;
        }
        
        /**
         * Return loaded string repeated $n times
         * If $n<=1 method don't have effect
         *
         * @param integer $n Times to repeat string
         *
         * @return self Current instance
         */
        public function repeat($times)
        {
            if ($times >= 1)
            {
                $this->string = str_repeat($this->string, $times);
            }
            
            return $this;
        }
        
        /**
         * Fill loaded string to $length using $filler from left
         *
         * @param string  $filler
         * @param integer $length
         *
         * @return self Current instance
         */
        public function fillLeft($filler, $length)
        {
            $fillLen = $length - $this->length();
            if ($fillLen > 0 && !empty($filler))
            {
                $this->string = static::load($filler)
                                      ->repeat($fillLen)
                                      ->substring(0, $fillLen)
                                      ->concat($this->string);
            }
            
            return $this;
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
         * Check string for symbolic emptiness without tags
         * Return FALSE if loaded string contains digit or/and letter, TRUE otherwise
         *
         * @return bool
         */
        public function isEmptyWithoutTags()
        {
            return $this->getClone()
                        ->removeTags()
                        ->isEmpty();
        }
        
        /**
         * Check string for symbolic emptiness
         * Return FALSE if loaded string contains digit or/and letter, TRUE otherwise
         *
         * @return bool
         */
        public function isEmpty()
        {
            return ($this->getClone()
                         ->remove('\W|_')
                         ->length() == 0);
        }
        
        /**
         * Return company footer since years like 1998-2015
         *
         * @param        $sinceYear
         * @param string $separator
         *
         * @return self
         */
        public function footerYears($sinceYear, $separator = '—')
        {
            
            $currentYear = date('Y');
            
            if ($currentYear - $sinceYear > 0)
            {
                return $this->set($sinceYear . $separator . $currentYear);
            }
            
            return $this->set($sinceYear);
            
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
    }
}
