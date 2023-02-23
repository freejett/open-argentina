<?php

namespace App\Parsers\Exchange;

interface MoneyExchangeInterface
{
    /**
     * Парсер данных. Основная функция
     * @param int $chatId
     * @return void
     */
    public function parse(int $chatId): void;

    /**
     * Поиск даты актуального курса
     * @param array $msgStrings
     * @return string
     */
    public function getDate(array $msgStrings): string;

    /**
     * Поиск обменного курса для каждого варианта обмена
     * @param array $msgStrings
     * @return array|null
     */
    public function getRate(array $msgStrings): array|null;
}