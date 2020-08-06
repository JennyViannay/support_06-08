<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    // private $categoryRepository;

    // public function __construct(CategoryRepository $categoryRepository)
    // {
    //     $this->categoryRepository = $categoryRepository;
    // }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        //$categories = $this->categoryRepository->findAll();

        $arrayCategory = [];
        for($i = 0 ; $i < 10; $i++){
            $categ = new Category();
            $categ->setName($faker->title);
            $manager->persist($categ);
            $arrayCategory[] = $categ;
        }
        
        for($i = 0 ; $i < 10; $i++){
            $article = new Article();
            $article->setTitle($faker->name);
            $article->setContent($faker->text);
            $article->setCategory($faker->randomElement($arrayCategory));
            $manager->persist($article);
        }


        $manager->flush();
    }
}
