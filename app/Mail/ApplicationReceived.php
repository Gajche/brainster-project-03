<?php

namespace App\Mail;

use App\Models\ArtistApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationReceived extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	public function __construct(public ArtistApplication $application) {}

	public function envelope(): Envelope
	{
		return new Envelope(
			subject: 'Пријавата е примена - Еволуција на Сонот',
		);
	}

	public function content(): Content
	{
		return new Content(
			view: 'emails.application-received',
		);
	}
}
