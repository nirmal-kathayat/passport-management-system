<?php

namespace App\Repository;

use App\Models\Demand;

class DemandRepository
{
    private $query;
    public function __construct(Demand $query)
    {
        $this->query = $query;
    }

    public function get()
    {
        return $this->query
            ->leftJoin('experiences', 'experiences.id', 'demands.experience_id')
            ->leftJoin('countries', 'countries.id', 'demands.country_id')
            ->select('demands.*', 'experiences.experience', 'countries.title as country_name')
            ->orderBy('demands.date', 'desc');
    }
    public function storeDemand(array $data)
    {
        $query = [
            'date' => $data['date'],
            'title' => $data['title'],
            'salary' => $data['salary'],
            'comment' => $data['comment'],
            'experience_id' => $data['experience_id'],
            'country_id' => $data['country_id']
        ];
        return $this->query->create($query);
    }

    public function find($id)
    {
        return $this->query->findOrFail($id);
    }

    public function update(array $data, int $id)
    {
        $query = [
            'date' => $data['date'],
            'title' => $data['title'],
            'salary' => $data['salary'],
            'comment' => $data['comment'],
            'experience_id' => $data['experience_id'],
            'country_id' => $data['country_id']
        ];
        return $this->query->where('id', $id)->update($query);
    }

    public function delete($id)
    {
        return $this->query->where('id', $id)->delete($id);
    }
}
