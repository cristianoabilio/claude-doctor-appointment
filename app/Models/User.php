<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

#[Fillable(['name', 'email', 'phone', 'photo', 'password', 'google2fa_secret', 'google2fa_enabled'])]
#[Hidden(['password', 'remember_token', 'google2fa_secret'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            //'google2fa_enabled' => 'boolean'
        ];
    }

    /**
     * Criptografa a chave secreta ao salvar no banco.
     */
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Descriptografa a chave secreta ao recuperar do banco.
     */
    public function getGoogle2faSecretAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }
}
