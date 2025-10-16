<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('room_online', function ($user) {
    // if ($user->type->value == 'admin') {
    return $user;
    // }
});