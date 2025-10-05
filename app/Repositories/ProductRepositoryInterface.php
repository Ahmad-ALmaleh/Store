<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAll(array $filters = []);
    public function findById($id);
    public function create(array $data);
    public function update($id,  $data);
    public function delete($id);
}
