<?php

namespace App\Repository;

use App\Models\Client;
use App\Repository\Shared\Repository;
use Illuminate\Support\Facades\Storage;

class ClientRepository extends Repository
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    public function beforeCreate(&$data)
    {
        $data['user_id'] = auth()->user()->getAuthIdentifier();
    }

    public function afterCreate($client, $data)
    {
        if (request()->hasFile('profile_picture')) {
            $client->update([
                'profile_picture' => request()->storeFile('profile_picture', '/clients/' . $client->id),
            ]);
        }
    }

    public function beforeUpdate($client, &$data)
    {
        if (request()->hasFile('profile_picture')) {
            Storage::disk('public')->delete($client->profilePicture);

            $client->update([
                'profile_picture' => request()->storeFile('profile_picture', '/clients/' . $client->id),
            ]);

            unset($data['profile_picture']);
        }

        unset($data['user_id']);
    }


    public function beforeDelete($client)
    {
        if (empty($client->profilePicture)) {
            return;
        }

        Storage::disk('public')->delete($client->profilePicture);
    }
}
