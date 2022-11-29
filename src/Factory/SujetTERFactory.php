<?php

namespace App\Factory;

use App\Entity\SujetTER;
use App\Repository\SujetTERRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<SujetTER>
 *
 * @method static SujetTER|Proxy createOne(array $attributes = [])
 * @method static SujetTER[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static SujetTER[]|Proxy[] createSequence(array|callable $sequence)
 * @method static SujetTER|Proxy find(object|array|mixed $criteria)
 * @method static SujetTER|Proxy findOrCreate(array $attributes)
 * @method static SujetTER|Proxy first(string $sortedField = 'id')
 * @method static SujetTER|Proxy last(string $sortedField = 'id')
 * @method static SujetTER|Proxy random(array $attributes = [])
 * @method static SujetTER|Proxy randomOrCreate(array $attributes = [])
 * @method static SujetTER[]|Proxy[] all()
 * @method static SujetTER[]|Proxy[] findBy(array $attributes)
 * @method static SujetTER[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static SujetTER[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SujetTERRepository|RepositoryProxy repository()
 * @method SujetTER|Proxy create(array|callable $attributes = [])
 */
final class SujetTERFactory extends ModelFactory
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
            'titreTer' => self::faker()->words(random_int(3, 10), true),
            'descTer' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(SujetTER $sujetTER): void {})
        ;
    }

    protected static function getClass(): string
    {
        return SujetTER::class;
    }
}
