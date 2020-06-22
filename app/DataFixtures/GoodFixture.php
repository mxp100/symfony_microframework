<?php


namespace App\DataFixtures;


use App\Entity\Good;
use Doctrine\Persistence\ObjectManager;

class GoodFixture extends BaseFixture
{

    function loadData(ObjectManager $manager)
    {
        $this->createMany(Good::class, 200, function (Good $good, $count) {
            $good->setName($this->faker->productName);
            $good->setPrice(rand(1, 100));
        });

        $manager->flush();
    }
}