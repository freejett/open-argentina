<?php

namespace App\Helpers;

class StringFunctions
{
    /**
     * Replace EOL to <br>
     * @param $str
     * @return string
     */
    public static function nl2br($str)
    {
        return (string) str_replace(array("\r\n", "\r", "\n"), "<br>", $str);
    }

    /**
     * Очищает строку с указанием адреса от посторонних данных
     * и конвертирует все умляуты в английские аналоги
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanAddressStr ($str) {
        $str = preg_replace('/[^\wa-zA-Z0-9.\- ]/ui', '', $str );
        return preg_replace('/[\x{0410}-\x{042F}]+.*[\x{0410}-\x{042F}]+/iu', '', $str);
    }

    /**
     * Оставляет в строке только цифры
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsStr ($str) {
        return preg_replace('/[^0-9]/ui', '', $str );
    }

    /**
     * Оставляет в строке только цифры и точку
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsDotStr ($str) {
        return preg_replace('/[^0-9.]/ui', '', $str );
    }

    /**
     * Оставляет в строке только цифры англ буквы
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsEngStr ($str) {
        return trim(preg_replace("/[^A-Za-z0-9\/\s.]/", "", $str));
    }

    /**
     * Оставляет в строке только цифры англ и русские буквы
     * @param $str
     * @return array|string|string[]|null
     */
    public static function cleanDigitsEngRuStr ($str) {
        return trim(preg_replace("/[^A-Za-zА-ЯЁа-яё0-9\/\s=-]/ui", "", $str));
    }

    /**
     * Заменить умляуты на английские аналоги
     * @param $str
     * @return string
     */
    public static function clearUmlauts($str)
    {
        return preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($str, ENT_COMPAT, 'UTF-8'));
    }
}
