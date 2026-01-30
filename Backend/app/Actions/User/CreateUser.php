<?php

namespace App\Actions\User;

class CreateUser
{
    public function execute()
    {
        return response()->json([
            'message' => "Hello everyone"
        ]);
    }
}
