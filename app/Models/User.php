<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'display_role',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class, 'id_user');
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_user');
    }
    public function isAdministrateur()
    {
        return $this->hasRole('administrateur');
    }
   
    /**
     * Helper method to check if user is a Cuisinier
     */
    public function isCuisinier()
    {
        return $this->hasRole('cuisinier');
    }
   
    /**
     * Helper method to check if user is a Gestionnaire de Stock
     */
    public function isGestionnaireStock()
    {
        return $this->hasRole('gestionnaire_stock');
    }
   
    public function getDisplayRole()
    {
        if (!empty($this->display_role)) {
            return $this->display_role;
        }
        
       
        $role = $this->roles()->first();
        return $role ? $role->name : null;
    }
    
    public function updateDisplayRole()
    {
        $role = $this->roles()->first();
        if ($role) {
            $this->display_role = $role->name;
            $this->save();
        }
    }
    public function isFormateur()
    {
        return $this->hasRole('formateur');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}