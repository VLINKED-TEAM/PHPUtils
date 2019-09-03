<?php


namespace VlinkedUtils;


class Strings
{

    const TRIM_CHARACTERS = " \t\n\r\0\x0B\xC2\xA0";

    public static function isEN($str = '')
    {
        $len1 = strlen($str);
        $len2 = mb_strlen($str, 'gbk');
        if ($len1 == $len2) {
            return true;
        }
        return false;
    }

    /**
     * 截取指定长度字符串: width 所需修剪的宽度，中英文配比为二比一
     * @param $str
     * @param $width
     * @param string $replaceStr
     * @return string
     */
    public static function getSubstr($str, $width, $replaceStr = '*')
    {
        $origWidth = mb_strwidth($str, 'utf-8');
        if ($origWidth <= $width) {
            return $str;
        }
        //先取尾部
        $endStr = mb_substr($str, -1, 1, 'utf-8');
        $endWidth = mb_strwidth($endStr, 'utf-8');
        //再取前头的
        $prefixStr = mb_strimwidth($str, 0, $width - $endWidth, $replaceStr, "utf-8");

        return $prefixStr . $endStr;
    }

    /**
     * 检查字符串是否为有效的UTF-8编码
     * Checks if the string is valid for UTF-8 encoding.
     * @param string  byte stream to check
     * @return bool
     */
    public static function checkEncoding($s)
    {
        return $s === self::fixEncoding($s);
    }

    /**
     * 去除字符串中的非字符编码
     * Removes invalid code unit sequences from UTF-8 string.
     * @param string  byte stream to fix
     * @return string
     */
    public static function fixEncoding($s)
    {
        // removes xD800-xDFFF, x110000 and higher
        return htmlspecialchars_decode(htmlspecialchars($s, ENT_NOQUOTES | ENT_IGNORE, 'UTF-8'), ENT_NOQUOTES);
    }

    /**
     * Returns a specific character in UTF-8.
     * @param int     code point (0x0 to 0xD7FF or 0xE000 to 0x10FFFF)
     * @return string
     * @throws ArgumentOutOfRangeException if code point is not in valid range
     */
    public static function chr($code)
    {
        if ($code < 0 || ($code >= 0xD800 && $code <= 0xDFFF) || $code > 0x10FFFF) {
            throw new ArgumentOutOfRangeException('Code point must be in range 0x0 to 0xD7FF or 0xE000 to 0x10FFFF.');
        }
        return iconv('UTF-32BE', 'UTF-8//IGNORE', pack('N', $code));
    }

    /**
     * 检查某个字符串是否开始于另外一个字符串
     * Starts the $haystack string with the prefix $needle?
     * @param string
     * @param string
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }

    /**
     * 检查某个字符串是否结束于另外一个字符串
     * @param string
     * @param string
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        return strlen($needle) === 0 || substr($haystack, -strlen($needle)) === $needle;
    }

    /**
     * $haystack 字符串是否包含 $needle
     * @param string $haystack 大字符串
     * @param string $needle  拿去检查的字符串
     * @return bool
     */
    public static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * 截取子字符串
     * @param string $s 需要截取的长字符串
     * @param int $start 截取开始
     * @param int|null $length 截取长度
     * @return string
     */
    public static function substring($s, $start, $length = null)
    {
        if (function_exists('mb_substr')) {
            return mb_substr($s, $start, $length, 'UTF-8'); // MB is much faster
        } elseif ($length === null) {
            $length = self::length($s);
        } elseif ($start < 0 && $length < 0) {
            $start += self::length($s); // unifies iconv_substr behavior with mb_substr
        }
        return iconv_substr($s, $start, $length, 'UTF-8');
    }

    /**
     * 常规处理字符串
     * 去掉字符串中的额外缩减以及新行 trim
     * Removes special controls characters and normalizes line endings and spaces.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function normalize($s)
    {
        $s = self::normalizeNewLines($s);
        // remove control characters; leave \t + \n
        $s = preg_replace('#[\x00-\x08\x0B-\x1F\x7F-\x9F]+#u', '', $s);
        // right trim
        $s = preg_replace('#[\t ]+$#m', '', $s);
        // leading and trailing blank lines
        $s = trim($s, "\n");
        return $s;
    }

    /**
     * 标准化的 unix-like 新的一行
     * Standardize line endings to unix-like.
     * @param string  UTF-8 encoding or 8-bit
     * @return string
     */
    public static function normalizeNewLines($s)
    {
        return str_replace(["\r\n", "\r"], "\n", $s);
    }
    /**
     * Truncates string to maximal length.
     * @param string  UTF-8 encoding
     * @param int
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function truncate($s, $maxLen, $append = "\xE2\x80\xA6")
    {
        if (self::length($s) > $maxLen) {
            $maxLen = $maxLen - self::length($append);
            if ($maxLen < 1) {
                return $append;
            } elseif ($matches = self::match($s, '#^.{1,' . $maxLen . '}(?=[\s\x00-/:-@\[-`{-~])#us')) {
                return $matches[0] . $append;
            } else {
                return self::substring($s, 0, $maxLen) . $append;
            }
        }
        return $s;
    }

    /**
     * Indents the content from the left.
     * @param string  UTF-8 encoding or 8-bit
     * @param int
     * @param string
     * @return string
     */
    public static function indent($s, $level = 1, $chars = "\t")
    {
        if ($level > 0) {
            $s = self::replace($s, '#(?:^|[\r\n]+)(?=[^\r\n])#', '$0' . str_repeat($chars, $level));
        }
        return $s;
    }

