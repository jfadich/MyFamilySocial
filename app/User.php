<?php namespace MyFamily;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use MyFamily\Traits\Presentable;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, Presentable;

    protected $presenter = 'MyFamily\Presenters\User';

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


    /**
     * Get the role assigned to the user for access control
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
	{
		return $this->belongsTo('MyFamily\Role');
	}

    /**
     * Get all the comments the user has made
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function comments()
	{
		return $this->hasMany('MyFamily\Comment', 'owner_id', 'id');
    }

    /**
     * Get the users profile picture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile_picture()
    {
        return $this->belongsTo( 'MyFamily\Photo', 'profile_picture', 'id' );
    }

    /**
     * Get all the profile pictures the user has created
     *
     * @return mixed
     */
    public function profile_pictures()
    {
        return $this->morphMany( 'MyFamily\Photo', 'imageable' );
    }

    /**
     *  Get all the photos the user has uploaded
     */
    public function photos()
    {
        return $this->hasMany( 'MyFamily\Photo', 'owner_id' );
    }

    /**
     * Save a new photo to the profile pictures album then set current profile picture to given photo
     *
     * @param $photo
     */
    public function updateProfilePicture($photo)
    {
        $this->profile_pictures()->save( $photo );
        $this->profile_picture = $photo->id;
        $this->save();
    }

    /**
     * Birthdate mutator
     *
     * @param $date
     * @return static
     */
    public function setBirthdateAttribute($date)
    {
        return $this->attributes[ 'birthdate' ] = Carbon::createFromFormat( 'm/d/Y', $date );
    }

    /**
     * Return the actions that are to be dictated by role regardless of ownership
     */
    public function restrictedActions()
    {
        return ['AddUserRole'];
    }

}
