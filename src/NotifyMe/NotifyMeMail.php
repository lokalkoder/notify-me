<?php

namespace Lokalkoder\NotifyMe\NotifyMe;

use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;
use Lokalkoder\NotifyMe\NotifyMe\Models\NotifyMe;

class NotifyMeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public NotifyMe $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postmanMail)
    {
        $this->content = $postmanMail;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->content->subject,
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
            markdown: 'notify-me::mail.notify-me.mailable',
            with: [
                'url' => [
                    'label' => config('app.name'),
                    'link' => config('app.url'),
                ],
                'signature' => config('app.name'),
            ],
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

    /**
     * Override Mailable definition.
     * Build the Markdown view for the message.
     *
     * @return array
     *
     * @throws \ReflectionException
     *
     * @TODO : specific to override markdown component
     */
//    protected function buildMarkdownView()
//    {
//        $markdown = Container::getInstance()->make(Markdown::class);
//
//        $markdown->loadComponentsFrom([dirname(dirname(__DIR__)) . '/resources/view/mail/theme']);
//
//        if (isset($this->theme)) {
//            $markdown->theme($this->theme);
//        }
//
//        $data = $this->buildViewData();
//
//        return [
//            'html' => $markdown->render($this->markdown, $data),
//            'text' => $this->buildMarkdownText($markdown, $data),
//        ];
//    }
}
