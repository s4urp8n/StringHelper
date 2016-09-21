<?php
namespace Zver\StringHelper\Traits
{
    
    trait Regex
    {
        
        protected $string = '';
        
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
        public function matches($regexp)
        {
            
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
            
            $result = (mb_ereg($regexp, $this->get()) !== false);
            
            return $result;
        }
        
    }
}