<?php

namespace App\Factory;

use App\Entity\Roles;
use App\Repository\RolesRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Roles>
 *
 * @method static Roles|Proxy createOne(array $attributes = [])
 * @method static Roles[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Roles[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Roles|Proxy find(object|array|mixed $criteria)
 * @method static Roles|Proxy findOrCreate(array $attributes)
 * @method static Roles|Proxy first(string $sortedField = 'id')
 * @method static Roles|Proxy last(string $sortedField = 'id')
 * @method static Roles|Proxy random(array $attributes = [])
 * @method static Roles|Proxy randomOrCreate(array $attributes = [])
 * @method static Roles[]|Proxy[] all()
 * @method static Roles[]|Proxy[] findBy(array $attributes)
 * @method static Roles[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Roles[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RolesRepository|RepositoryProxy repository()
 * @method Roles|Proxy create(array|callable $attributes = [])
 */
final class RolesFactory extends ModelFactory
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
            'libRole' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Roles $roles): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Roles::class;
    }
}
