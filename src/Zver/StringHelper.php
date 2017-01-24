<?php

namespace Zver {

    class StringHelper
    {

        protected $string = '';

        /**
         * Set beginning of loaded string if it not exist
         *
         * @return self Current instance
         */
        public function ensureBeginningIs($stringable)
        {
            $beginning = static::load($stringable)
                               ->get();

            if ($this->isStartsWith($beginning)) {
                return $this;
            }

            return $this->prepend($beginning);
        }

        /**
         * Set ending of loaded string if it not exist
         *
         * @return self Current instance
         */
        public function ensureEndingIs($stringable)
        {
            $ending = static::load($stringable)
                            ->get();

            if ($this->isEndsWith($ending)) {
                return $this;
            }

            return $this->append($ending);
        }

        /**
         * Remove beginning of loaded string if it exists
         *
         * @return self Current instance
         */
        public function removeBeginning($stringable)
        {
            $beginning = static::load($stringable);

            if ($this->isStartsWith($beginning->get())) {
                return $this->substring($beginning->length());
            }

            return $this;
        }

        /**
         * Remove ending from loaded string if it exists
         *
         * @return self Current instance
         */
        public function removeEnding($stringable)
        {
            $ending = static::load($stringable);

            if ($this->isEndsWith($ending)) {
                return $this->substring(0, $this->length() - $ending->length());
            }

            return $this;
        }

        /**
         * Return true if loaded string in upper case, false otherwise. If string is empty - return true.
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
         * Return true if loaded string in lower case, false otherwise. If string is empty - return true.
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
         * Return true if loaded string in title case, false otherwise. If string is empty - return true.
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
            return $this->set(mb_convert_case($this->get(), MB_CASE_TITLE, Common::getDefaultEncoding()));
        }

        /**
         * Randomize case of loaded string
         *
         * @return self Current instance
         */
        public function toRandomCase()
        {
            $characters = $this->getCharactersArray();
            $temp = static::load();
            foreach ($characters as $index => $character) {
                $temp->set($character);
                if (rand(0, 9) >= 5) {
                    $temp->toUpperCase();
                } else {
                    $temp->toLowerCase();
                }
                $characters[$index] = $temp->get();
            }

            return $this->set($characters);
        }

        /**
         * Convert case of loaded string to uppercase
         *
         * @return self Current instance
         */
        public function toUpperCase()
        {
            return $this->set(mb_strtoupper($this->get(), Common::getDefaultEncoding()));
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
            return $this->set(mb_strtolower($this->get(), Common::getDefaultEncoding()));
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
            for ($i = 0; $i < $length; $i++) {
                $characters[] = $this->getClone()
                                     ->substring($i, 1)
                                     ->get();
            }

            return $characters;
        }

        /**
         * Get  array of lines of loaded string
         *
         * @return array
         */
        public function getLinesArray()
        {
            return $this->split("\r\n|\n|\r");
        }

        /**
         * StringHelper private constructor, to implement Facade creation
         */
        protected function __construct($stringable = '')
        {
            $this->string = static::stringify($stringable);
        }

        /**
         * If value is array method convert it to string recursive concatenate it's values and load,
         * if it string it just loaded.
         *
         * @param array $stringable Array or string to load
         *
         * @return string Result string
         */
        protected static function stringify($stringable)
        {
            $result = '';

            if (!is_array($stringable)) {
                $stringable = [$stringable];
            }

            foreach ($stringable as $mix) {
                if (is_array($mix)) {
                    $result .= static::stringify($mix);
                } else {
                    $result .= $mix . '';
                }
            }

            return $result;
        }

        /**
         * Return result string when using class as string
         *
         * @return string Return result string when using class as string
         */
        public function __toString()
        {
            return $this->get();
        }

        /**
         * Get result string
         *
         * @return string
         */
        public function get()
        {
            return $this->string;
        }

        /**
         * Get new instance of self equals current instance
         *
         * @return static Return new instance with loaded string equals current instance
         */
        public function getClone()
        {
            return static::load($this->get());
        }

        /**
         * Get class instance
         *
         * @param string|array|static $stringable
         * @param string              $encoding
         *
         * @return static Current instance of class
         */
        public static function load($stringable = '')
        {
            return new static($stringable);
        }

        /**
         * Set new value for loaded string
         *
         * @param $string New value
         *
         * @return static
         */
        public function set($string)
        {
            $this->string = static::stringify($string);

            return $this;
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
            return $this->set(htmlentities($this->get(), $flags, Common::getDefaultEncoding()));
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
            return $this->set(html_entity_decode($this->get(), $flags, Common::getDefaultEncoding()));
        }

