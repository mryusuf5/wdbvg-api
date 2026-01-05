<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlaceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('title', TextType::class);
        $form->add('description', TextType::class);
        $form->add('longitude', TextType::class);
        $form->add('latitude', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('title');
        $datagrid->add('description');
        $datagrid->add('longitude');
        $datagrid->add('latitude');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('title', TextType::class, [])
        ->add('description', TextType::class, [])
        ->add('longitude', TextType::class, [])
        ->add('latitude', TextType::class, [])
        ->add(ListMapper::NAME_ACTIONS,null, [
            'actions' => [
                'edit' => [],
                'delete' => [],
            ]
        ]);
    }
}
