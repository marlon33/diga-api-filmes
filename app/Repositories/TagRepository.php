<?php

namespace App\Repositories;

use Exception;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Token\Token;
use Illuminate\Support\Facades\DB;

class TagRepository
{
    protected $entity;

    public function __construct(Tag $model)
    {
        $this->entity = $model;
    }

    public function store(
        string $name
    ) {
        try {
            DB::beginTransaction();
            $this->entity->create([
                'name' => $name
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Tag created with success!',
                'status' => 200
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 401
            ]);
        }
    }
}
