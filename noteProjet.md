<u>**Repository requête spécifique:**</u>

<u>fichier AlimentRepository:</u>

```php
  public function getAlimentParNbCalories($calorie){

​    return $this->createQueryBuilder('aliment') //équivaut à SELECT * form la table aliment

​    ->andWhere('aliment.calorie < :val')

​    ->setParameter('val', $calorie)

​    ->getQuery() //récuppère la query

​    ->getResult() //réccupère le résultat de la query

​    ;

  }
```

<u>controller:</u>



```php
  /**

   \* @Route("/aliments/calorie/{calorie}", name="alimentsParCalorie")

   */

  public function getAlimentsParCalorie(AlimentRepository $repository, $calorie)

  {

​    $aliments = $repository->getAlimentParNbCalories($calorie);

​    return $this->render('aliment/aliments.html.twig', [

​      'aliments' => $aliments,

​      'isCalorie' => true

​    ]);

  }
```

