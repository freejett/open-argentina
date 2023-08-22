<?php

namespace Tests\Feature;

use App\Models\ApartmentsData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApartsTest extends TestCase
{
    use RefreshDatabase;

    public function test_aparts_page_contain_empty_list_of_apartmens()
    {
        $response = $this->get('/aparts');

        $response->assertStatus(200);

        $response->assertSee(__('aparts.not_found'));
    }

    public function test_aparts_page_contain_none_empty_list_of_apartmens()
    {
        $apartment = ApartmentsData::factory()->create();

        $response = $this->get('/aparts');

        $response->assertStatus(200);
        $response->assertDontSee(__('aparts.not_found'));

        // проверяем, что переменная содержит не пустую коллекцию данных
        $response->assertViewHas('apartments', function ($collection) use ($apartment) {
            return $collection->contains($apartment);
        });
    }

    /**
     * Проверка пагинации
     * @return void
     */
    public function test_paginated_aparts_table_doesnt_contain_first_record()
    {
        $apartments = ApartmentsData::factory(31)->create();
        // сортировка в обратном порядке, поэтому смотрим первую запись
        $lastAparts = $apartments->first();

        $response = $this->get('/aparts');
        $response->assertStatus(200);
//        dd($response);
        // проверяем, что переменная содержит не пустую коллекцию данных
        $response->assertViewHas('apartments', function ($collection) use ($lastAparts) {
            return !$collection->contains($lastAparts);
        });
    }
}
