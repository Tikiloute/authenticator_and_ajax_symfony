<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Aliment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $u1 = new User();
        $u1->setEmail('bruno.etcheverry@hotmail.fr')
            ->setPassword('chou');

        $manager->persist(($u1));

        $u2 = new User();
        $password = $this->hasher->hashPassword($u2, '1234');
        $u2->setEmail('thomas@gmail.com')
            ->setPassword($password)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($u2);

        $a1 = new Aliment();
        $a1->setNom("carotte")
            ->setCalorie(36)
            ->setPrix(1.80)
            ->setImage("aliments/carotte.png")
            ->setProteine(0.77)
            ->setGlucide(6.45)
            ->setLipide(0.26)
            ->setCategory('legume');

        $manager->persist($a1);

        $a2 = new Aliment();
        $a2->setNom("patate")
            ->setCalorie(46)
            ->setPrix(1.20)
            ->setImage("aliments/papate.png")
            ->setProteine(0.27)
            ->setGlucide(3.45)
            ->setLipide(1.16)
            ->setCategory('legume');
            
        $manager->persist($a2);

        $a3 = new Aliment();
        $a3->setNom("pomme")
            ->setCalorie(31)
            ->setPrix(1.35)
            ->setImage("aliments/pomme.png")
            ->setProteine(0.11)
            ->setGlucide(5.24)
            ->setLipide(0.85)
            ->setCategory('fruit');
            
        $manager->persist($a3);

        $a4 = new Aliment();
        $a4->setNom("tomate")
            ->setCalorie(68)
            ->setPrix(1.07)
            ->setImage("aliments/tomate.png")
            ->setProteine(0.78)
            ->setGlucide(3.43)
            ->setLipide(2.56)
            ->setCategory('fruit');
            
        $manager->persist($a4);


        $manager->flush();

        
                        
    }
}
