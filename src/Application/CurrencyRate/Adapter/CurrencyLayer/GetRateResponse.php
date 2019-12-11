<?php

namespace CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer;

class GetRateResponse {
    public ?bool $success;
    public ?string $terms;
    public ?string $privacy;
    public ?int $timestamp;
    public ?string $source;
    public ?object $quotes;

    /**
     * GetRateResponse constructor.
     * @param bool $success
     * @param string $terms
     * @param string $privacy
     * @param int $timestamp
     * @param string $source
     * @param object $quotes
     */
    public function __construct(
        ?bool $success = null,
        ?string $terms = null,
        ?string $privacy = null,
        ?int $timestamp = null,
        ?string $source = null,
        $quotes = null
    ) {
        $this->success = $success;
        $this->terms = $terms;
        $this->privacy = $privacy;
        $this->timestamp = $timestamp;
        $this->source = $source;
        $this->quotes = $quotes;
    }

    /**
     * @param bool|null $success
     */
    public function setSuccess(?bool $success): void
    {
        $this->success = $success;
    }

    /**
     * @param string|null $terms
     */
    public function setTerms(?string $terms): void
    {
        $this->terms = $terms;
    }

    /**
     * @param string|null $privacy
     */
    public function setPrivacy(?string $privacy): void
    {
        $this->privacy = $privacy;
    }

    /**
     * @param int|null $timestamp
     */
    public function setTimestamp(?int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param string|null $source
     */
    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    /**
     * @param object|null $quotes
     */
    public function setQuotes(?object $quotes): void
    {
        $this->quotes = $quotes;
    }
}
