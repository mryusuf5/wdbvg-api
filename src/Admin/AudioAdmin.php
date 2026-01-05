<?php

namespace App\Admin;

use App\Entity\Audio;
use App\Entity\Image;
use App\Entity\Place;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;

class AudioAdmin extends AbstractAdmin
{
    private string $projectDir;

    public function setProjectDir(string $projectDir): void
    {
        $this->projectDir = $projectDir;
    }
    protected function prePersist(object $object): void
    {
        $this->handleFileUpload($object);
    }

    protected function preUpdate(object $object): void
    {
        $this->handleFileUpload($object);
    }

    private function handleFileUpload(Audio $audio): void
    {
        $file = $audio->getFile();
        if (!$file instanceof UploadedFile) {
            return;
        }

        $uploadDir = $this->projectDir . '/public/uploads/audios';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = uniqid('', true) . '.' . $file->guessExtension();
        $file->move($uploadDir, $filename);

        $audio->setUrl('/uploads/audios/' . $filename);
        $audio->setFile(null);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $subject = $this->getSubject();
        $audioPath = '';

        if($subject->getUrl())
        {
            $audioPath = $subject->getUrl();
        }
        $fileFormOptions = [
            'required' => true,
            'label' => 'Audio',
            'constraints' => [
                new File([
                    'maxSize' => '500M',
                ])
            ],
            'help' => '<audio controls> <source src="' . $audioPath . '" type="audio/mpeg" /> </audio>',
            'help_html' => true
        ];
        $form->add('title', TextType::class);
        $form->add('place', EntityType::class, [
            'class' => Place::class,
        ]);
        $form->add('file', FileType::class, $fileFormOptions);

    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('title');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list->add('title', null, [
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
}
