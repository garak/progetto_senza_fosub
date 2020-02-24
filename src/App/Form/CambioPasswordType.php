<?php

namespace App\Form;

use Dominio\Progetto\Command\Utente\CambiaPasswordCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CambioPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vecchiaPassword', Type\PasswordType::class, ['label' => 'Inserire la vecchia password'])
            ->add('nuovaPassword', Type\PasswordType::class, ['label' => 'Scegliere una nuova password'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CambiaPasswordCommand::class,
            'translation_domain' => false,
        ]);
    }
}
