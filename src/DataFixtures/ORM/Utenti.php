<?php

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Dominio\Progetto\Model\Entity\Utente;
use Ramsey\Uuid\Uuid;

final class Utenti extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $utente1 = new Utente(
            Uuid::uuid4(),
            'utente1@example.com',
            'John',
            'Doe',
            '$2y$13$cM/9ZR24Pajd6g.V2rawqeRlnZ2Wm3HXeiNNoXl2nk1Ab78ihhJbq'    // ciaone
        );
        $utente1->attiva();
        $manager->persist($utente1);
        $this->setReference('utente1', $utente1);

        $daConfermare = new Utente(
            Uuid::uuid4(),
            'daConfermare@example.com',
            'Jane',
            'Doe',
            '$2y$13$g5.Cy87cVhxYyuorHZO9beOzbEHevcJzLAvEanS.djcZApFsNo9Au'  // bellaperte
        );
        $daConfermare->resetPassword('afaketoken');
        $manager->persist($daConfermare);

        $manager->flush();
    }
}
