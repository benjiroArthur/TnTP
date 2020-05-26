<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Address
 *
 * @property int $id
 * @property string $region
 * @property string $city
 * @property string $gp_digital_address
 * @property int $addressable_id
 * @property string $addressable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereGpDigitalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App{
/**
 * App\Admin
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $other_name
 * @property string $email
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $phone_number
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $full_name
 * @property-read mixed $registered
 * @property-read mixed $updated
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App{
/**
 * App\Booking
 *
 * @property int $id
 * @property string $booking_code
 * @property int $room_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Room $room
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereBookingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUserId($value)
 */
	class Booking extends \Eloquent {}
}

namespace App{
/**
 * App\CheckList
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $trip_id
 * @property-read \App\Trip $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CheckList whereUpdatedAt($value)
 */
	class CheckList extends \Eloquent {}
}

namespace App{
/**
 * App\Hotel
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read mixed $first_name
 * @property-read mixed $full_name
 * @property-read mixed $registered
 * @property-read mixed $updated
 * @property-read \App\Map|null $map
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Room[] $rooms
 * @property-read int|null $rooms_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Hotel whereUpdatedAt($value)
 */
	class Hotel extends \Eloquent {}
}

namespace App{
/**
 * App\HotelCode
 *
 * @property int $id
 * @property int $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HotelCode whereUpdatedAt($value)
 */
	class HotelCode extends \Eloquent {}
}

namespace App{
/**
 * App\Image
 *
 * @property int $id
 * @property string $name
 * @property int $imageable_id
 * @property string $imageable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @property-read mixed $name_path
 * @property-read mixed $source
 * @property-read mixed $thumbnail
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App{
/**
 * App\Map
 *
 * @property int $id
 * @property float $lat
 * @property float $long
 * @property int $mappable_id
 * @property string $mappable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $mappable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereMappableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereMappableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Map whereUpdatedAt($value)
 */
	class Map extends \Eloquent {}
}

namespace App{
/**
 * App\Region
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\City[] $city
 * @property-read int|null $city_count
 * @property-read mixed $url_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TouristSite[] $tourists
 * @property-read int|null $tourists_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Region whereUpdatedAt($value)
 */
	class Region extends \Eloquent {}
}

namespace App{
/**
 * App\Review
 *
 * @property int $id
 * @property int $user_id
 * @property int $reviewable_id
 * @property string $reviewable_type
 * @property int $rating
 * @property int $like
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reviewable
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereReviewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereReviewableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Room
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $room_number
 * @property float $price
 * @property string $status
 * @property string|null $description
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read mixed $source
 * @property-read mixed $thumbnail
 * @property-read \App\Hotel $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Image[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUpdatedAt($value)
 */
	class Room extends \Eloquent {}
}

namespace App{
/**
 * App\Transport
 *
 * @property int $id
 * @property string|null $vehicle_number
 * @property string|null $vehicle_brand
 * @property string|null $colour
 * @property string $last_name
 * @property string $first_name
 * @property string|null $other_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $image
 * @property string $full_name
 * @property string|null $phone_number
 * @property-read mixed $registered
 * @property-read mixed $updated
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereVehicleBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transport whereVehicleNumber($value)
 */
	class Transport extends \Eloquent {}
}

namespace App{
/**
 * App\Traveller
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $other_name
 * @property string $email
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $phone_number
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $registered
 * @property-read mixed $updated
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Traveller whereUpdatedAt($value)
 */
	class Traveller extends \Eloquent {}
}

namespace App{
/**
 * App\Trip
 *
 * @property int $id
 * @property string $name
 * @property int $tourist_site_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activitiy[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CheckList[] $checklist
 * @property-read int|null $checklist_count
 * @property-read \App\TouristSite $touristSite
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTouristSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereUserId($value)
 */
	class Trip extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $role_id
 * @property int $userable_id
 * @property string $userable_type
 * @property int $profile_updated
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $trips
 * @property-read int|null $trips_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $userable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfileUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserableType($value)
 */
	class User extends \Eloquent {}
}

