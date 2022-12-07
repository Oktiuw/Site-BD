<?php

namespace App\Factory;

use App\Entity\GroupeEtudiants;
use App\Repository\GroupeEtudiantsRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<GroupeEtudiants>
 *
 * @method static GroupeEtudiants|Proxy createOne(array $attributes = [])
 * @method static GroupeEtudiants[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static GroupeEtudiants[]|Proxy[] createSequence(array|callable $sequence)
 * @method static GroupeEtudiants|Proxy find(object|array|mixed $criteria)
 * @method static GroupeEtudiants|Proxy findOrCreate(array $attributes)
 * @method static GroupeEtudiants|Proxy first(string $sortedField = 'id')
 * @method static GroupeEtudiants|Proxy last(string $sortedField = 'id')
 * @method static GroupeEtudiants|Proxy random(array $attributes = [])
 * @method static GroupeEtudiants|Proxy randomOrCreate(array $attributes = [])
 * @method static GroupeEtudiants[]|Proxy[] all()
 * @method static GroupeEtudiants[]|Proxy[] findBy(array $attributes)
 * @method static GroupeEtudiants[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static GroupeEtudiants[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GroupeEtudiantsRepository|RepositoryProxy repository()
 * @method GroupeEtudiants|Proxy create(array|callable $attributes = [])
 */
final class GroupeEtudiantsFactory extends ModelFactory
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
            'nomGroupe' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(GroupeEtudiants $groupeEtudiants): void {})
        ;
    }

    protected static function getClass(): string
    {
        return GroupeEtudiants::class;
    }
}
