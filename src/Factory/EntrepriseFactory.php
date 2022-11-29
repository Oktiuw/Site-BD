<?php

namespace App\Factory;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Entreprise>
 *
 * @method static Entreprise|Proxy createOne(array $attributes = [])
 * @method static Entreprise[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Entreprise[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Entreprise|Proxy find(object|array|mixed $criteria)
 * @method static Entreprise|Proxy findOrCreate(array $attributes)
 * @method static Entreprise|Proxy first(string $sortedField = 'id')
 * @method static Entreprise|Proxy last(string $sortedField = 'id')
 * @method static Entreprise|Proxy random(array $attributes = [])
 * @method static Entreprise|Proxy randomOrCreate(array $attributes = [])
 * @method static Entreprise[]|Proxy[] all()
 * @method static Entreprise[]|Proxy[] findBy(array $attributes)
 * @method static Entreprise[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Entreprise[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EntrepriseRepository|RepositoryProxy repository()
 * @method Entreprise|Proxy create(array|callable $attributes = [])
 */
final class EntrepriseFactory extends ModelFactory
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
            'nomEnt' => self::faker()->company(),
            'nomRef' => self::faker()->lastName().' '.self::faker()->firstName(),
            'cdUtil' => UtilisateurFactory::new(),  # à revoir comment récupérer correctement id utilisateur car clé étrangère
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Entreprise $entreprise): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Entreprise::class;
    }
}
