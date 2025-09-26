<?php

namespace App\Interfaces;

interface TeacherInterface
{
    public function index();
    public function show($id);
    public function store($validated);
    public function update($validated, $id);
    public function delete($id);
    public function getRoles();
}
