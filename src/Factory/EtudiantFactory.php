<?php

namespace App\Factory;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Etudiant>
 *
 * @method static Etudiant|Proxy createOne(array $attributes = [])
 * @method static Etudiant[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Etudiant[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Etudiant|Proxy find(object|array|mixed $criteria)
 * @method static Etudiant|Proxy findOrCreate(array $attributes)
 * @method static Etudiant|Proxy first(string $sortedField = 'id')
 * @method static Etudiant|Proxy last(string $sortedField = 'id')
 * @method static Etudiant|Proxy random(array $attributes = [])
 * @method static Etudiant|Proxy randomOrCreate(array $attributes = [])
 * @method static Etudiant[]|Proxy[] all()
 * @method static Etudiant[]|Proxy[] findBy(array $attributes)
 * @method static Etudiant[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Etudiant[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EtudiantRepository|RepositoryProxy repository()
 * @method Etudiant|Proxy create(array|callable $attributes = [])
 */
final class EtudiantFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'numEtud' => self::faker()->numberBetween(),
            'nomEtud' => self::faker()->text(),
            'pnomEtud' => self::faker()->text(),
            'dtnsEtud' => self::faker()->dateTime(),
            'adEtud' => self::faker()->text(),
            'cpEtud' => self::faker()->text(),
            'villeEtud' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Etudiant $etudiant): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Etudiant::class;
    }
}
