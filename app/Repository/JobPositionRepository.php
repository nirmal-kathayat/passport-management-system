<?php

namespace App\Repository;

use App\Models\JobPosition;

class JobPositionRepository
{
    private $query;
    public function __construct(JobPosition $query)
    {
        $this->query = $query;
    }

    public function dataTable()
    {
        return $this->query->get();
    }
    public function storePosition(array $data)
    {
        $query = [
            'title' => $data['title'],
            'description' => $data['description']
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
            'title' => $data['title'],
            'description' => $data['description']
        ];
        return $this->query->where('id', $id)->update($query);
    }

    public function delete($id)
    {
        return $this->query->where('id', $id)->delete($id);
    }
}