    /**
     * Convert to lower case.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function lower($s)
    {
        return mb_strtolower($s, 'UTF-8');
    }

    /**
     * Convert first character to lower case.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function firstLower($s)
    {
        return self::lower(self::substring($s, 0, 1)) . self::substring($s, 1);
    }

    /**
     * Convert to upper case.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function upper($s)
    {
        return mb_strtoupper($s, 'UTF-8');
    }

    /**
     * Convert first character to upper case.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function firstUpper($s)
    {
        return self::upper(self::substring($s, 0, 1)) . self::substring($s, 1);
    }

    /**
     * Capitalize string.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function capitalize($s)
    {
        return mb_convert_case($s, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Case-insensitive compares UTF-8 strings.
     * @param string
     * @param string
     * @param int
     * @return bool
     */
    public static function compare($left, $right, $len = null)
    {
        if ($len < 0) {
            $left = self::substring($left, $len, -$len);
            $right = self::substring($right, $len, -$len);
        } elseif ($len !== null) {
            $left = self::substring($left, 0, $len);
            $right = self::substring($right, 0, $len);
        }
        return self::lower($left) === self::lower($right);
    }

    /**
     * Finds the length of common prefix of strings.
     * @param string|array
     * @return string
     */
    public static function findPrefix(...$strings)
    {
        if (is_array($strings[0])) {
            $strings = $strings[0];
        }
        $first = array_shift($strings);
        for ($i = 0; $i < strlen($first); $i++) {
            foreach ($strings as $s) {
                if (!isset($s[$i]) || $first[$i] !== $s[$i]) {
                    while ($i && $first[$i - 1] >= "\x80" && $first[$i] >= "\x80" && $first[$i] < "\xC0") {
                        $i--;
                    }
                    return substr($first, 0, $i);
                }
            }
        }
        return $first;
    }

    /**
     * 返回支付长度 UTF-8
     * Returns number of characters (not bytes) in UTF-8 string.
     * That is the number of Unicode code points which may differ from the number of graphemes.
     * @param string
     * @return int
     */
    public static function length($s)
    {
        return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen(utf8_decode($s));
    }

    /**
     * Strips whitespace.
     * @param string  UTF-8 encoding
     * @param string
     * @return string
     */
    public static function trim($s, $charlist = self::TRIM_CHARACTERS)
    {
        $charlist = preg_quote($charlist, '#');
        return self::replace($s, '#^[' . $charlist . ']+|[' . $charlist . ']+\z#u', '');
    }

    /**
     * Pad a string to a certain length with another string.
     * @param string  UTF-8 encoding
     * @param int
     * @param string
     * @return string
     */
    public static function padLeft($s, $length, $pad = ' ')
    {
        $length = max(0, $length - self::length($s));
        $padLen = self::length($pad);
        return str_repeat($pad, (int)($length / $padLen)) . self::substring($pad, 0, $length % $padLen) . $s;
    }

    /**
     * Pad a string to a certain length with another string.
     * @param string  UTF-8 encoding
     * @param int
     * @param string
     * @return string
     */
    public static function padRight($s, $length, $pad = ' ')
    {
        $length = max(0, $length - self::length($s));
        $padLen = self::length($pad);
        return $s . str_repeat($pad, (int)($length / $padLen)) . self::substring($pad, 0, $length % $padLen);
    }

    /**
     * Reverse string.
     * @param string  UTF-8 encoding
     * @return string
     */
    public static function reverse($s)
    {
        return iconv('UTF-32LE', 'UTF-8', strrev(iconv('UTF-8', 'UTF-32BE', $s)));
    }

