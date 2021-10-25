<?php

namespace App\Form\FormExtension;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\EventSubscriber\HoneyPotSubscriber;

class HoneyPotType extends AbstractType
{
    /**
     * @var LoggerInterface
     */
    private  $honeyPotLogger;

    /**
     * @var RequestStack
     */
    private  $requestStack;

    public function __construct(LoggerInterface $honeyPotLogger, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->honeyPotLogger = $honeyPotLogger;
    }


    protected const DELICIOUS_HONEY_CANDY_FOR_BOT = "Postal_code";

    protected const FABULOUS_HONEY_CANDY_FOR_BOT = "Address";

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(self::DELICIOUS_HONEY_CANDY_FOR_BOT, TextType::class, $this->setHoneyPotFieldConfiguration())
                ->add(self::FABULOUS_HONEY_CANDY_FOR_BOT, TextType::class, $this->setHoneyPotFieldConfiguration())
                ->addEventSubscriber(new HoneyPotSubscriber($this->honeyPotLogger, $this->requestStack));
    }

    /**
     * @return array
     */
    protected function setHoneyPotFieldConfiguration(): array
    {
        return [
            'attr' => [
                'autocomplete' => 'off',
                'tabindex' => '-1'
            ],
            'mapped' => false,
            'required' => false
        ];
    }
}