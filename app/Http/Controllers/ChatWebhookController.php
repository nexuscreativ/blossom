<?php

namespace App\Http\Controllers;

use App\Services\Chat\ChatManager;
use App\Services\Chat\RespondIoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Handles incoming webhooks from respond.io (WhatsApp / Telegram / Voice).
 * The webhook should be configured in respond.io → Settings → Webhooks,
 * pointing at POST {your-domain}/webhooks/respondio.
 */
class ChatWebhookController extends Controller
{
    public function respondIo(Request $request)
    {
        $service = app(RespondIoService::class);

        if (! $service->validate()) {
            Log::warning('respond.io webhook received but the service is not configured.');

            return response('Not configured', 503);
        }

        $signature = $request->header('X-Signature') ?? $request->header('X-Respondio-Signature') ?? '';
        $payload = $request->getContent();

        if (! $service->verifyWebhook($signature, $payload)) {
            Log::warning('respond.io webhook signature mismatch.');

            return response('Invalid signature', 401);
        }

        $data = $request->all();

        $messageText = data_get($data, 'message.text')
            ?? data_get($data, 'message.content')
            ?? data_get($data, 'text')
            ?? data_get($data, 'payload.message.text');

        $contactId = data_get($data, 'contact.id')
            ?? data_get($data, 'contact_id')
            ?? data_get($data, 'payload.contact.id');

        $channel = strtolower((string) (data_get($data, 'channel', 'whatsapp')));
        $channel = in_array($channel, ['whatsapp', 'telegram', 'voice']) ? $channel : 'whatsapp';

        if (! filled($messageText) || ! filled($contactId)) {
            // Not a message event (e.g. read receipts, status) — acknowledge.
            return response('ok');
        }

        $manager = new ChatManager();

        $result = $manager->handleIncoming(
            $messageText,
            $channel,
            'respondio:' . $contactId,
            [
                'metadata' => [
                    'respondio_contact_id' => $contactId,
                    'respondio_channel' => $channel,
                    'contact' => data_get($data, 'contact.name'),
                ],
            ],
        );

        $reply = $result['message'];

        // Send the reply back through respond.io when there is one.
        if (filled($reply)) {
            $service->sendMessage($contactId, $reply);
        }

        return response('ok');
    }
}