    /**
     * Use Nette\Utils\Random::generate
     * @deprecated
     */
    public static function random($length = 10, $charlist = '0-9a-z')
    {
        // TODO::
//        trigger_error(__METHOD__ . '() is deprecated, use Nette\Utils\Random::generate()', E_USER_DEPRECATED);
//        return Random::generate($length, $charlist);
    }

    /**
     * Returns part of $haystack before $nth occurence of $needle.
     * @param string
     * @param string
     * @param int  negative value means searching from the end
     * @return string|false  returns false if the needle was not found
     */
    public static function before($haystack, $needle, $nth = 1)
    {
        $pos = self::pos($haystack, $needle, $nth);
        return $pos === false
            ? false
            : substr($haystack, 0, $pos);
    }

    /**
     * Returns part of $haystack after $nth occurence of $needle.
     * @param string
     * @param string
     * @param int  negative value means searching from the end
     * @return string|false  returns false if the needle was not found
     */
    public static function after($haystack, $needle, $nth = 1)
    {
        $pos = self::pos($haystack, $needle, $nth);
        return $pos === false
            ? false
            : (string)substr($haystack, $pos + strlen($needle));
    }

    /**
     * Returns position of $nth occurence of $needle in $haystack.
     * @param string
     * @param string
     * @param int  negative value means searching from the end
     * @return int|false  offset in characters or false if the needle was not found
     */
    public static function indexOf($haystack, $needle, $nth = 1)
    {
        $pos = self::pos($haystack, $needle, $nth);
        return $pos === false
            ? false
            : self::length(substr($haystack, 0, $pos));
    }

    /**
     * Returns position of $nth occurence of $needle in $haystack.
     * @return int|false  offset in bytes or false if the needle was not found
     */
    private static function pos($haystack, $needle, $nth = 1)
    {
        if (!$nth) {
            return false;
        } elseif ($nth > 0) {
            if (strlen($needle) === 0) {
                return 0;
            }
            $pos = 0;
            while (($pos = strpos($haystack, $needle, $pos)) !== false && --$nth) {
                $pos++;
            }
        } else {
            $len = strlen($haystack);
            if (strlen($needle) === 0) {
                return $len;
            }
            $pos = $len - 1;
            while (($pos = strrpos($haystack, $needle, $pos - $len)) !== false && ++$nth) {
                $pos--;
            }
        }
        return $pos;
    }

    /**
     * Splits string by a regular expression.
     * @param string
     * @param string
     * @param int
     * @return array
     */
    public static function split($subject, $pattern, $flags = 0)
    {
        return self::pcre('preg_split', [$pattern, $subject, -1, $flags | PREG_SPLIT_DELIM_CAPTURE]);
    }

    /**
     * Performs a regular expression match.
     * @param string
     * @param string
     * @param int  can be PREG_OFFSET_CAPTURE (returned in bytes)
     * @param int  offset in bytes
     * @return mixed
     */
    public static function match($subject, $pattern, $flags = 0, $offset = 0)
    {
        if ($offset > strlen($subject)) {
            return null;
        }
        return self::pcre('preg_match', [$pattern, $subject, &$m, $flags, $offset])
            ? $m
            : null;
    }

    /**
     * Performs a global regular expression match.
     * @param string
     * @param string
     * @param int  can be PREG_OFFSET_CAPTURE (returned in bytes); PREG_SET_ORDER is default
     * @param int  offset in bytes
     * @return array
     */
    public static function matchAll($subject, $pattern, $flags = 0, $offset = 0)
    {
        if ($offset > strlen($subject)) {
            return [];
        }
        self::pcre('preg_match_all', [
            $pattern, $subject, &$m,
            ($flags & PREG_PATTERN_ORDER) ? $flags : ($flags | PREG_SET_ORDER),
            $offset,
        ]);
        return $m;
    }

    /**
     * Perform a regular expression search and replace.
     * @param string
     * @param string|array
     * @param string|callable
     * @param int
     * @return string
     */
    public static function replace($subject, $pattern, $replacement = null, $limit = -1)
    {
        if (is_object($replacement) || is_array($replacement)) {
            if ($replacement instanceof Nette\Callback) {
                trigger_error('Nette\Callback is deprecated, use PHP callback.', E_USER_DEPRECATED);
                $replacement = $replacement->getNative();
            }
            if (!is_callable($replacement, false, $textual)) {
                throw new Nette\InvalidStateException("Callback '$textual' is not callable.");
            }
            return self::pcre('preg_replace_callback', [$pattern, $replacement, $subject, $limit]);
        } elseif ($replacement === null && is_array($pattern)) {
            $replacement = array_values($pattern);
            $pattern = array_keys($pattern);
        }
        return self::pcre('preg_replace', [$pattern, $replacement, $subject, $limit]);
    }


}