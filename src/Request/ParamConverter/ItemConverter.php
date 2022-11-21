<?php

namespace App\Request\ParamConverter;

use App\Entity\Creation;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ItemConverter
 * @package App\Request\ParamConverter
 */
class ItemConverter implements ParamConverterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * CreationConverter constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
        /**
         * @param ParamConverter $configuration
         * @return bool|void
         */
        public function supports(ParamConverter $configuration)
        {
            return $configuration->getClass() === Creation::class;
        }
    
    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$request->attributes->has("id")) {
            return;
        }

        $object = $this->entityManager
            ->getRepository($configuration->getClass())
            ->find($request->attributes->get("id"))
        ;

        $request->attributes->set($configuration->getName(), $object);
    }
}
