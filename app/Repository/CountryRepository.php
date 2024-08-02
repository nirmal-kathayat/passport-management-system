<?php

namespace App\Repository;

use App\Models\Country;

class CountryRepository
{
    private $query;
    public function __construct(Country $query)
    {
        $this->query = $query;
    }

    public function getCountry()
    {
        $query = $this->query;
        $query =    $query
            ->select('id', 'title', 'created_at')
            ->orderBy('title', 'asc')
            ->get();
        return $query;
    }
    public function dataTable()
    {
        return $this->query
            ->query()
            ->leftJoin('continents', 'continents.id', '=', 'countries.continent_id')
            ->select('countries.id', 'countries.title', 'continents.title as continent_title', 'countries.created_at')
            ->orderBy('countries.title', 'asc');
    }
    public function storeCountries(array $data)
    {
        $query = [
            'continent_id' => $data['continent_id'],
            'title' => $data['title'],
        ];
        return $this->query->create($query);
    }

    public function find($id)
    {
        return $this->query->findOrFail($id);
    }

    public function updateCountry(array $data, int $id)
    {
        $query = [
            'continent_id' => $data['continent_id'],
            'title' => $data['title']
        ];
        return $this->query->where('id', $id)->update($query);
    }
    public function delete($id)
    {
        return $this->query->where('id', $id)->delete($id);
    }
}
