<?php

namespace App\interfaces;

interface AdminInterface
{
    public function index();
    public function show($id);
    public function create();
    public function store($validated);
    public function update($validated, $id);
    public function delete($id);
}