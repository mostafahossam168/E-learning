<?php

namespace App\Interfaces;

interface ReviewInterface
{
    public function index();
    public function update($id, $data);
}
