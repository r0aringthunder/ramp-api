<?php

return [
    'client_id' => env('RAMP_CLIENT_ID', 'your_client_id'),
    'client_secret' => env('RAMP_CLIENT_SECRET', 'your_client_secret'),
    'prod_ready' => env('PROD_READY', false),
    'scopes' => env('RAMP_SCOPES', 'accounting:read accounting:write bills:read business:read cards:read cards:write cashbacks:read departments:read departments:write entities:read leads:read leads:write limits:read limits:write locations:read locations:write memos:read merchants:read receipt_integrations:read receipt_integrations:write receipts:read reimbursements:read spend_programs:read spend_programs:write statements:read transactions:read transfers:read users:read users:write'),
];
