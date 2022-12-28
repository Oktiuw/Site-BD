<?php

namespace App\Factory;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Evenement>
 *
 * @method static Evenement|Proxy createOne(array $attributes = [])
 * @method static Evenement[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Evenement[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Evenement|Proxy find(object|array|mixed $criteria)
 * @method static Evenement|Proxy findOrCreate(array $attributes)
 * @method static Evenement|Proxy first(string $sortedField = 'id')
 * @method static Evenement|Proxy last(string $sortedField = 'id')
 * @method static Evenement|Proxy random(array $attributes = [])
 * @method static Evenement|Proxy randomOrCreate(array $attributes = [])
 * @method static Evenement[]|Proxy[] all()
 * @method static Evenement[]|Proxy[] findBy(array $attributes)
 * @method static Evenement[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Evenement[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EvenementRepository|RepositoryProxy repository()
 * @method Evenement|Proxy create(array|callable $attributes = [])
 */
final class EvenementFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'hDeb' =>  self::faker()->dateTime()->setTime(0, 0),
            'hFin' => self::faker()->dateTime()->setTime(2, 0),
            'dateEvmt' => self::faker()->dateTime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Evenement $evenement): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Evenement::class;
    }
}
