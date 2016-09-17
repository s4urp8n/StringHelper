<?php

namespace Zver
{
    
    class StringHelper
    {
        
        /**
         * Return array of matches by regular expression found in loaded string
         *
         * @param string $regexp Regular expression
         *
         * @return array Array of matches
         */
        public function matches($regexp)
        {
            
            $this->applyEncodings();
            
            $result = [];
            
            $currentString = $this->get();
            
            if (!empty($currentString) && !empty($regexp))
            {
                
                mb_ereg_search_init($this->get(), $regexp);
                if (mb_ereg_search())
                {
                    $matches = [mb_ereg_search_getregs()];
                    do
                    {
                        $currentMatch = mb_ereg_search_regs();
                        $matches[] = $currentMatch;
                    } while ($currentMatch);
                    
                    foreach ($matches as $value)
                    {
                        if (isset($value[0]) && $value[0] != '')
                        {
                            $result[] = $value[0];
                        }
                    }
                    
                }
            }
            
            $this->restoreEncodings();
            
            return $result;
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
         * @param string|array|self $string
         * @param integer           $offset
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
         * Get count of substring in loaded string
         *
         * @param string|array|self $string Substring to count count
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
            return $this->set(implode('', array_reverse($this->toCharactersArray())));
        }
        
        /**
         * Return TRUE if loaded string is serialized string
         *
         * @return bool
         */
        public function isSerialized()
        {
            if ($this->length() == 0)
            {
                return false;
            }
            
            $result = false;
            try
            {
                unserialize($this->get());
                $result = true;
            }
            catch (\Exception $e)
            {
                $result = false;
            }
            
            return $result;
            
        }
        
        /**
         * Return TRUE if loaded string matches regular expression
         *
         * @param string $regexp
         *
         * @return bool
         */
        public function isMatch($regexp)
        {
            if (empty($regexp))
            {
                return true;
            }
            
            $this->applyEncodings();
            
            $result = (mb_ereg($regexp, $this->get()) !== false);
            
            $this->restoreEncodings();
            
            return $result;
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
                                  ->getFirst($starts->length());
                
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
                               ->getLast($ends->length());
                
                return $ends->isEqualsIgnoreCase($substr);
            }
            
            return false;
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
                                  ->getFirst($starts->length());
                
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
                               ->getLast($ends->length());
                
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
         * Remove encoded entities from loaded string
         *
         * @return self Current instance
         */
        public function removeEntities()
        {
            return $this->remove('&\w+;');
        }
        
        /**
         * Remove substring matches regular expression
         *
         * @param $regexp
         *
         * @return self
         */
        public function remove($regexp)
        {
            return $this->replace($regexp, '');
        }
        
        /**
         * Replace substring matched regular expression with replacement
         *
         * @param string $regexp      Regular expression to match
         * @param string $replacement String replacement
         * @param string $options     String of options, where:
         *                            i - Ambiguity match on,
         *                            x - Enables extended pattern form,
         *                            m - '.' matches with newlines,
         *                            s - '^' -> '\A', '$' -> '\Z',
         *                            p - Same as both the m and s options,
         *                            l - Finds longest matches,
         *                            n - Ignores empty matches,
         *                            e - eval() resulting code,
         *                            j - Java (Sun java.util.regex),
         *                            u - GNU regex,
         *                            g - grep,
         *                            c - Emacs,
         *                            r - Ruby,
         *                            z - Perl,
         *                            b - POSIX Basic regex,
         *                            d - POSIX Extended regex.
         *
         * @return self Current instance
         */
        public function replace($regexp, $replacement, $options = 'mr')
        {
            return $this->applyEncodings()
                        ->set(mb_ereg_replace($regexp, $replacement, $this->get(), $options))
                        ->restoreEncodings();
        }
        
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
            $enc = $this->getEncoding();
            
