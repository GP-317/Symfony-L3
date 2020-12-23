<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserTypeClient extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom', null, [
            'label' => "Nom",
        ])

        ->add('Prenom', null, [
            'label' => "Prénom",
        ])

        ->add('Civilite', null, [
            'label' => "Civilité",
        ])

        ->add('dateNaissance', BirthdayType::class, [
            'label' => "Date de naissance",
            'format' => 'dd-MM-yyyy',
            'input' => 'string',
        ])

        ->add('noTelephone', null, [
            'label' => "N° de Téléphone",
        ])

        ->add('Ville', null, [
            'label' => "Ville",
        ])

        ->add('codePostal', null, [
            'label' => "Code Postal",
        ])

        ->add('Pays', null, [
            'label' => "Pays",
        ])

        ->add('noSecu', null, [
            'label' => "Numéro de Sécurité Sociale",
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
