<?php

namespace App\Form;

use App\Entity\Adresses;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numAdresse')
            ->add('rueAdresse')
            ->add('complementAdresse')
            ->add('villeAdresse')
            ->add('codePostpAdressse')
            ->add('paysAdresse')
            ->add('id_client', HiddenType::class, [
                'data' => '',
                'mapped' => false, // Indique que ce champ ne correspond pas à une propriété de l'entité
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
        ]);
    }
}
