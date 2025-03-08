<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AdditionalService
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $as_id
 * @property-read \App\Models\AdditionalServiceName|null $additionalServiceName
 * @property-read \App\Models\Profile|null $profile
 * @method static \Database\Factories\AdditionalServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereAsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereProfileId($value)
 */
	class AdditionalService extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdditionalServiceName
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @method static \Database\Factories\AdditionalServiceNameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName whereName($value)
 */
	class AdditionalServiceName extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AggSpecialization
 *
 * @property int $contact_id
 * @property int $type
 * @property array $attribute
 * @property-read \App\Models\Contact|null $contact
 * @method static \Database\Factories\AggSpecializationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization query()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereType($value)
 */
	class AggSpecialization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Album
 *
 * @property int $id
 * @property int $contact_id
 * @property int $type
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @method static \Database\Factories\AlbumFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Album filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Album whereUpdatedAt($value)
 */
	class Album extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $user_id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\File|null $banner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Article defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ArticleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Article filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Article filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Article filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Article filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Article withoutTrashed()
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property int $country_id
 * @property string $alias
 * @property array $name
 * @property int $has_metro
 * @property int $show_in_filter
 * @property int $population
 * @property float|null $lat
 * @property float|null $lon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Metro[] $metro
 * @property-read int|null $metro_count
 * @method static \Illuminate\Database\Eloquent\Builder|City defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|City filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|City filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|City filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereHasMetro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereShowInFilter($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contact
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int $metro_id
 * @property string $alias
 * @property string $name
 * @property string|null $description
 * @property string $address
 * @property string $phone
 * @property string $site
 * @property string $email
 * @property string $district
 * @property float|null $lat
 * @property float|null $lon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Album[] $albums
 * @property-read int|null $albums_count
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\File|null $cover
 * @property-read \App\Models\Metro|null $metro
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalonDistance[] $salonDistances
 * @property-read int|null $salon_distances_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Contact[] $siblings
 * @property-read int|null $siblings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @property-read \App\Models\AggSpecialization|null $specialization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkingHours[] $workingHours
 * @property-read int|null $working_hours_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contact defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ContactFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMetroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $iso
 * @property array $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CountryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Country filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Country filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Country filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\Dictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereType($value)
 */
	class Dictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\GenderDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\GenderDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereType($value)
 */
	class GenderDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\PiercingHealingPeriodDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\PiercingHealingPeriodDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereType($value)
 */
	class PiercingHealingPeriodDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\PiercingPainLevelDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\PiercingPainLevelDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereType($value)
 */
	class PiercingPainLevelDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\PiercingPlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\PiercingPlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereType($value)
 */
	class PiercingPlaceDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\ServiceOtherDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\ServiceOtherDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereType($value)
 */
	class ServiceOtherDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\ServicePiercingDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\ServicePiercingDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereType($value)
 */
	class ServicePiercingDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\ServiceTattooDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\ServiceTattooDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereType($value)
 */
	class ServiceTattooDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\ServiceTatuajeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\ServiceTatuajeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereType($value)
 */
	class ServiceTatuajeDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\TattooPlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\TattooPlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereType($value)
 */
	class TattooPlaceDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\TattooSizeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\TattooSizeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereType($value)
 */
	class TattooSizeDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\TattooStyleDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\TattooStyleDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereType($value)
 */
	class TattooStyleDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\TattooTempTypeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\TattooTempTypeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereType($value)
 */
	class TattooTempTypeDictionary extends \Eloquent {}
}

namespace App\Models\Dictionaries{
/**
 * App\Models\Dictionaries\TatuajePlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 * @method static \Database\Factories\Dictionaries\TatuajePlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereType($value)
 */
	class TatuajePlaceDictionary extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feedback
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FeedbackFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 */
	class Feedback extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\File
 *
 * @property int $id
 * @property int $user_id
 * @property string $fileable_type
 * @property int $fileable_id
 * @property int $fileable_subtype
 * @property string $original
 * @property array $thumbs
 * @property int $size
 * @property string $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Album|null $album
 * @property-read \App\Models\FileInfo|null $fileInfo
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $fileable
 * @property-read string|null $url
 * @method static \Database\Factories\FileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|File filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Query\Builder|File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereThumbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|File withoutTrashed()
 */
	class File extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FileInfo
 *
 * @property int $id
 * @property int $file_id
 * @property string $name
 * @property string $description
 * @property array $attribute
 * @property int $is_downloadable
 * @property int $is_adult
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\File|null $file
 * @method static \Database\Factories\FileInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereIsDownloadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileInfo whereUpdatedAt($value)
 */
	class FileInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LineMetro
 *
 * @property int $id
 * @property array $name
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Metro[] $metro
 * @property-read int|null $metro_count
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\LineMetroFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro query()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereName($value)
 */
	class LineMetro extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Metro
 *
 * @property int $id
 * @property int $city_id
 * @property int $line_id
 * @property array $name
 * @property float|null $lat
 * @property float|null $lon
 * @property int $position
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\LineMetro|null $line
 * @method static \Illuminate\Database\Eloquent\Builder|Metro defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\MetroFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro wherePosition($value)
 */
	class Metro extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $approved
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @property-read \App\Models\File|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\File|null $cover
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @method static \Database\Factories\ProfileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $contact_id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $type
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|Review defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ReviewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Review filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SalonDistance
 *
 * @property int $salon_id
 * @property int $salon_nearby_id
 * @property int $distance in meters
 * @property-read \App\Models\Contact|null $salon
 * @property-read \App\Models\Contact|null $salonNearby
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance whereSalonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonDistance whereSalonNearbyId($value)
 */
	class SalonDistance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Service
 *
 * @property int $id
 * @property int $profile_id
 * @property string $name
 * @property int $type
 * @property string $price
 * @property string $currency
 * @property int $is_start_price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $contact_id
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\Profile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Service defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Service filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsStartPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialNetwork
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $sn_id
 * @property string $value
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Profile|null $profile
 * @property-read \App\Models\SocialNetworkName|null $socialNetworkName
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\SocialNetworkFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereSnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereValue($value)
 */
	class SocialNetwork extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialNetworkName
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $url
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @method static \Database\Factories\SocialNetworkNameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereUrl($value)
 */
	class SocialNetworkName extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SuspendedUser
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property string|null $reason
 * @property int $status
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\SuspendedUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereUserId($value)
 */
	class SuspendedUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property int $role
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orchid\Platform\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuspendedUser[] $suspendedUsers
 * @property-read int|null $suspended_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDeclaredCity[] $userDeclaredCities
 * @property-read int|null $user_declared_cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|User averageByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAccess(string $permitWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAnyAccess($permitsWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User countByDays($startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User countForGroup(string $groupColumn)
 * @method static \Illuminate\Database\Eloquent\Builder|User defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|User filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|User maxByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User minByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sumByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User valuesByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UserDeclaredCity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\UserDeclaredCityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereUserId($value)
 */
	class UserDeclaredCity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Video
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property string $url
 * @property string|null $preview
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\File|null $cover
 * @property-read \App\Models\Profile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Video defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\VideoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Video filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 */
	class Video extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WorkingHours
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $day
 * @property string|null $start
 * @property string|null $end
 * @property int $is_weekend
 * @property int $is_nonstop
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\WorkingHoursFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereIsNonstop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereIsWeekend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereUpdatedAt($value)
 */
	class WorkingHours extends \Eloquent {}
}

