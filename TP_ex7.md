#### NOTE IMPORTANTE : 

* **Contrairement aux TPs du lot 1 (TPs 1 à 5), les TPs du lot 2 vous pousseront à beaucoup plus d'autonomie et de réflexion personnelle.**

* Ces TPs ne contiendront donc pas les commandes Symfony déjà utilisées, car vous pouvez les retrouver dans les précédents TP ou **via des recherches Google**
* Seuls les nouvelles connaissances seront détaillées. 
* Le lot 2 a pour but **d'évaluer votre capacité à implémenter par vous-mêmes les fonctionnalités** du cahier des charges
* Les TPs contiendront tout de mêmes des indices des solutions possibles, mais sans vous donner la réponse. 

___

# Lot 2 - Espace Client

## Modifier l'entité `User`

Tel que présenté dans le cahier des charges, les utilisateurs doivent renseigner des informations suivantes pour s'inscrire : 
* **Nom**
* **Prénom**
* **Civilité**
* **Date de naissance** (qui donne l'age)
* **Email**

> Pour faire cela, utiliser la commande `php bin/console make:entity`.
> 
> Pour ne pas avoir de problèmes lors de la mise à jour de la BdD, faites en sorte que les nouvelles propriétés ajoutées puissent être null, ou videz la table `user`

## Modifier le formulaire d'inscription

* Ajouter au formulaire `RegistrationFormType` l'attribut `required => false` à tous les champs, exemple : 
```php 
    ->add('propriété', null, [
            'required' => true
    ])
```


## Créer l'espace client
Maintenant que l'administration des utilisateurs est en place, vous pouvez facilement modifier le rôle des utilisateurs.

Pour mettre en place l'espace client, la procédure est la suivante : 

* Reprendre `UserController` et préfixer les routes par `mon-espace-client` : 

```php
/**
 * @Route("/mon-espace-client")
 */
class UserController extends AbstractController
```

* Créer un dossier `templates/espace-client` pour stocker les templates de l'espace utilisateur.
* Utiliser la fonction `index` de `UserController` comme page d'accueil de l'espace client.
> L'idée est d'intégrer le formulaire de l'utilisateur dans la page d'accueil de l'espace client
  * Créer un nouveau formulaire pour l'entité `User` grâce à la commande `php bin/console make:form`. Vous pouvez nommer ce formulaire `UserType`.
  * Récupérer l'utilisateur connecté et le lier à un formulaire 

```php
/**
 * @Route("/", name="user_home", methods={"GET","POST"})
 */
public function index(UserRepository $userRepository, Request $request): Response
{
    // Récupérer l'utilisateur connecté
    $user = $this->getUser(); 

    // Créer un formulaire lié à ce utilisateur
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->getDoctrine()->getManager()->flush();

    }

    return $this->render('espace-client/index.html.twig', [
        'form' => $form->createView()
    ]);
}
```

