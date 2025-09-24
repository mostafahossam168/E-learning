<?php

namespace App\Repositories;

use App\Interfaces\ContactInterface;
use App\Models\Contact;

class ContactInterfaceRepository implements ContactInterface
{
    public function index()
    {
        $search = request('search');
        return Contact::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        })->latest()->paginate(30);
    }
    public function delete($id)
    {
        $item = Contact::findOrFail($id);
        $item->delete();
    }
}