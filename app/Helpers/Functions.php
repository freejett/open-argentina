<?php

namespace App\Helpers;

class Functions
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
     * и конвертирует все умлуты в английские аналоги
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
}
