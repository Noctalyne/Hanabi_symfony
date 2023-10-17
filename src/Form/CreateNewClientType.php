<?php


/* 
    Se formulaire permet de crée un nouveaux client tous en créant un nouveau user 
    Permet l'enregistrement dans les 2 tables --> mix avec registrationForm 
    Permet de différencier le formulaire du site de celui pour les Administrateur
*/

namespace App\Form;

use App\Entity\Clients;
use App\Entity\User;

use App\Form\RegistrationFormType;
use app\Form\ClientsType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

//Voir pour renommer la classe car utiliser aussi pour modifier pas que crée
class CreateNewClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        @$builder

            /* Ici avec add on ajouter les donnée demander 
            au formulaire en back --> on afficher sur le twig 
            les info qu'on veux recevoir*/

            // ->add('email')


            // ->add('username')

            // ->add('plainPassword', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            //     'attr' => ['autocomplete' => 'new-password'],
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Please enter a password',
            //         ]),
            //         new Length([
            //             'min' => 6,
            //             'minMessage' => 'Your password should be at least {{ limit }} characters',
            //             'max' => 4096,// max length allowed by Symfony for security reasons
            //         ]),
            //     ],
            // ])
            // ->add('nom')
            // ;

            // ->add('nom', TextType::class, [
            //     'mapped' => false
            // ])

            // ->add('nom_client')

            // ->add('prenom_client');

            // ->add('num_telephone')

            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ]);

            
            ->add('email', ClientsType::class, [
                'data_class' => Clients::class,
            ]);


            // ->add('email', RegistrationFormType::class, [
            //     'data_class' => User::class,
            // ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            array('data_class' => User::class, Clients::class), // array permet de renvoyer la classe en tableau
            // 'data_class' => Clients::class, // array permet de renvoyer la classe en tableau

        ]);
    }
}
