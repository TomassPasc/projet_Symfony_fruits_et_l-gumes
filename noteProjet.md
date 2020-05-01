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





<u>**Formulaire**</u>

création du formulaire en console:

```bash
$ bin/console make:form

 The name of the form class (e.g. BraveElephantType):

 > AlimentType

 The name of Entity or fully qualified model class name that the new form will be bound to (empty for none):

 > Aliment

 created: src/Form/AlimentType.php
```

**le controller dans bootstrap**

```php
  /**

   \* @Route("/admin/aliment{id}", name="admin_aliment_modification")

   */

  public function modifierAliment(Aliment $aliment)

  {

​    $form = $this->createForm(AlimentType::class, $aliment);

​    return $this->render('admin_admin_aliment/modificationAliment.html.twig',[

​      "aliment" => $aliment,

​      "form" => $form->createView()

​    ]);

  }
```



```php
$form = $this->createForm(AlimentType::class, $aliment);
```

 $aliment permet d'intégrer directemet les valeurs dans le formulaire.

<u>**la vue:**</u>

```twig
{% extends 'base.html.twig' %}



{% block title %}Modification{% endblock %}



{% block monTitre %}Modification {{aliment.nom}}{% endblock %}



{% block body %}

{{form_start(form)}}

  {{form_widget(form)}}

  <input type="submit" class="btn btn-primary" value="modifier">

{{form_end(form)}}





{% endblock %}
```



<u>**fichier config/twig.yaml**</u>



POur utiliser bootstrap:

```
 form_themes: ['bootstrap_4_layout.html.twig']
```

