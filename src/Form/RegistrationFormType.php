<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', null, [
                'label' => "Nom",
                'required' => true
            ])

            ->add('Prenom', null, [
                'label' => "Prénom",
                'required' => true
            ])

            ->add('Civilite', null, [
                'label' => "Civilité",
                'required' => true
            ])

            ->add('dateNaissance', BirthdayType::class, [
                'label' => "Date de naissance",
                'required' => true,
                'format' => 'dd-MM-yyyy',
                'input' => 'string',
            ])

            ->add('noTelephone', null, [
                'label' => "N° de Téléphone",
                'required' => false
            ])

            ->add('Ville', null, [
                'label' => "Ville",
                'required' => false
            ])

            ->add('codePostal', null, [
                'label' => "Code Postal",
                'required' => false
            ])

            ->add('Pays', null, [
                'label' => "Pays",
                'required' => false
            ])

            ->add('noSecu', null, [
                'label' => "Numéro de Sécurité Sociale",
                'required' => false
            ])



            ->add('email', EmailType::class, [
                'label' => "Email",
                'required' => true
            ])


            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter les CGU',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez agréer à nos conditions d\'utilisation afin de poursuivre.',
                    ]),
                ],
            ])


            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
