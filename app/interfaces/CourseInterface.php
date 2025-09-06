<?php

namespace App\Interfaces;

interface CourseInterface
{
    public function index();
    public function show($id);
    public function store($validated);
    public function edit($id);
    public function update($validated, $id);
    public function delete($id);
}
