<?php

namespace App\Contracts;

interface UserInterface
{
    public function fetchData();
    public function saveData(array $data);
}
