<?php

namespace CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer;

use CurrencX\Application\CurrencyRate\Client\CurrencyClient;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CurrencyLayerCurrencyAdapter implements CurrencyClient
{

    protected Client $client;

    protected SerializerInterface $serializer;

    public function __construct()
    {
        $this->client = new Client(
            [
                'cookies' => new CookieJar()
            ]);

        $normalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            new PropertyAccessor(),
            new ReflectionExtractor()
        );

        $this->serializer = new Serializer(
            [new ArrayDenormalizer(), $normalizer],
            [new JsonEncoder(), new JsonDecode()]
        );


    }

    public function getRate(string $baseCurrency, string $targetCurrency): float
    {
        $response = self::call(
            new GetRateRequest(
                '3d9424fd8bef8bd96aae180165efa38d', $baseCurrency
            ));

        return $response->quotes->{$baseCurrency . $targetCurrency};
    }

    public function call(Request $request)
    {
        $resp = $this->client->request(
            $request->getMethod(),
            $request->getUri() . vsprintf($request->getUriSuffixPattern(), $request->getUriParams()),
            [
                'query' => $request->getQueryParams()
            ]
        );

        $body = $resp->getBody()->getContents();

        /**
         * @TODO: $this->serializer->deserialize() && $this->serializer->denormalize() throws fatal argument 2 passed to Serializer::getDenormalizer() must be of the type string, null given. it's related to $type argument, but it's definately not null...
         */
        return json_decode($body);
    }

}
