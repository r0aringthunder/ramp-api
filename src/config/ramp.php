<?php

return [
    // Enable or disable the Ramp API
    'enabled' => env('RAMP_ENABLED', true),

    // Your Ramp API keys
    'client_id' => env('RAMP_CLIENT_ID'),
    'client_secret' => env('RAMP_CLIENT_SECRET'),
    
    // False will put you in the Ramp sandbox but true will interact with production Ramp data
    'prod_ready' => env('PROD_READY', false),

    // The package defaults to all possible scopes so that you can test without an issue on the Ramp sandbox.
    // I reccomend that you identify what scopes you need for production before release.
    'scopes' => env('RAMP_SCOPES', 'accounting:read accounting:write bills:read business:read cards:read cards:write cashbacks:read departments:read departments:write entities:read leads:read leads:write limits:read limits:write locations:read locations:write memos:read merchants:read receipt_integrations:read receipt_integrations:write receipts:read reimbursements:read spend_programs:read spend_programs:write statements:read transactions:read transfers:read users:read users:write'),
];
