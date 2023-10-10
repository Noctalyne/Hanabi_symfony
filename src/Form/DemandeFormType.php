<?php

namespace App\Form;

use App\Entity\FormulaireDemandeProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TypeProduit')
            ->add('descriptionProduit')
            ->add('dateEnvoieForm')
            ->add('dateReponseForm')
            ->add('reponseDemande')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormulaireDemandeProduit::class,
        ]);
    }
}
