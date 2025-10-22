<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'vendor_id',
        'name',
        'surname',
        'mobile_number',
        'email',
        'password',
        'status',
        'avatar',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification(){
        $this->notify(new CustomVerifyEmail);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function dealer(){
        return $this->hasOne(Dealer::class);
    }

    public function wishList(){
        return $this->hasMany(WishList::class);
    }

    public function whilist_item($id){
        return $this->wishList->where('product_id', $id)->first();
    }

    public function wallet_total(){
        return 0;
    }
}
