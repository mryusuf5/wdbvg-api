<?php

namespace App\Admin;

use App\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;

class ImageAdmin extends AbstractAdmin
{
    private string $projectDir;

    public function setProjectDir(string $projectDir): void
    {
        $this->projectDir = $projectDir;
    }
    protected function prePersist(object $image): void
    {
        $this->handleFileUpload($image);
    }

    protected function preUpdate(object $image): void
    {
        $this->handleFileUpload($image);
    }

    private function handleFileUpload(Image $image): void
    {
        $file = $image->getFile();
        if (!$file instanceof UploadedFile) {
            return;
        }

        $uploadDir = $this->projectDir . '/public/uploads/images';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid('', true) . '.' . $file->guessExtension();
        $file->move($uploadDir, $filename);

        $image->setUrl('/uploads/images/' . $filename);
        $image->setFile(null);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->add('title', TextType::class);
        $form->add('description', TextType::class);
        $form->add('file', FileType::class, [
            'required' => true,
            'label' => 'Image',
            'constraints' => [
                new File([
                    'maxSize' => '10M',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                ]),
            ],
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('title');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('title', null, [
            'label' => 'Title',
        ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'label' => 'Actions',
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('title');
    }
}
