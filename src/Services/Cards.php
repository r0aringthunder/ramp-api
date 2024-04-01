<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

/**
 * Provides methods to interact with card-related endpoints of the Ramp API.
 */
class Cards
{
    /**
     * @var Ramp The Ramp service instance to handle API requests.
     */
    protected $ramp;

    /**
     * Initializes a new instance of the Cards service.
     *
     * @param Ramp $ramp The Ramp service instance.
     */
    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Lists cards with optional filtering parameters.
     *
     * @param array $queryParams Optional query parameters to filter the list of cards.
     * @return array The response from the Ramp API.
     */
    public function list(array $queryParams = []): array
    {
        return $this->ramp->sendRequest('GET', 'cards', $queryParams);
    }

    /**
     * Creates a new physical card with specified details.
     *
     * @param array $data The data for creating a new physical card, including display name, fulfillment details, and spending restrictions.
     * @return array The response from the Ramp API.
     */
    public function createPhysical(array $data): array
    {
        return $this->ramp->sendRequest('POST', 'cards/deferred/physical', $data);
    }

    /**
     * Creates a new virtual card with specified details.
     *
     * @param array $data The data for creating a new virtual card, including display name and spending restrictions.
     * @return array The response from the Ramp API.
     */
    public function createVirtual(array $data): array
    {
        return $this->ramp->sendRequest('POST', 'cards/deferred/virtual', $data);
    }

    /**
     * Fetches detailed information about a specific card by its ID.
     *
     * @param string $cardId The unique identifier of the card to fetch.
     * @return array The response from the Ramp API.
     */
    public function fetch(string $cardId): array
    {
        return $this->ramp->sendRequest('GET', "cards/{$cardId}");
    }

    /**
     * Updates specified details for an existing card.
     *
     * @param string $cardId The unique identifier of the card to update.
     * @param array $data The data to update on the card, including display name and spending restrictions.
     * @return array The response from the Ramp API.
     */
    public function update(string $cardId, array $data): array
    {
        return $this->ramp->sendRequest('PATCH', "cards/{$cardId}", $data);
    }

    /**
     * Initiates a request to suspend a card, locking it from use.
     *
     * @param string $cardId The unique identifier of the card to suspend.
     * @param string $idempotencyKey A unique value to ensure idempotency of the suspension request.
     * @return array The response from the Ramp API.
     */
    public function suspend(string $cardId, string $idempotencyKey): array
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/suspension", ['idempotency_key' => $idempotencyKey]);
    }

    /**
     * Initiates a request to terminate a card, permanently disabling it.
     *
     * @param string $cardId The unique identifier of the card to terminate.
     * @param string $idempotencyKey A unique value to ensure idempotency of the termination request.
     * @return array The response from the Ramp API.
     */
    public function terminate(string $cardId, string $idempotencyKey): array
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/termination", ['idempotency_key' => $idempotencyKey]);
    }

    /**
     * Initiates a request to unlock (unsuspend) a card, making it usable again.
     *
     * @param string $cardId The unique identifier of the card to unlock.
     * @param string $idempotencyKey A unique value to ensure idempotency of the unsuspension request.
     * @return array The response from the Ramp API.
     */
    public function unlock(string $cardId, string $idempotencyKey): array
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/unsuspension", ['idempotency_key' => $idempotencyKey]);
    }
}
