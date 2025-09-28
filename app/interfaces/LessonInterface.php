<?php

namespace App\Interfaces;

interface LessonInterface
{
    public function index();
    public function show($id);
    public function store($validated);
    public function edit($id);
    public function update($validated, $id);
    public function delete($id);
    public function getCourses();
}
