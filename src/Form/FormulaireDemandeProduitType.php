<?php

namespace App\Form;

use App\Entity\FormulaireDemandeProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class FormulaireDemandeProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeProduit', ChoiceType::class, [
                'choices' => [
                    'Manga' => 'Manga',
                    'Figurine' => 'Figurine',
                    'Autres' => 'Autres',
                ],
                'expanded' => true, // Pour afficher les cases à cocher au lieu d'une liste déroulante
                'multiple' => false, // Pour permettre la sélection d'un seul choix
                'label' => 'Réponse du vendeur', // Libellé du champ
            ])
            
            ->add('descriptionProduit', TextareaType::class, [
                'constraints' => 
                    new Length([
                        'min' => 0,
                        'maxMessage' => 'Votre demande ne peux exceder {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 300,
                    ]),
            ])
            
            // Permet d accepter ou non la demande
            ->add('reponseDemande', ChoiceType::class, [
                'choices' => [
                    // 'Attente' => 'Attente',
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                // 'attr' => ['style' => 'display:none;'], //permet de cacher l'imput
                'required' => false, // Pour rendre le champ facultatif
                'expanded' => true, // Pour afficher les cases à cocher au lieu d'une liste déroulante
                'multiple' => false, // Pour permettre la sélection d'un seul choix
                'label' => 'Demande accepté ? ', // Libellé du champ
                'data' => 'Attente',
            ])
            // ->add('dateReponseForm')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormulaireDemandeProduit::class,
        ]);
    }
}
