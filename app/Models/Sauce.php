<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sauce extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'name',
        'manufacturer',
        'description',
        'mainPepper',
        'imageUrl',
        'heat',
        'likes',
        'dislikes',
        'usersLiked',
        'usersDisliked'
    ];

    protected $casts = [
        'usersLiked' => 'json',
        'usersDisliked' => 'json'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Check if the sauce is liked by the given user.
     *
     * @param  User  $user
     * @return bool
     */
    public function isLikedBy(User $user)
    {
        return in_array($user->id, $this->usersLiked ?? []);
    }
    /**
     * Add a like to the sauce for the given user.
     *
     * @param  User  $user
     * @return bool
     */
    public function like(User $user)
    {
        // Check if the user has already liked the sauce
        if ($this->isLikedBy($user)) {
            return false;
        }

        // Add the user's ID to the list of users who liked the sauce
        $this->usersLiked = collect($this->usersLiked)->push($user->id)->toArray();

        // Increment the number of likes
        $this->likes++;

        // Save the changes to the database
        return $this->save();
    }


}
