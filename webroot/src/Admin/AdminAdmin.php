<?php

namespace App\Admin;

use App\Entity\Enum\Gender;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('gender', ChoiceType::class, [
                'choices' => array_flip(Gender::getChoices())
            ])
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', TextType::class)
            ->add('phone', TextType::class)
            ->add('enable', null, ['required' => false])
            ->add('visible', null, ['required' => false])

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('firstname');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('gender')
            ->add('firstname')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('firstname');
    }
}