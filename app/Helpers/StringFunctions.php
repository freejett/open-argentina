<?php

namespace App\Helpers;

class StringFunctions
{
    /**
     * Replace EOL to <br>
     * @param $str
     * @return string
     */
    public static function nl2br($str): string
    {
        return (string) str_replace(array("\r\n", "\r", "\n"), "<br>", $str);
    }

    /**
     * Очищает строку с указанием адреса от посторонних данных
     * и конвертирует все умляуты в английские аналоги
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanAddressStr ($str): array|string|null
    {
        $str = preg_replace('/[^\wa-zA-Z0-9.\- ]/ui', '', $str );
        return preg_replace('/[\x{0410}-\x{042F}]+.*[\x{0410}-\x{042F}]+/iu', '', $str);
    }

    /**
     * Оставляет в строке только цифры
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsStr ($str): array|string|null
    {
        return preg_replace('/[^0-9]/ui', '', $str );
    }

    /**
     * Оставляет в строке только цифры и точку
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsDotStr ($str): array|string|null
    {
        return preg_replace('/[^0-9.]/ui', '', $str );
    }

    /**
     * Оставляет в строке только цифры, точку и запятую
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsDotCommaStr ($str): array|string|null
    {
        return preg_replace('/[^0-9.,]/ui', '', $str );
    }

    /**
     * Оставляет в строке только цифры англ буквы
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsEngStr ($str): array|string|null
    {
        return trim(preg_replace("/[^A-Za-z0-9\/\s.]/ui", "", $str));
    }

    /**
     * Оставляет в строке только цифры англ и русские буквы
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsEngRuStr ($str): array|string|null
    {
        return trim(preg_replace("/[^A-Za-zА-ЯЁа-яё0-9\/\s=-]/ui", "", $str));
    }

    /**
     * Заменить умляуты на английские аналоги
     * @param $str
     * @return string
     */
    public static function clearUmlauts($str): string
    {
        return preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($str, ENT_COMPAT, 'UTF-8'));
    }

    /**
     * Заменить emoji на сущности
     * @param $str
     * @return array|string|string[]|null
     */
    public static function emojiToUnicode($str) {
        return preg_replace_callback(
            "%(?:\xF0[\x90-\xBF][\x80-\xBF]{2} | [\xF1-\xF3][\x80-\xBF]{3} | \xF4[\x80-\x8F][\x80-\xBF]{2})%xs",
            function($emoji){
                $emojiStr = mb_convert_encoding($emoji[0], 'UTF-32', 'UTF-8');
                return strtoupper(preg_replace("/^[0]+/","U+",bin2hex($emojiStr)));
            },
            $str
        );
    }
}
