



<u>

Repository requête spécifique:**</u>

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

form_start: démarre le formulaire.

form_widget: affiche tout le formulaire

form_end:termine l'affichage du formulaire.

<u>**fichier config/twig.yaml**</u>



POur utiliser bootstrap:

```
 form_themes: ['bootstrap_4_layout.html.twig']
```



<u>mise en forme du formulaire:</u>

```twig
{% block body %}

{{form_start(form)}}

    <div class="row">

        <div class="col-6">

            <img src="{{asset('images/' ~ aliment.image)}}" style="width:25%">

            <div>{{ form_row(form.image)}}</div>

            <div>{{ form_row(form.nom, {"attr" : {'class':'text-danger bg-success'},"label" : "Nom de l'aliment"}) }}</div>

​    </div>

        <div class="col-6">

​      {{form_widget(form)}}

​    </div>

  </div>

  <input type="submit" class="btn btn-primary" value="modifier">

{{form_end(form)}}





{% endblock %}
```



  <u>le controller modifier:</u>

```php
public function modifierAliment(Aliment $aliment, Request $request, EntityManagerInterface $manager)

  {



   $form = $this->createForm(AlimentType::class, $aliment);



   $form->handleRequest($request);



​    if($form->isSubmitted() && $form->isValid()){

​      $manager->persist($aliment);

​      $manager->flush();

​      return $this->redirectToRoute("admin_aliment");

​    }



​    return $this->render('admin_admin_aliment/modificationAliment.html.twig',[

​      "aliment" => $aliment,

​      "form" => $form->createView()

​    ]);

  }

}
```





<u>suppression</u>

​    <u>vue:</u>

```twig
  <td>

                <a class="btn btn-secondary" href="{{path("admin_aliment_modification", {'id' : aliment.id})}}">Modifier</a>

​        <form method="POST" style="display:inline-block" action="{{path("admin_aliment_suppression", {'id' : aliment.id})}}" onsubmit="return confirm("confirmer la suppression ?")">

​          <input type="hidden" name ="_method" value="delete">

​          <input type="hidden" name="_token" value="{{csrf_token('SUP' ~ aliment.id)}}">

​          <input type="submit" class="btn btn-danger" value="supprimer">

​        </form>

​      </td>
```

<u>controller:</u>

```php
 public function supprimer(Aliment $aliment, Request $request, EntityManagerInterface $manager)

  {

​    if ($this->isCsrfTokenValid("SUP". $aliment->getId(), $request->get('_token')))

​    {

​    $manager->remove($aliment);

​    $manager->flush();

​    return $this->redirectToRoute("admin_aliment");

​    }
```





**AJouter un message flash**

<u>vue pour le flash:</u>

```twig
{% block body %}



{% for message in app.flashes('success') %}

    <div class="alert alert-success">

​    {{message}}

  </div>



{% endfor %}
```



<u>controller:</u>

```php
$modif = $aliment->getId() !== null;
```



```php
 $this->addFlash("success", ($modif) ? "La modification a bien été effectuée" : "L'ajout a bien été effectué");
```

message flash pour la modif et l'ajout.





<u>**exemple validator:**</u>

dans entity:

```php
use Symfony\Component\Validator\Constraints as Assert;
```



```php
  /**

   \* @ORM\Column(type="string", length=255)

   \* @Assert\Length(

   \*   min = 3,

   \*   max = 15,

   \*   minMessage = "Un minimum de 3 caractères",

   \*   maxMessage = "un maximum de 15 caractère"

   \* )

   */
```

<u>**upload image:**</u>

installer le bundle vich:

```bash
composer require vich/uploader-bundle
```



dans config/vich.yaml:

vi

```yaml
ch_uploader:

  db_driver: orm



  mappings:

​    aliments_images:

​      uri_prefix: /images/aliments

​      upload_destination: '%kernel.project_dir%/public/images/aliments'
	  namer: Vich\UploaderBundle\Naming\SmartUniqueNamer //pour le naming

```



Ajout de la colonne update_at en bdd:

~~~bash
$ 

```
bin/console make:entity aliment

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):

 > updated_at

 Field type (enter ? to see all types) [datetime]:

 >

 Can this field be null in the database (nullable) (yes/no) [no]:

 >

 updated: src/Entity/Aliment.php
```


~~~



**ajout type en bdd**

```bash
bin/console doctrine:fixtures:load --append
```

--append permet de faire des modif sur une bdd déjà existante.