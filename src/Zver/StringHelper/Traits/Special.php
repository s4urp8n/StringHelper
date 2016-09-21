<?php
namespace Zver\StringHelper\Traits
{
    
    trait Special
    {
        
        protected $string = '';
        
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
            $totalItems, $itemsPerPage, $offset, $commaSign = ', ', $periodSign = ' - ', $from = ' / '
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
            
            if ($itemsPerPage == 1)
            {
                $info .= $offset + 1;
            }
            else
            {
                //first page
                if ($offset == 0)
                {
                    $info .= $commaCheck(1, $itemsPerPage);
                }
                //last page
                elseif ($offset + $itemsPerPage >= $totalItems)
                {
                    if ($offset + $itemsPerPage == $totalItems)
                    {
                        $info = $commaCheck($totalItems - $itemsPerPage + 1, $totalItems);
                    }
                    else
                    {
                        $info = $commaCheck($totalItems - ($totalItems - $offset) + 1, $totalItems);
                    }
                }
                //other
                else
                {
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
            
            if ($currentYear - $sinceYear > 0)
            {
                return $this->set($sinceYear . $separator . $currentYear);
            }
            
            return $this->set($sinceYear);
            
        }
    }
}
