# Zver\StringHelper

## Table of Contents

* [StringHelper](#stringhelper)
    * [getDefaultEncoding](#getdefaultencoding)
    * [isEncodingSupported](#isencodingsupported)
    * [getSupportedEncodings](#getsupportedencodings)
    * [loadFromFile](#loadfromfile)
    * [setFromFile](#setfromfile)
    * [load](#load)
    * [set](#set)
    * [getScrollPaginationInfo](#getscrollpaginationinfo)
    * [__toString](#__tostring)
    * [get](#get)
    * [saveToFile](#savetofile)
    * [appendToFile](#appendtofile)
    * [matches](#matches)
    * [getEncoding](#getencoding)
    * [contains](#contains)
    * [getPosition](#getposition)
    * [containsIgnoreCase](#containsignorecase)
    * [getPositionIgnoreCase](#getpositionignorecase)
    * [getPositionFromEnd](#getpositionfromend)
    * [getPositionFromEndIgnoreCase](#getpositionfromendignorecase)
    * [getSubstringCount](#getsubstringcount)
    * [reverse](#reverse)
    * [toCharactersArray](#tocharactersarray)
    * [length](#length)
    * [substring](#substring)
    * [getClone](#getclone)
    * [isSerialized](#isserialized)
    * [isMatch](#ismatch)
    * [isStartsWithIgnoreCase](#isstartswithignorecase)
    * [getFirst](#getfirst)
    * [isEqualsIgnoreCase](#isequalsignorecase)
    * [getLast](#getlast)
    * [toLowerCase](#tolowercase)
    * [isEndsWithIgnoreCase](#isendswithignorecase)
    * [getFirstPart](#getfirstpart)
    * [getParts](#getparts)
    * [getLastPart](#getlastpart)
    * [setBeginning](#setbeginning)
    * [isStartsWith](#isstartswith)
    * [prepend](#prepend)
    * [isEquals](#isequals)
    * [setEnding](#setending)
    * [isEndsWith](#isendswith)
    * [append](#append)
    * [concat](#concat)
    * [removeBeginning](#removebeginning)
    * [removeEnding](#removeending)
    * [toRandomCase](#torandomcase)
    * [toUpperCase](#touppercase)
    * [toUpperCaseFirst](#touppercasefirst)
    * [fillRight](#fillright)
    * [repeat](#repeat)
    * [fillLeft](#fillleft)
    * [removeEntities](#removeentities)
    * [remove](#remove)
    * [replace](#replace)
    * [nl2br](#nl2br)
    * [newlineToBreak](#newlinetobreak)
    * [br2nl](#br2nl)
    * [breakToNewline](#breaktonewline)
    * [underscore](#underscore)
    * [slugify](#slugify)
    * [hyphenate](#hyphenate)
    * [trimSpaces](#trimspaces)
    * [transliterate](#transliterate)
    * [trimSpacesRight](#trimspacesright)
    * [trimSpacesLeft](#trimspacesleft)
    * [convertEncoding](#convertencoding)
    * [footerYears](#footeryears)
    * [shuffleCharacters](#shufflecharacters)
    * [toLinesArray](#tolinesarray)
    * [split](#split)
    * [soundex](#soundex)
    * [metaphone](#metaphone)
    * [levenshtein](#levenshtein)
    * [toURL](#tourl)
    * [fromURL](#fromurl)
    * [toBase64](#tobase64)
    * [fromBase64](#frombase64)
    * [toUUE](#touue)
    * [fromUUE](#fromuue)
    * [toUTF8](#toutf8)
    * [fromUTF8](#fromutf8)
    * [toHTMLEntities](#tohtmlentities)
    * [fromHTMLEntities](#fromhtmlentities)
    * [fromJSON](#fromjson)
    * [isJSON](#isjson)
    * [toJSON](#tojson)
    * [fromPunyCode](#frompunycode)
    * [toPunyCode](#topunycode)
    * [getPreview](#getpreview)
    * [removeTags](#removetags)
    * [spanify](#spanify)
    * [isEmptyWithoutTags](#isemptywithouttags)
    * [isEmpty](#isempty)
    * [isUpperCase](#isuppercase)
    * [isLowerCase](#islowercase)
    * [isTitleCase](#istitlecase)
    * [toTitleCase](#totitlecase)

## StringHelper





* Full name: \Zver\StringHelper


### getDefaultEncoding



```php
StringHelper::getDefaultEncoding(  )
```



* This method is **static**.



---

### isEncodingSupported

Return TRUE if $encoding is supported, FALSE otherwise.

```php
StringHelper::isEncodingSupported(  $encoding ): boolean
```

Throws exception if $encoding is not supported by mb_string

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$encoding` | **** |  |




---

### getSupportedEncodings

Get array of supported encodings

```php
StringHelper::getSupportedEncodings(  ): array
```



* This method is **static**.

**Return Value:**

Array of encodings



---

### loadFromFile

Load string from file

```php
StringHelper::loadFromFile( string $fileName, string|null $encoding = null ): self
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fileName` | **string** |  |
| `$encoding` | **string&#124;null** |  |


**Return Value:**

Current instance



---

### setFromFile

Read file content and set current string

```php
StringHelper::setFromFile( string $fileName ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fileName` | **string** |  |


**Return Value:**

Current instance



---

### load

Get class instance

```php
StringHelper::load( string|array|self $string = &#039;&#039;, string $encoding = null ): self
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |
| `$encoding` | **string** |  |


**Return Value:**

Current instance



---

### set

Set current string

```php
StringHelper::set( string|array|self $string = &#039;&#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |


**Return Value:**

Current instance



---

### getScrollPaginationInfo

Get information string about current items displayed at current page, like: 1-10 from 200.

```php
StringHelper::getScrollPaginationInfo(  $total_items,  $items_per_page,  $offset, string $commaSign = &#039;, &#039;, string $periodSign = &#039; - &#039;, string $from = &#039; / &#039; ): string
```

Useful for pagination modules/plugins.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$total_items` | **** |  |
| `$items_per_page` | **** |  |
| `$offset` | **** |  |
| `$commaSign` | **string** |  |
| `$periodSign` | **string** |  |
| `$from` | **string** |  |




---

### __toString

Return result string when using class as string

```php
StringHelper::__toString(  ): string
```





**Return Value:**

Return result string when using class as string



---

### get

Get loaded string

```php
StringHelper::get(  ): string
```





**Return Value:**

Return result string



---

### saveToFile

Save loaded string to file

```php
StringHelper::saveToFile( string $fileName ): integer
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fileName` | **string** |  |


**Return Value:**

Write result



---

### appendToFile

Append loaded string to file

```php
StringHelper::appendToFile( string $fileName ): integer
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$fileName` | **string** |  |


**Return Value:**

Write result



---

### matches

Return array of matches by regular expression found in loaded string

```php
StringHelper::matches( string $regexp ): array
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regexp` | **string** | Regular expression |


**Return Value:**

Array of matches



---

### getEncoding

Get current instance encoding

```php
StringHelper::getEncoding(  ): string
```







---

### contains

Return TRUE if arguments contains in loaded string

```php
StringHelper::contains(  ): boolean
```







---

### getPosition

Return position of first occurrence $string in loaded string. If $string not found return FALSE

```php
StringHelper::getPosition( string|array|self $string, integer $offset ): integer|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |
| `$offset` | **integer** |  |




---

### containsIgnoreCase

Return TRUE if arguments contains in loaded string. Ignore case

```php
StringHelper::containsIgnoreCase(  ): boolean
```







---

### getPositionIgnoreCase

Return position of first occurrence $string in loaded string. If $string not found return FALSE

```php
StringHelper::getPositionIgnoreCase( string|array|self $string, integer $offset ): integer|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |
| `$offset` | **integer** |  |




---

### getPositionFromEnd

Return position of first occurrence $string in loaded string. If $string not found return FALSE

```php
StringHelper::getPositionFromEnd( string|array|self $string, integer $offset ): integer|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |
| `$offset` | **integer** |  |




---

### getPositionFromEndIgnoreCase

Return position of first occurrence $string in loaded string. If $string not found return FALSE

```php
StringHelper::getPositionFromEndIgnoreCase( string|array|self $string, integer $offset ): integer|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** |  |
| `$offset` | **integer** |  |




---

### getSubstringCount

Get count of substring in loaded string

```php
StringHelper::getSubstringCount( string|array|self $string ): integer
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string` | **string&#124;array&#124;self** | Substring to count count |


**Return Value:**

Count of substring in loaded string



---

### reverse

Reverse loaded string

```php
StringHelper::reverse(  ): self
```





**Return Value:**

Current instance



---

### toCharactersArray

Get array of characters of loaded string

```php
StringHelper::toCharactersArray(  ): array
```







---

### length

Get length of loaded string

```php
StringHelper::length(  ): integer
```





**Return Value:**

Length of loaded string



---

### substring

Get part of string

```php
StringHelper::substring( integer $start, integer $length = null ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | **integer** | Start position of substring |
| `$length` | **integer** | Length of substring from start position |


**Return Value:**

Current instance



---

### getClone

Get new instance of self equals current instance

```php
StringHelper::getClone(  ): self
```





**Return Value:**

Return new instance with loaded string equals current instance



---

### isSerialized

Return TRUE if loaded string is serialized string

```php
StringHelper::isSerialized(  ): boolean
```







---

### isMatch

Return TRUE if loaded string matches regular expression

```php
StringHelper::isMatch( string $regexp ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regexp` | **string** |  |




---

### isStartsWithIgnoreCase

Returns TRUE if loaded string is starts with $start string ignore case, FALSE otherwise

```php
StringHelper::isStartsWithIgnoreCase( string $start ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | **string** | String to search |


**Return Value:**

Compare result



---

### getFirst

Return first $length characters from loaded string

```php
StringHelper::getFirst( integer $length ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$length` | **integer** | Length of characters returned from beginning of loaded string |


**Return Value:**

Current instance



---

### isEqualsIgnoreCase

Return TRUE if loaded string and $string is equals ignore case

```php
StringHelper::isEqualsIgnoreCase(  ): boolean
```





**Return Value:**

Compare result



---

### getLast

Return last $length characters from loaded string.

```php
StringHelper::getLast( integer $length ): self
```

If $length equals 0 empty string returned.
Elsewhere $length is below 0 returns $length characters from beginnings


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$length` | **integer** | Length of characters returned from end of loaded string |


**Return Value:**

Current instance



---

### toLowerCase

Convert case of loaded string to lowercase

```php
StringHelper::toLowerCase(  ): self
```





**Return Value:**

Current instance



---

### isEndsWithIgnoreCase

Returns TRUE if loaded string is ends with $end string ignore case, FALSE otherwise

```php
StringHelper::isEndsWithIgnoreCase( string $end ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$end` | **string** | String to compare with loaded string end |


**Return Value:**

Compare result



---

### getFirstPart

Return first part of string exploded by delimiter

```php
StringHelper::getFirstPart( string $delimiter = &#039; &#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delimiter` | **string** |  |


**Return Value:**

Current instance



---

### getParts

Returns parts of loaded string imploded by positions

```php
StringHelper::getParts( mixed $positions, string $delimiter = &#039; &#039;, string $glue = &#039; &#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$positions` | **mixed** | Position or positions of part to return |
| `$delimiter` | **string** | Delimiter to explode string |
| `$glue` | **string** | If returns multiple parts, parts will imploded with $glue string |


**Return Value:**

Current instance



---

### getLastPart

Return last part of string exploded by delimiter

```php
StringHelper::getLastPart( string $delimiter = &#039; &#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delimiter` | **string** | String separator |


**Return Value:**

Current instance



---

### setBeginning

Set beginning of loaded string if it not exist

```php
StringHelper::setBeginning(  ): self
```





**Return Value:**

Current instance



---

### isStartsWith

Returns TRUE if loaded string is starts with $start string, FALSE otherwise

```php
StringHelper::isStartsWith( string $start ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | **string** | String to search |


**Return Value:**

Compare result



---

### prepend

Place merged arguments before loaded string

```php
StringHelper::prepend(  ): self
```





**Return Value:**

Current instance



---

### isEquals

Return TRUE if loaded string and $string is equals match case

```php
StringHelper::isEquals(  ): boolean
```





**Return Value:**

Compare result



---

### setEnding

Set ending of loaded string if it not exist

```php
StringHelper::setEnding(  ): self
```





**Return Value:**

Current instance



---

### isEndsWith

Returns TRUE if loaded string is ends with $end string, FALSE otherwise

```php
StringHelper::isEndsWith( string $end ): boolean
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$end` | **string** | String to compare with loaded string end |


**Return Value:**

Compare result



---

### append

Alias for concat()

```php
StringHelper::append(  ): self
```





**Return Value:**

Current instance



---

### concat

Concatenate arguments with loaded string
Arguments placed to end of string

```php
StringHelper::concat(  ): self
```





**Return Value:**

Current instance



---

### removeBeginning

Remove beginning of loaded string if it exists

```php
StringHelper::removeBeginning(  ): self
```





**Return Value:**

Current instance



---

### removeEnding

Remove ending from loaded string if it exists

```php
StringHelper::removeEnding(  ): self
```





**Return Value:**

Current instance



---

### toRandomCase

Randomize case of loaded string

```php
StringHelper::toRandomCase(  ): self
```





**Return Value:**

Current instance



---

### toUpperCase

Convert case of loaded string to uppercase

```php
StringHelper::toUpperCase(  ): self
```





**Return Value:**

Current instance



---

### toUpperCaseFirst

Set first character to uppercase, others to lowercase

```php
StringHelper::toUpperCaseFirst(  ): self
```





**Return Value:**

Current instance



---

### fillRight

Fill loaded string to $length using $filler from right

```php
StringHelper::fillRight( string $filler, integer $length ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$filler` | **string** |  |
| `$length` | **integer** |  |


**Return Value:**

Current instance



---

### repeat

Return loaded string repeated $n times
If $n<=1 method don't have effect

```php
StringHelper::repeat(  $times ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$times` | **** |  |


**Return Value:**

Current instance



---

### fillLeft

Fill loaded string to $length using $filler from left

```php
StringHelper::fillLeft( string $filler, integer $length ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$filler` | **string** |  |
| `$length` | **integer** |  |


**Return Value:**

Current instance



---

### removeEntities

Remove encoded entities from loaded string

```php
StringHelper::removeEntities(  ): self
```





**Return Value:**

Current instance



---

### remove

Remove substring matches regular expression

```php
StringHelper::remove(  $regexp ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regexp` | **** |  |




---

### replace

Replace substring matched regular expression with replacement

```php
StringHelper::replace( string $regexp, string $replacement, string $options = &#039;mr&#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regexp` | **string** | Regular expression to match |
| `$replacement` | **string** | String replacement |
| `$options` | **string** | String of options, where:
                           i - Ambiguity match on,
                           x - Enables extended pattern form,
                           m - '.' matches with newlines,
                           s - '^' -> '\A', '$' -> '\Z',
                           p - Same as both the m and s options,
                           l - Finds longest matches,
                           n - Ignores empty matches,
                           e - eval() resulting code,
                           j - Java (Sun java.util.regex),
                           u - GNU regex,
                           g - grep,
                           c - Emacs,
                           r - Ruby,
                           z - Perl,
                           b - POSIX Basic regex,
                           d - POSIX Extended regex. |


**Return Value:**

Current instance



---

### nl2br

Alias for function newlineToBreak

```php
StringHelper::nl2br(  ): self
```





**Return Value:**

Current instance



---

### newlineToBreak

Add <br/> tag before any newline character

```php
StringHelper::newlineToBreak(  ): self
```





**Return Value:**

Current instance



---

### br2nl

Alias for function breakToNewline

```php
StringHelper::br2nl(  ): self
```





**Return Value:**

Current instance



---

### breakToNewline

Convert all <br/> tags to current platform end of line character

```php
StringHelper::breakToNewline(  ): self
```





**Return Value:**

Current instance



---

### underscore

Replace whitespaces with underscore symbol "_"

```php
StringHelper::underscore(  ): self
```





**Return Value:**

Current instance



---

### slugify

Get slug of string

```php
StringHelper::slugify(  ): self
```





**Return Value:**

Current instance



---

### hyphenate

Replace whitespaces with hyphen symbol "-"

```php
StringHelper::hyphenate(  ): self
```





**Return Value:**

Current instance



---

### trimSpaces

Trim whitespaces from string

```php
StringHelper::trimSpaces(  ): self
```





**Return Value:**

Current instance



---

### transliterate

Get transliterated string.

```php
StringHelper::transliterate(  ): self
```







---

### trimSpacesRight

Trim whitespaces from the right

```php
StringHelper::trimSpacesRight(  ): self
```





**Return Value:**

Current instance



---

### trimSpacesLeft

Trim whitespaces from the left

```php
StringHelper::trimSpacesLeft(  ): self
```





**Return Value:**

Current instance



---

### convertEncoding

Convert string to another encoding

```php
StringHelper::convertEncoding( string $encoding ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$encoding` | **string** |  |


**Return Value:**

Current instance



---

### footerYears

Return company footer since years like 1998-2015

```php
StringHelper::footerYears(  $sinceYear, string $separator = &#039;—&#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$sinceYear` | **** |  |
| `$separator` | **string** |  |




---

### shuffleCharacters

Shuffle characters in loaded string

```php
StringHelper::shuffleCharacters(  ): self
```





**Return Value:**

Current instance



---

### toLinesArray

Get  array of lines of loaded string

```php
StringHelper::toLinesArray(  ): array
```







---

### split

Split string using regular expression

```php
StringHelper::split( string $regexp, integer $limit = -1 ): array
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regexp` | **string** |  |
| `$limit` | **integer** |  |




---

### soundex

Generate soundex code.

```php
StringHelper::soundex(  ): string
```

If loaded string contains not-latin characters it will be transliterated





---

### metaphone

Generate metaphone code.

```php
StringHelper::metaphone(  ): self
```

If loaded string contains not-latin characters it will be transliterated



**Return Value:**

Current instance



---

### levenshtein

Get Levenshtein distance between arguments and loaded string

```php
StringHelper::levenshtein(  ): self
```





**Return Value:**

Current instance



---

### toURL

Encode loaded string to URL-safe string

```php
StringHelper::toURL(  ): self
```





**Return Value:**

Current instance



---

### fromURL

Decode loaded string from URL-safe string to native string

```php
StringHelper::fromURL(  ): self
```





**Return Value:**

Current instance



---

### toBase64

Encode loaded string to BASE64

```php
StringHelper::toBase64(  ): self
```





**Return Value:**

Current instance



---

### fromBase64

Decode loaded string from BASE64 string

```php
StringHelper::fromBase64(  ): self
```





**Return Value:**

Current instance



---

### toUUE

UUE encode loaded string

```php
StringHelper::toUUE(  ): self
```





**Return Value:**

Current instance



---

### fromUUE

UUE decode loaded string

```php
StringHelper::fromUUE(  ): self
```





**Return Value:**

Current instance



---

### toUTF8

Encode loaded string to UTF-8

```php
StringHelper::toUTF8(  ): self
```





**Return Value:**

Current instance



---

### fromUTF8

Decode loaded string from UTF-8 string

```php
StringHelper::fromUTF8(  ): self
```





**Return Value:**

Current instance



---

### toHTMLEntities

Encode html entities presented in loaded string

```php
StringHelper::toHTMLEntities( integer $flags = ENT_QUOTES ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$flags` | **integer** | Entities flag |



**See Also:**

* http://php.net/manual/ru/function.htmlentities.php 

---

### fromHTMLEntities

Decode encoded entities presents in loaded string

```php
StringHelper::fromHTMLEntities( integer $flags = ENT_QUOTES ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$flags` | **integer** | Entities flags |


**Return Value:**

Current instance


**See Also:**

* http://php.net/manual/ru/function.html-entity-decode.php 

---

### fromJSON

Decode loaded string from JSON

```php
StringHelper::fromJSON(  ): self
```







---

### isJSON

Return TRUE if loaded string is valid JSON

```php
StringHelper::isJSON(  ): boolean
```







---

### toJSON

Encode loaded string as JSON

```php
StringHelper::toJSON(  ): self
```







---

### fromPunyCode

Get UTF-8 string from punycode encoded string

```php
StringHelper::fromPunyCode(  ): self
```





**Return Value:**

Current instance



---

### toPunyCode

Get punycode encoded string from loaded string. Encoding will set to and string converted to UTF-8

```php
StringHelper::toPunyCode(  ): self
```





**Return Value:**

Current instance



---

### getPreview

Get text preview of loaded string without tags and redundant spaces.

```php
StringHelper::getPreview( integer $maxChars = 100, string $missEnd = &#039;...&#039;, boolean $fromBeginning = true ): string
```

Only whole words will presented in preview.

$text = '<a>
             <p>
                 some preview   text
             </p>
         </a>';

...->getPreview(-1000) = "..."
...->getPreview(2) = "..."
...->getPreview(3) = "..."
...->getPreview(7) = "some..."
...->getPreview(8) = "some..."
...->getPreview(13) = "some..."
...->getPreview(14) = "some..."
...->getPreview(15) = "some preview..."
...->getPreview(16) = "some preview..."
...->getPreview(17) = "some preview text"
...->getPreview(18) = "some preview text"
...->getPreview(2000) = "some preview text"


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$maxChars` | **integer** |  |
| `$missEnd` | **string** |  |
| `$fromBeginning` | **boolean** | Leave text from beginning or not |




---

### removeTags

Remove tags from loaded string

```php
StringHelper::removeTags( string $allowableTags = &#039;&#039; ): self
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$allowableTags` | **string** | Tags allowed to leave in string |


**Return Value:**

Current instance



---

### spanify

Wrap every word and letter to span.

```php
StringHelper::spanify( string $classPrefix = &#039;&#039; ): \Str\Str
```

Words wrapped with class "word".
Letters wrapped with class "char".
Spaces wrapped with class "space".


**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$classPrefix` | **string** | Prefix to class names |




---

### isEmptyWithoutTags

Check string for symbolic emptiness without tags
Return FALSE if loaded string contains digit or/and letter, TRUE otherwise

```php
StringHelper::isEmptyWithoutTags(  ): boolean
```







---

### isEmpty

Check string for symbolic emptiness
Return FALSE if loaded string contains digit or/and letter, TRUE otherwise

```php
StringHelper::isEmpty(  ): boolean
```







---

### isUpperCase

Return true if loaded string in upper case, false otherwise

```php
StringHelper::isUpperCase(  ): boolean
```







---

### isLowerCase

Return true if loaded string in lower case, false otherwise

```php
StringHelper::isLowerCase(  ): boolean
```







---

### isTitleCase

Return true if loaded string in title case, false otherwise

```php
StringHelper::isTitleCase(  ): boolean
```







---

### toTitleCase

Convert case of loaded string to title case (every word start with uppercase first letter)

```php
StringHelper::toTitleCase(  ): self
```





**Return Value:**

Current instance



---



--------
> This document was automatically generated from source code comments on 2016-06-23 using [phpDocumentor](http://www.phpdoc.org/) and [cvuorinen/phpdoc-markdown-public](https://github.com/cvuorinen/phpdoc-markdown-public)
