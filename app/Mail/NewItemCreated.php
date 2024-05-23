<?php

namespace App\Mail;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewItemCreated extends Mailable
{
    use Queueable, SerializesModels;
    public $item;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $item = Item::find($id);
        $this->item = $item;
    }
    public function build()
    {
        return $this->subject('New Item Created')
                    ->view('emails.new_item_created')
                    ->with([
                        'itemName' => $this->item->name,
                        'itemDescription' => $this->item->description,
                        // Add other item data you want to pass to the email template
                    ]);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'New Item Created',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.new_item_created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
