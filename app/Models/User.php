<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTSubject as JWTSubjectContract;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
<<<<<<< HEAD
    protected $fillable = [
        'FullName',
        'Email',
        'Password',
        'Phone',
        'NationalID',
        'DocURL',
        'EmailNotifications',
        'insurranceNo',
        'TermsAndConditions'
    ];

=======
         protected $fillable = [
         'fullName',
         'email',
         'password',
         'phone',
         'nationalID',
         'docURL',
         'emailNotifications',
         'insurranceNo',
         'termsAndConditions',
     ];
>>>>>>> 8a36f9d81d66907f439354fbd5981cb1a5e0fc0d
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
            'EmailNotifications' => 'boolean',
            'TermsAndConditions' => 'boolean',
            'NationalID' => 'integer',
            'insuranceNo' => 'integer',
        ];
    }
     
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function requests()
    {
        return $this->hasMany(\App\Models\Request::class);
    }
}

