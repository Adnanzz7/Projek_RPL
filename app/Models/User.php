<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'about',
        'birth_date',
        'foto',
        'kode_pendaftaran',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
                \Storage::disk('public')->delete($user->foto);
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    
    public function wishlist()
    {
        return $this->belongsToMany(Barang::class, 'wishlists', 'user_id', 'barang_id');
    }
}
