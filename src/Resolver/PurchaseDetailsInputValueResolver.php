<?php

namespace App\Resolver;

use App\Model\Exception\ApiException;
use App\Validator\Constraints\PaymentData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsTargetedValueResolver('purchase_details_input')]
class PurchaseDetailsInputValueResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if(is_null($argument->getType())) {
            return [];
        }

        $data = $request->getPayload()->all();

        $validationGroup = $request->attributes->get('_route') == PaymentData::GROUP_PURCHASE ? PaymentData::GROUP_PURCHASE : null;

        $validationErrors = $this->validator->validate($data, new PaymentData($validationGroup));

        if (count($validationErrors) > 0) {
            $errors = [];
            foreach ($validationErrors as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new ApiException($errors);
        }

        try {
            $object = $this->serializer->denormalize($data,  $argument->getType(), 'json', [
                DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true
            ]);
        } catch (PartialDenormalizationException $e) {
            $errors = [];

            foreach ($e->getErrors() as $exception) {
                $errors[$exception->getPath()] = $exception->getMessage();
            }

            throw new ApiException($errors);
        }

        return [$object];
    }
}