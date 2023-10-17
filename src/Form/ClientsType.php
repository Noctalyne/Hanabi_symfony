<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles')
            // ->add('email') //, EmailType::class, ['required' => false]
            // ->add('username')
            // ->add('password')
            ->add('nomClient')
            ->add('prenomClient')
            ->add('telephone');
        // if ('email' === null ) {
        //    $builder 
        // }
        // else {
 
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
            // 'data_class' => User::class,

        ]);
    }
}
