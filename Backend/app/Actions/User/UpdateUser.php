<?php

namespace App\Actions\User;

class UpdateUser
{
    public function execute()
    {
        return response()->json([
            'message' => "Hello everyone"
        ]);
    }
}
