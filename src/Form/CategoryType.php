<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null, [
                'label' => 'Nombre'
            ])
            ->add('active',null,[
                'label' => 'Activo',
                'required' => false
            ])
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('Guardar',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary d-flex justify-contend-end'
                ],
                'label' => 'Guardar Categoria'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
