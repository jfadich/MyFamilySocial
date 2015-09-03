<?php namespace MyFamily;

use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\Authenticatable;
use MyFamily\Traits\JsonSettings;
use MyFamily\Traits\Presentable;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, Presentable, JsonSettings;

    protected static $recordEvents = ['updated'];

    protected $presenter = 'MyFamily\Presenters\User';

    /**
     * Json field to be used by the settings trait
     *
     * @var string
     */
    protected $json_field = 'privacy';

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
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_one',
        'phone_two',
        'street_address',
        'city',
        'state',
        'zip_code',
        'birthdate',
        'website'
    ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    /**
     * Data types to cast each attribute
     *
     * @var array
     */
    protected $casts = [ 'privacy' => 'json' ];


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
     * Get the permissions from the users role
     *
     */
    public function permissions()
    {
        return $this->role->permissions();
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

    public function albums()
    {
        return $this->hasMany( 'MyFamily\Album', 'owner_id' );
    }

    public function activity()
    {
        return $this->hasMany( 'MyFamily\Activity', 'owner_id' )->latest();
    }

    public function tagged_photos()
    {
        return $this->belongsToMany( 'MyFamily\Photo' );
    }

    /**
     * Save a new photo to the profile pictures album then set current profile picture to given photo
     *
     * @param $photo
     */
    public function updateProfilePicture($photo)
    {
        $this->profile_picture = $photo->id;
        $this->profile_pictures()->save( $photo );
        $this->tagged_photos()->save( $photo );
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
        if ( $date == null ) {
            return null;
        }

        return $this->attributes[ 'birthdate' ] = Carbon::createFromFormat( 'm/d/Y', $date );
    }

    /**
     * Return the actions that are to be dictated by role regardless of ownership
     */
    public function restrictedActions()
    {
        return [ 'EditUserRole' ];
    }
}
