<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define( MyFamily\User::class, function ( $faker ) {
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'email'          => $faker->email,
        'role_id'        => MyFamily\Role::orderBy( DB::raw( 'RAND()' ) )->first()->id,
        'password'       => Hash::Make( 'secret' ),
        'phone_one'      => $faker->phoneNumber,
        'phone_two'      => $faker->boolean( 50 ) ? $faker->phoneNumber : '',
        'street_address' => $faker->streetAddress,
        'city'           => $faker->city,
        'state'          => $faker->state,
        'zip_code'       => $faker->postcode,
        'birthdate'      => $faker->dateTimeBetween( '-70 years', 'now' )->format( 'm/d/Y' ),
        'website'        => $faker->boolean( 33 ) ? $faker->domainName() : ''
    ];
} );

$factory->define( MyFamily\ForumThread::class, function ( $faker ) {
    return [
        'title'       => $faker->sentence( $faker->numberBetween( 5, 15 ) ),
        'body'        => $faker->text( $faker->numberBetween( 100, 2000 ) ),
        'owner_id'    => MyFamily\User::orderBy( DB::raw( 'RAND()' ) )->first()->id,
        'category_id' => MyFamily\ForumCategory::orderBy( DB::raw( 'RAND()' ) )->first()->id,
    ];
} );

$factory->define( MyFamily\Album::class, function ( $faker ) {
    return [
        'name'        => $faker->sentence( $faker->numberBetween( 1, 5 ) ),
        'description' => $faker->paragraph(),
        'shared'      => $faker->boolean( 70 ),
        'owner_id'    => MyFamily\User::orderBy( DB::raw( 'RAND()' ) )->first()->id
    ];
} );

$factory->define( MyFamily\Comment::class, function ( $faker ) {
    return [
        'body'     => $faker->text( $faker->numberBetween( 14, 400 ) ),
        'owner_id' => MyFamily\User::orderBy( DB::raw( 'RAND()' ) )->first()->id
    ];
} );

$used_names = [ ];
$factory->define( MyFamily\Tag::class, function ( $faker ) use ( &$used_names ) {

    do {
        $tag = $faker->word();
    } while ( in_array( $tag, $used_names ) );

    $used_names[ ] = $tag;

    return [
        'name'        => $tag,
        'description' => $faker->paragraph()
    ];
} );