            return $this->applyEncodings()
                        ->set(transliterator_transliterate('Any-Latin; Latin-ASCII', $this->get()))
                        ->convertEncoding('ASCII')
                        ->convertEncoding($enc)
                        ->trimSpaces()
                        ->restoreEncodings();
            
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
         * Convert string to another encoding
         *
         * @param string $encoding
         *
         * @return self Current instance
         * @throws \Exception
         */
        public function convertEncoding($encoding)
        {
            $this->set(mb_convert_encoding($this->get(), $encoding, $this->getEncoding()));
            $this->encoding = $encoding;
            
            return $this;
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
         * Shuffle characters in loaded string
         *
         * @return self Current instance
         */
        public function shuffleCharacters()
        {
            $array = $this->toCharactersArray();
            shuffle($array);
            $this->string = implode('', $array);
            
            return $this;
        }
        
        /**
         * Get  array of lines of loaded string
         *
         * @return array
         */
        public function toLinesArray()
        {
            return $this->split("\r\n|\n");
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
            
            $this->applyEncodings();
            
            $splited = mb_split($regexp, $this->get(), $limit);
            
            $this->restoreEncodings();
            
            return $splited;
        }
        
        /**
         * Generate soundex code.
         * If loaded string contains not-latin characters it will be transliterated
         *
         * @return string
         */
        public function soundex()
        {
            $soundex = '';
            $words = $this->trimSpaces()
                          ->transliterate()
                          ->split(' ');
            foreach ($words as $word)
            {
                $soundex .= soundex($word);
            }
            
            return $this->set($soundex);
        }
        
        /**
         * Generate metaphone code.
         * If loaded string contains not-latin characters it will be transliterated
         *
         * @return self Current instance
         */
        public function metaphone()
        {
            $metaphone = '';
            $words = $this->trimSpaces()
                          ->transliterate()
                          ->split(' ');
            foreach ($words as $word)
            {
                $metaphone .= metaphone($word);
            }
            
            return $this->set($metaphone);
        }
        
        /**
         * Get Levenshtein distance between arguments and loaded string
         *
         * @param string|self|array,... Arguments to calc difference
         *
         * @return self Current instance
         */
        public function levenshtein()
        {
            
            $string = static::load(func_get_args())
                            ->get();
            
            $currentLenght = mb_strlen($this->get(), $this->getEncoding());
            $stringLength = mb_strlen($string, $this->getEncoding());
            
            //special cases
            if ($currentLenght == 0)
            {
                return $this->set($stringLength);
            }
            if ($stringLength == 0)
            {
                return $this->set($currentLenght);
            }
            if ($this->get() === $string)
            {
                return $this->set(0);
            }
            
            $iPos = $jPos = 0;
            $result = [];
            
            for ($iPos = 0; $iPos <= $currentLenght; $iPos++)
            {
                $result[$iPos] = [$iPos];
            }
            
            for ($jPos = 0; $jPos <= $stringLength; $jPos++)
            {
                $result[0][$jPos] = $jPos;
            }
            
            for ($jPos = 1; $jPos <= $stringLength; $jPos++)
            {
                for ($iPos = 1; $iPos <= $currentLenght; $iPos++)
                {
                    if ($this->string[$iPos - 1] == $string[$jPos - 1])
                    {
                        $result[$iPos][$jPos] = $result[$iPos - 1][$jPos - 1];
                    }
                    else
                    {
                        $result[$iPos][$jPos] =
                            min($result[$iPos - 1][$jPos], $result[$iPos][$jPos - 1], $result[$iPos - 1][$jPos - 1])
                            + 1;
                    }
                }
            }
            
            return $this->set($result[$currentLenght][$stringLength]);
        }
        
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
         * Return TRUE if loaded string is valid JSON
         *
         * @return bool
         */
        public function isJSON()
        {
            if ($this->length() == 0)
            {
                return false;
            }
            
            json_decode($this->get());
            
            return (json_last_error() === JSON_ERROR_NONE);
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
            return $this->set(idn_to_utf8($this->get()))
                        ->convertEncoding('UTF-8');
        }
        
        /**
         * Get punycode encoded string from loaded string. Encoding will set to and string converted to UTF-8
         *
         * @return self Current instance
         */
        public function toPunyCode()
        {
            return $this->convertEncoding('UTF-8')
                        ->toLowerCase()
                        ->set(idn_to_ascii($this->get()));
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
                        ->getFirst($maxChars - $end->length() + 1)
                        ->getLast(1) == ' '
                )
                {
                    $preview->set(
                        $str->getFirst($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                }
                else
                {
                    $preview->set(
                        $str->getFirst($maxChars - $end->length())
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
                        ->getLast($maxChars - $end->length() + 1)
                        ->getFirst(1) == ' '
                )
                {
                    $preview->set(
                        $str->getLast($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                }
                else
                {
                    $preview->set(
                        $str->getLast($maxChars - $end->length())
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
                                 ->toCharactersArray();
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
        
    }
    
}
