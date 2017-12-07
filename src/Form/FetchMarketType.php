<?php

namespace App\Form;

use App\Command\FetchMarketpriceCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FetchMarketType extends AbstractType
{

    /**
     * @var FetchMarketpriceCommand
     */
    private $command;

    public function __construct(FetchMarketpriceCommand $command)
    {
        $this->command = $command;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $definitions = $this->command->getDefinition();
        foreach ($definitions->getArguments() as $argument) {
            $builder->add($argument->getName(), TextType::class, [
                'label' => $argument->getName(),
                'required' => $argument->isRequired(),
                'data' => $argument->getDefault(),
            ]);
        }

        foreach ($definitions->getOptions() as $option) {
            $builder->add($option->getName(), TextType::class, [
                'label' => $option->getName(),
                'required' => $option->isValueRequired(),
                'data' => $option->getDefault(),
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mapped' => false,
        ]);
    }
}
