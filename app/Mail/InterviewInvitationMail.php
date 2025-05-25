<?php

namespace App\Mail;
use App\Models\Application;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InterviewInvitationMail extends Mailable
{
    public Application $application;
    public string      $date;
    public string      $location;
    public ?string     $details;

    public function __construct(
        Application $application,
        string $date,
        string $location,
        ?string $details
    ) {
        $this->application = $application;
        $this->date        = $date;
        $this->location    = $location;
        $this->details     = $details;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Interview Invitation for {$this->application->user->fname}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.interviewInvitation',
            with: [
                'applicant' => $this->application->user,
                'date'      => $this->date,
                'location'  => $this->location,
                'details'   => $this->details,
            ]
        );
    }
}
