<?php

namespace App\Request\ParamConverter;

use App\Entity\Creation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CreationConverter
 * @package App\Request\ParamConverter
 */
class CreationConverter implements ParamConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreationConverter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return;
        }

        $object = $this->serializer->deserialize($request->getContent(), $configuration->getClass(), 'json');

        $request->attributes->set($configuration->getName(), $object);
    }

    /**
     * @param ParamConverter $configuration
     * @return bool|void
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Creation::class;
    }
}