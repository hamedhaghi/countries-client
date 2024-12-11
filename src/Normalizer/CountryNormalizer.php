<?php

declare(strict_types=1);

namespace Hamed\Countries\Normalizer;

use Hamed\Countries\Model\CapitalInfo;
use Hamed\Countries\Model\Car;
use Hamed\Countries\Model\Country;
use Hamed\Countries\Model\Currency;
use Hamed\Countries\Model\Demonym;
use Hamed\Countries\Model\Flag;
use Hamed\Countries\Model\IDD;
use Hamed\Countries\Model\Language;
use Hamed\Countries\Model\Map;
use Hamed\Countries\Model\Name;
use Hamed\Countries\Model\NativeName;
use Hamed\Countries\Model\Translation;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CountryNormalizer implements DenormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return Country::class === $type;
    }

    public function denormalize($data, $type, $format = null, array $context = []): Country
    {
        $nativeNames = [];
        foreach ($data['name']['nativeName'] ?? [] as $key => $nativeName) {
            $nativeNames[$key] = new NativeName(
                $nativeName['common'] ?? '',
                $nativeName['official'] ?? ''
            );
        }

        $name = new Name(
            $data['name']['common'] ?? '',
            $data['name']['official'] ?? '',
            $nativeNames
        );

        $currencies = [];
        foreach ($data['currencies'] ?? [] as $key => $currency) {
            $currencies[$key] = new Currency(
                $currency['name'] ?? '',
                $currency['symbol'] ?? ''
            );
        }

        $idd = new IDD(
            $data['idd']['root'] ?? '',
            $data['idd']['suffixes'] ?? []
        );

        $languages = [];
        foreach ($data['languages'] ?? [] as $key => $language) {
            $languages[$key] = new Language(
                $language ?? ''
            );
        }

        $translations = [];
        foreach ($data['translations'] ?? [] as $key => $translation) {
            $translations[$key] = new Translation(
                $translation['common'] ?? '',
                $translation['official'] ?? ''
            );
        }

        $demonyms = [];
        foreach ($data['demonyms'] ?? [] as $key => $demonyms) {
            $demonyms[$key] = new Demonym(
                $demonyms['f'] ?? '',
                $demonyms['m'] ?? ''
            );
        }

        $maps = new Map(
            $data['maps']['googleMaps'] ?? '',
            $data['maps']['openStreetMaps'] ?? ''
        );

        $car = new Car(
            $data['car']['signs'] ?? [],
            $data['car']['side'] ?? ''
        );

        $flags = new Flag(
            $data['flags']['png'] ?? '',
            $data['flags']['svg'] ?? '',
            $data['flags']['alt'] ?? ''
        );

        $capitalInfo = new CapitalInfo(
            $data['capitalInfo']['latlng'] ?? []
        );

        return new Country(
            $name,
            $data['tld'] ?? [],
            $data['cca2'] ?? '',
            $data['ccn3'] ?? '',
            $data['cca3'] ?? '',
            $data['independent'] ?? false,
            $data['status'] ?? '',
            $data['unMember'] ?? false,
            $currencies,
            $idd,
            $data['capital'] ?? [],
            $data['altSpellings'] ?? [],
            $data['region'] ?? '',
            $data['subregion'] ?? '',
            $languages,
            $translations,
            $data['latlng'] ?? [],
            $data['landlocked'] ?? false,
            $data['area'] ?? 0,
            $demonyms,
            $data['flag'] ?? '',
            $maps,
            $data['population'] ?? 0,
            $car,
            $data['timezones'] ?? [],
            $data['continents'] ?? [],
            $flags,
            $data['coatOfArms'],
            $data['startOfWeek'] ?? '',
            $capitalInfo
        );
    }
}
