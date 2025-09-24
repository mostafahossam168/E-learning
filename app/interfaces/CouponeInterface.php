<?php

namespace App\Interfaces;

interface CouponeInterface
{
    public function index();
    public function create();
    public function show($id);
    public function store($validated);
    public function edit($id);
    public function update($validated, $id);
    public function delete($id);
}
