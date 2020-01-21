<?php declare(strict_types=1);

namespace CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer;

use Psr\Http\Message\RequestInterface;

abstract class Request
{
    /**
     * @var string
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $uri;

    /**
     * @var string
     */
    protected string $uriSuffixPattern;

    /**
     * @var array
     */
    protected array $uriParams;

    /**
     * @var int
     */
    protected int $uriParamsCount;

    /**
     * @var array
     */
    protected array $queryParams;

    /**
     * @var array
     */
    protected array $body;

    public function __construct()
    {
    }

    /**
     * @var string
     */
    protected string $responseClass;

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    public function getUriSuffixPattern(): string
    {
        return $this->uriSuffixPattern;
    }

    public function getResponseClass(): string
    {
        return $this->responseClass;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }
}
