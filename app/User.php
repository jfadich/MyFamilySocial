<?php namespace MyFamily;

use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * The attributes that should be treated as dates and will return Carbon instances
     *
     * @var array
     */
    protected $dates = ['birthdate'];
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at', 'profile_picture'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function role()
	{
		return $this->belongsTo('MyFamily\Role');
	}

	public function comments()
	{
		return $this->hasMany('MyFamily\Comment', 'owner_id', 'id');
    }

    /**
     * Format the birthdate for display
     */
    public function getBirthdayAttribute()
    {
        // TODO Create user option to hide year
        // if($hideYear) $format = 'F jS';

        $format = 'F jS o';

        if ($this->birthdate != null) {
            return $this->birthdate->format( $format );
        }

        return null;
    }

    protected function asDateTime($value)
    {
        if ($value == '0000-00-00 00:00:00') {
            return null;
        }

        return parent::asDateTime( $value );
    }
}
