<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Cards
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    public function listCards(array $queryParams = [])
    {
        return $this->ramp->sendRequest('GET', 'cards', $queryParams);
    }

    public function createPhysicalCard(array $data)
    {
        return $this->ramp->sendRequest('POST', 'cards/deferred/physical', $data);
    }

    public function createVirtualCard(array $data)
    {
        return $this->ramp->sendRequest('POST', 'cards/deferred/virtual', $data);
    }

    public function fetchCard($cardId)
    {
        return $this->ramp->sendRequest('GET', "cards/{$cardId}");
    }

    public function updateCard($cardId, array $data)
    {
        return $this->ramp->sendRequest('PATCH', "cards/{$cardId}", $data);
    }

    public function suspendCard($cardId, $idempotencyKey)
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/suspension", ['idempotency_key' => $idempotencyKey]);
    }

    public function terminateCard($cardId, $idempotencyKey)
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/termination", ['idempotency_key' => $idempotencyKey]);
    }

    public function unlockCard($cardId, $idempotencyKey)
    {
        return $this->ramp->sendRequest('POST', "cards/{$cardId}/deferred/unsuspension", ['idempotency_key' => $idempotencyKey]);
    }
}
