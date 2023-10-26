<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('title', TextType::class, [
        'label' => 'Titre *',
      ])
      ->add('content', TextType::class, [
        'label' => 'Descrption *',
      ])
      ->add('skill', EntityType::class, [
        'class' => Skill::class,
        'label' => 'Compétence *',
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Task::class,
    ]);
  }
}
