<?php

namespace App\Interfaces;

interface ContactInterface
{
    public function index();
    public function delete($id);
}