<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('username', TextType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('username');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('username', TextType::class, [
            'label' => 'Username',
            ''
        ]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('username');
    }
}
