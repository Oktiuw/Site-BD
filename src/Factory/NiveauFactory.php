<?php

namespace App\Factory;

use App\Entity\Niveau;
use App\Repository\NiveauRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Niveau>
 *
 * @method static Niveau|Proxy createOne(array $attributes = [])
 * @method static Niveau[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Niveau[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Niveau|Proxy find(object|array|mixed $criteria)
 * @method static Niveau|Proxy findOrCreate(array $attributes)
 * @method static Niveau|Proxy first(string $sortedField = 'id')
 * @method static Niveau|Proxy last(string $sortedField = 'id')
 * @method static Niveau|Proxy random(array $attributes = [])
 * @method static Niveau|Proxy randomOrCreate(array $attributes = [])
 * @method static Niveau[]|Proxy[] all()
 * @method static Niveau[]|Proxy[] findBy(array $attributes)
 * @method static Niveau[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Niveau[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static NiveauRepository|RepositoryProxy repository()
 * @method Niveau|Proxy create(array|callable $attributes = [])
 */
final class NiveauFactory extends ModelFactory
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
            'libNiv' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Niveau $niveau): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Niveau::class;
    }
}
