<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels
| that your application supports.
|
*/

// Alumni listening to their own chat channel
Broadcast::channel('chat.alumni.{alumniID}', function ($user, $alumniID) {
    return auth('alumni')->check() && (int) $user->alumniID === (int) $alumniID;
});

// Admin listening to their own chat channel
Broadcast::channel('chat.admin.{adminID}', function ($user, $adminID) {
    return auth('admin')->check() && (int) $user->adminID === (int) $adminID;
});

