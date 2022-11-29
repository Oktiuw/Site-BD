<?php

namespace App\Factory;

use App\Entity\TypeEvenement;
use App\Repository\TypeEvenementRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<TypeEvenement>
 *
 * @method static TypeEvenement|Proxy createOne(array $attributes = [])
 * @method static TypeEvenement[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TypeEvenement[]|Proxy[] createSequence(array|callable $sequence)
 * @method static TypeEvenement|Proxy find(object|array|mixed $criteria)
 * @method static TypeEvenement|Proxy findOrCreate(array $attributes)
 * @method static TypeEvenement|Proxy first(string $sortedField = 'id')
 * @method static TypeEvenement|Proxy last(string $sortedField = 'id')
 * @method static TypeEvenement|Proxy random(array $attributes = [])
 * @method static TypeEvenement|Proxy randomOrCreate(array $attributes = [])
 * @method static TypeEvenement[]|Proxy[] all()
 * @method static TypeEvenement[]|Proxy[] findBy(array $attributes)
 * @method static TypeEvenement[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static TypeEvenement[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TypeEvenementRepository|RepositoryProxy repository()
 * @method TypeEvenement|Proxy create(array|callable $attributes = [])
 */
final class TypeEvenementFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'intTpEvmt' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(TypeEvenementFixtures $typeEvenement): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TypeEvenement::class;
    }
}
