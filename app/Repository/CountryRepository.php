<?php
namespace App\Repository;

use App\Models\Country;

class CountryRepository{
  private $query;
  public function __construct(Country $query)
  {
    $this->query = $query;
  }
}