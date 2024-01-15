<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Decisions;
use App\Entity\Utilisateurs;

class Statistiques
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getStats()
    {
        $nbUsers = $this->getUsersCount();
        $nbDecisions = $this->getDecisionsCount();
        $nbAgentsInvalides = $this->getAgentsInvalidesCount();

        return compact('nbUsers', 'nbDecisions', 'nbAgentsInvalides');
    }

    /**
     * Retourne le nombre de users inscrits
     *
     * @return Integer
     */
    public function getUsersCount()
    {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\Utilisateurs u')->getSingleScalarResult();
    }

    /**
     * Retourne le nombre d'organismes parapublics
     *
     * @return Integer
     */
    public function getDecisionsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(d) FROM App\Entity\Decisions d WHERE d.is_deleted != true')
            ->getSingleScalarResult();
    }

    /**
     * Retourne le nombre d'agent invalide
     *
     * @return Integer
     */
    public function getAgentsInvalidesCount()
    {
        return $this->manager->createQuery('SELECT SUM(d.nbreAgentsInvalidesDecision) FROM App\Entity\Decisions d')
            ->getSingleScalarResult();
    }
}