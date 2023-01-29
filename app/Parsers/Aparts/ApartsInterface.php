<?php

namespace App\Parsers\Aparts;

interface ApartsInterface
{
    /**
     * Парсер данных. Основная функция
     * @param int $chatId
     * @return void
     */
    public function parse(int $chatId): void;

    /**
     * Поиск адреса в сообщении
     * @param array $msgStrings
     * @return array
     */
    public function getAddress(array $msgStrings): array;

    /**
     * Поиск стоимости в сообщении
     * @param array $msgStrings
     * @return array
     */
    public function getCost(array $msgStrings): array;

    /**
     * Поиск заголовка квартиры
     * @param array $msgStrings
     * @return string
     */
    public function getTitle(array $msgStrings): string;
}