<?php

namespace Simpleweb\SaaSBundle\Form\Type;

use FOS\UserBundle\Model\UserManagerInterface;

use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Simpleweb\SaaSBundle\Form\DataTransformer\ReferrerTransformer;

class ReferrerFormType extends Form\AbstractType
{
    /**
     * @var UserManagerInterface
     */
    protected $user_manager;

    public function __construct(UserManagerInterface $user_manager)
    {
        $this->user_manager = $user_manager;
    }

    public function buildForm(Form\FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new ReferrerTransformer($this->user_manager));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'required' => false
        ]);
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function getName()
    {
        return 'simpleweb_saas_referrer';
    }
}
