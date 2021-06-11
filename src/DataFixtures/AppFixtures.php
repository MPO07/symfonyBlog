<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');
        
        $user = new User();
        $user->setFirstname('Matthieu')
        ->setLastname('Poncet')
        ->setEmail('matthieu.poncet@parker.com')
        ->setPassword($this->passwordHasher->hashPassword($user,'123456'))
        ->setCreatedAt(new \DateTime($faker->date('Y-m-d h:i')))
        ->setValid(true)
        ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);


        for ($i=0; $i < 10; $i++) { 
            $category = new Category();
            $category->setTitle($faker->sentence(3))
            ->setDescription($faker->realText(600))
            ->setPicture('https://picsum.photos/300/200?id='.uniqid())
            ->setSlug($faker->slug(4));

            $manager->persist($category);
            for ($j=0; $j < 10; $j++) { 
                $article = new Article();
                $article->setTitle($faker->sentence(3))
                ->setSubtitle($faker->sentence(10))
                ->setContent($faker->realText(600))
                ->setCreateAt(new \DateTime($faker->date('Y-m-d H:i')))
                ->setPublishedAt(new \DateTime($faker->date('Y-m-d H:i')))
                ->setPicture('https://picsum.photos/300/200?id='.uniqid())
                ->setValid(true)
                ->setAuthor($user)
                ->addCategory($category)
                ->setSlug($faker->slug(4));
        
                $manager->persist($article);  
            }

        }


        $manager->flush();
    }
}
