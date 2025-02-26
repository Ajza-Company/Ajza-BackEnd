<?php

namespace App\Http\Controllers\api\v1\General;

use App\Enums\MessageTypeEnum;
use App\Events\v1\General\G_RepMessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\General\RepChat\G_SendMessageRequest;
use App\Http\Requests\v1\General\RepChat\G_SendOfferRequest;
use App\Http\Requests\v1\General\RepChat\G_UpdateOfferRequest;
use App\Http\Resources\v1\General\RepChat\G_RepChatMessageResource;
use App\Http\Resources\v1\General\RepChat\G_RepChatResource;
use App\Http\Resources\v1\General\RepChat\G_RepOfferResource;
use App\Models\RepChat;
use App\Models\RepChatMessage;
use App\Models\RepOffer;
use Illuminate\Http\Request;

class G_RepChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth('api')->id();
        $chats = RepChat::where('user1_id', $user_id)
            ->orWhere('user2_id', $user_id)
            ->with(['user1', 'user2', 'latestMessage', 'order'])
            ->latest()
            ->filter(\request())
            ->paginate();

        return G_RepChatResource::collection($chats);
    }

    /**
     * Send a new message
     */
    public function sendMessage(G_SendMessageRequest $request, string $chat_id)
    {
        $chat = RepChat::findOrFail(decodeString($chat_id));

        $message = new RepChatMessage([
            'sender_id' => auth()->id(),
            'message_type' => $request->hasFile('attachment') ? MessageTypeEnum::ATTACHMENT : MessageTypeEnum::TEXT,
            'message' => $request->message,
        ]);

        if ($request->hasFile('attachment')) {
            $message->attachment = $request->file('attachment')
                ->store('chat-attachments', 'public');
        }

        $chat->messages()->save($message);
        $message->load(['sender']);

        broadcast(new G_RepMessageSent($message))->toOthers();

        return G_RepChatMessageResource::make($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $chat_id)
    {
        $chat = RepChat::findOrFail(decodeString($chat_id));

        $chat->load(['user1', 'user2']);

        return G_RepChatResource::make($chat);
    }

    /**
     * Get chat messages
     */
    public function messages(string $chat_id)
    {
        $chat = RepChat::findOrFail(decodeString($chat_id));

        $messages = $chat->messages()
            ->with(['sender', 'offer'])
            ->latest()
            ->paginate();

        return G_RepChatMessageResource::collection($messages);
    }

    /**
     * Send a new offer
     */
    public function sendOffer(G_SendOfferRequest $request, string $chat_id)
    {
        $chat = RepChat::findOrFail(decodeString($chat_id));

        $offer = RepOffer::create([
            'rep_order_id' => $chat->rep_order_id,
            'price' => $request->price
        ]);

        $message = new RepChatMessage([
            'sender_id' => auth('api')->id(),
            'message_type' => MessageTypeEnum::OFFER,
            'rep_offer_id' => $offer->id
        ]);

        $chat->messages()->save($message);
        $message->load(['sender', 'offer']);

        broadcast(new G_RepMessageSent($message))->toOthers();

        return G_RepChatMessageResource::make($message);
    }

    /**
     * Update offer status
     */
    public function updateOffer(G_UpdateOfferRequest $request, string $rep_offer_id)
    {
        $offer = RepOffer::findOrFail(decodeString($rep_offer_id));
        $offer->update(['status' => $request->status]);

        broadcast(new G_RepMessageSent($offer->refresh()->message))->toOthers();

        return G_RepOfferResource::make($offer);
    }
}