        /**
         * Decode loaded string from JSON
         *
         * @return self
         */
        public function fromJSON()
        {
            if ($this->isJSON()) {
                return $this->set(json_decode($this->get()));
            } else {
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
                        ->set(\idn_to_ascii($this->get()));
        }

        /**
         * Return true if loaded string equals some of value in values array match case, false otherwise
         *
         * @param array $values
         *
         * @return bool
         */
        public function isEqualsSome(array $values)
        {
            foreach ($values as $value) {
                if ($this->isEquals($value)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Return TRUE if loaded string and $string is equals match case
         *
         * @return bool Compare result
         */
        public function isEquals($string)
        {
            return ($this->get() === static::load($string)
                                           ->get());
        }

        /**
         * Return true if loaded string equals some of value in values array ignore case, false otherwise
         *
         * @param array $values
         *
         * @return bool
         */
        public function isEqualsSomeIgnoreCase(array $values)
        {
            foreach ($values as $value) {
                if ($this->isEqualsIgnoreCase($value)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Return TRUE if loaded string and $string is equals ignore case
         *
         * @return bool Compare result
         */
        public function isEqualsIgnoreCase($string)
        {
            return ($this->getClone()
                         ->toLowerCase()
                         ->get() === static::load($string)
                                           ->toLowerCase()
                                           ->get());
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
            if ($maxChars < 0) {
                $maxChars = 0;
            }

            $str = $this->getClone()
                        ->removeTags()
                        ->trimSpaces();

            $end = static::load($missEnd, Common::getDefaultEncoding());

            if ($str->length() <= $maxChars) {
                return $str->get();
            }

            if ($end->length() >= $maxChars) {
                return $end->get();
            }

            $preview = static::load();

            if ($fromBeginning) {

                if ($str->getClone()
                        ->getFirstChars($maxChars - $end->length() + 1)
                        ->getLastChars(1) == ' '
                ) {
                    $preview->set(
                        $str->getFirstChars($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                } else {
                    $preview->set(
                        $str->getFirstChars($maxChars - $end->length())
                            ->remove('[^\s]+$')
                            ->trimSpaces()
                            ->get()
                    );
                }
                $preview->remove('[\W_]+$')
                        ->concat($end);
            } else {
                if ($str->getClone()
                        ->getLastChars($maxChars - $end->length() + 1)
                        ->getFirstChars(1) == ' '
                ) {
                    $preview->set(
                        $str->getLastChars($maxChars - $end->length())
                            ->trimSpaces()
                            ->get()
                    );
                } else {
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
         * @return static
         */
        public function spanify($classPrefix = '')
        {
            if ($this->isEmptyWithoutTags()) {
                return $this->set('', Common::getDefaultEncoding());
            }

            $spanify = static::load('', Common::getDefaultEncoding());

            $words = $this->getClone()
                          ->trimSpaces()
                          ->split('\s');

            $last = count($words) - 1;
            foreach ($words as $index => $word) {
                $spanify->concat('<span class="' . $classPrefix . 'word">');
                $letters = static::load($word, Common::getDefaultEncoding())
                                 ->getCharactersArray();
                foreach ($letters as $letter) {
                    $spanify->concat('<span class="' . $classPrefix . 'char">')
                            ->concat($letter)
                            ->concat('</span>');
                }
                $spanify->concat('</span>');

                if ($index != $last) {
                    $spanify->concat('<span class="' . $classPrefix . 'space">')
                            ->concat(' ')
                            ->concat('</span>');
                }
            }

            return $spanify;
        }

        /**
         * Replace spaces in string to none-breakable space
         *
         * @return static
         */
        public function noneBreakableSpaces()
        {
            return $this->replace(' ', '&nbsp;');
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
            return mb_substr_count($this->string, static::load($string), Common::getDefaultEncoding());
        }

        /**
         * Return TRUE if loaded string is serialized string
         *
         * @return bool
         */
        public function isSerialized()
        {
            $isSerialized = false;

            try {
                $isSerialized = unserialize($this->get());

                //Cannot deserialize
                if ($isSerialized === false) {
                    return false;
                }

                return true;
            }
            catch (\Exception $e) {
                $isSerialized = false;
            }

            return $isSerialized;

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
         * Return TRUE if loaded string is valid JSON
         *
         * @return bool
         */
        public function isJSON()
        {
            if ($this->length() == 0) {
                return false;
            }

            json_decode($this->get());

            return json_last_error() === JSON_ERROR_NONE;
        }

        /**
         * Get length of loaded string
         *
         * @return integer Length of loaded string
         */
        public function length()
        {
            return mb_strlen($this->get(), Common::getDefaultEncoding());
        }

        /**
         * Alias for length
         *
         * @see length()
         * @return int
         */
        public function len()
        {
            return $this->length();
        }

        /**
         * Alias for length
         *
         * @see length()
         * @return int
         */
        public function count()
        {
            return $this->length();
        }

        /**
         * Get Levenshtein distance between arguments and loaded string
         *
         * @param string|self|array Other stringable
         *
         * @return integer Levenshtein distance
         */
        public function getLevenshteinDistance($stringable)
        {

            $string = static::load($stringable)
                            ->get();

            $currentLenght = $this->length();
            $stringLength = static::load($stringable)
                                  ->length();

            //special cases
            if ($currentLenght == 0) {
                return $stringLength;
            }
            if ($stringLength == 0) {
                return $currentLenght;
            }
            if ($this->get() === $string) {
                return 0;
            }

            $iPos = $jPos = 0;
            $result = [];

            for ($iPos = 0; $iPos <= $currentLenght; $iPos++) {
                $result[$iPos] = [$iPos];
            }

            for ($jPos = 0; $jPos <= $stringLength; $jPos++) {
                $result[0][$jPos] = $jPos;
            }

            for ($jPos = 1; $jPos <= $stringLength; $jPos++) {
                for ($iPos = 1; $iPos <= $currentLenght; $iPos++) {
                    if ($this->string[$iPos - 1] == $string[$jPos - 1]) {
                        $result[$iPos][$jPos] = $result[$iPos - 1][$jPos - 1];
                    } else {
                        $result[$iPos][$jPos] =
                            min($result[$iPos - 1][$jPos], $result[$iPos][$jPos - 1], $result[$iPos - 1][$jPos - 1])
                            + 1;
                    }
                }
            }

            return $result[$currentLenght][$stringLength] * 1;
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
         * Return loaded string repeated $n times
         * If $n<=1 method don't have effect
         *
         * @param integer $n Times to repeat string
         *
         * @return self Current instance
         */
        public function repeat($times)
        {
            if ($times >= 1) {
                $this->string = str_repeat($this->string, $times);
            }

            return $this;
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
            if ($fillLen > 0 && !empty($filler)) {
                return $this->set(
                    static::load($filler)
                          ->repeat($fillLen)
                          ->substring(0, $fillLen)
                          ->prepend($this->get())
                          ->get()
                );
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
            if ($fillLen > 0 && !empty($filler)) {
                return $this->set(
                    static::load($filler)
                          ->repeat($fillLen)
                          ->substring(0, $fillLen)
                          ->concat($this->get())
                          ->get()
                );
            }

            return $this;
        }

        /**
         * Alias for concat()
         *
         * @see   concat()
         *
         * @param string|static|array Parameter of parameters to append to loaded string
         *
         * @return self Current instance
         */
        public function append($stringable)
        {
            return $this->concat($stringable);
        }

        /**
         * Concatenate arguments with loaded string
         * Arguments placed to end of string
         *
         * @param string|static|array Parameter of parameters to concat to loaded string
         *
         * @return self Current instance
         */
        public function concat($stringable)
        {
            return $this->set($this->get() . static::load($stringable));
        }

        /**
         * Place merged arguments before loaded string
         *
         * @param string|static|array Parameter of parameters to prepend to loaded string
         *
         * @return self Current instance
         */
        public function prepend($stringable)
        {
            return $this->set(static::load($stringable) . $this->get());
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
            return $this->set(mb_ereg_replace($regexp, $replacement, $this->get(), $options));
        }

        /**
         * Return array of matches by regular expression found in loaded string
         *
         * @param string $regexp Regular expression
         *
         * @return array Array of matches
         */
        public function getMatches($regexp)
        {

            $result = [];

            $currentString = $this->get();

            if (!empty($currentString) && !empty($regexp)) {

                mb_ereg_search_init($this->get(), $regexp);
                if (mb_ereg_search()) {
                    $matches = [mb_ereg_search_getregs()];
                    do {
                        $currentMatch = mb_ereg_search_regs();
                        $matches[] = $currentMatch;
                    } while ($currentMatch);

                    foreach ($matches as $value) {
                        if (isset($value[0]) && $value[0] != '') {
                            $result[] = $value[0];
                        }
                    }

                }
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
            return (mb_ereg($regexp, $this->get()) !== false);
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
                                    ->get(), $offset, Common::getDefaultEncoding()
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
                                    ->get(), $offset, Common::getDefaultEncoding()
            );
        }

        /**
         * Return TRUE if arguments contains in loaded string
         *
         * @return bool
         */
        public function contains($string)
        {
            return ($this->getPosition($string) !== false);
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
                $this->get(), $string, $offset, Common::getDefaultEncoding()
            );
        }

        /**
         * Return TRUE if arguments contains in loaded string. Ignore case
         *
         * @return bool
         */
        public function containsIgnoreCase($string)
        {
            return ($this->getPositionIgnoreCase($string) !== false);
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
                                    ->get(), $offset, Common::getDefaultEncoding()
            );
        }

        /**
         * Get information string about current items displayed at current page, like: 1-10 from 200.
         * Useful for pagination modules/plugins.
         *
         * @param        $totalItems
         * @param        $itemsPerPage
         * @param        $offset
         * @param string $commaSign
         * @param string $periodSign
         * @param string $from
         *
         * @return string
         */
        public static function getScrollPaginationInfo(
            $totalItems,
            $itemsPerPage,
            $offset,
            $commaSign = ', ',
            $periodSign = ' - ',
            $from = ' / '
        ) {
            $info = '';

            $commaCheck = function ($a, $b) use ($commaSign, $periodSign) {
                if ($a == $b) {
                    return $a;
                }
                if (abs($a - $b) == 1) {
                    return min($a, $b) . $commaSign . max($a, $b);
                }

                return min($a, $b) . $periodSign . max($a, $b);
            };

            if ($itemsPerPage == 1) {
                $info .= $offset + 1;
            } else {
                //first page
                if ($offset == 0) {
                    $info .= $commaCheck(1, $itemsPerPage);
                } //last page
                elseif ($offset + $itemsPerPage >= $totalItems) {
                    if ($offset + $itemsPerPage == $totalItems) {
                        $info = $commaCheck($totalItems - $itemsPerPage + 1, $totalItems);
                    } else {
                        $info = $commaCheck($totalItems - ($totalItems - $offset) + 1, $totalItems);
                    }
                } //other
                else {
                    $info = $commaCheck($offset + 1, $offset + $itemsPerPage);
                }
            }
            $info .= $from . $totalItems;

            return $info;
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

            if ($currentYear - $sinceYear > 0) {
                return $this->set($sinceYear . $separator . $currentYear);
            }

            return $this->set($sinceYear);

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

            if (!is_array($positions)) {
                $positions = [$positions];
            }

            $result = [];
            $parts = explode($delimiter, $this->string);

            foreach ($positions as $position) {
                if (array_key_exists($position, $parts)) {
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
         * Returns TRUE if loaded string is starts with $start string ignore case, FALSE otherwise
         *
         * @param string $start String to search
         *
         * @return boolean Compare result
         */
        public function isStartsWithIgnoreCase($start)
        {

            $starts = static::load($start);

            if ($starts->length() == 0) {
                return true;
            }

            if ($this->length() >= $starts->length()) {

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

            if ($ends->length() == 0) {
                return true;
            }

            if ($this->length() >= $ends->length()) {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());

                return $ends->isEqualsIgnoreCase($substr);
            }

            return false;
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

            if ($starts->length() == 0) {
                return true;
            }

            if ($this->length() >= $starts->length()) {

                $substring = $this->getClone()
                                  ->getFirstChars($starts->length());

                return $starts->isEquals($substring);
            }

            return false;
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

            if ($ends->length() == 0) {
                return true;
            }

            if ($this->length() >= $ends->length()) {
                $substr = $this->getClone()
                               ->getLastChars($ends->length());

                return $ends->isEquals($substr);
            }

            return false;
        }

        /**
         * Return first $length characters from loaded string
         *
         * @param integer $length Length of characters returned from beginning of loaded string
         *
         * @return self Current instance
         */
        public function getFirstChars($length)
        {
            if ($length == 0) {
                return $this->set('');
            }
            if ($length < 0) {
                return $this->getLastChars(-$length);
            }

            return $this->substring(0, $length);
        }

        /**
         * Return last $length characters from loaded string.
         * If $length equals 0 empty string returned.
         * Elsewhere $length is below 0 returns $length characters from beginnings
         *
         * @param integer $length Length of characters returned from end of loaded string
         *
         * @return self Current instance
         */
        public function getLastChars($length)
        {
            if ($length == 0) {
                return $this->set('');
            }
            if ($length < 0) {
                return $this->getFirstChars(-$length);
            }

            return $this->substring(-$length);
        }

        /**
         * Get part of string
         *
         * @param integer $start  Start position of substring
         * @param integer $length Length of substring from start position
         *
         * @return self Current instance
         */
        public function substring($start = 0, $length = null)
        {
            return $this->set(mb_substr($this->get(), $start, $length, Common::getDefaultEncoding()));
        }

        /**
         * Get length characters from end of loaded string
         *
         * @param $length
         * @return StringHelper
         */
        public function substringFromEnd($length)
        {
            return $this->getLastChars($length);
        }

    }
}
