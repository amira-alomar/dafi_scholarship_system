<?php

namespace App\Mail;
use App\Models\Application;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InvitatiobMail extends Mailable
{
    public Application $application;
    public string      $exam_date;
    public string      $exam_subject;
    public ?string     $exam_details;

    public function __construct(
        Application $application,
        string $exam_date,
        string $exam_subject,
        ?string $exam_details
    ) {
        $this->application  = $application;
        $this->exam_date    = $exam_date;
        $this->exam_subject = $exam_subject;
        $this->exam_details = $exam_details;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Exam Invitation for {$this->application->user->fname}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.examInvitation',
            with: [
                'applicant'    => $this->application->user,
                'examDate'     => $this->exam_date,
                'examSubject'  => $this->exam_subject,
                'examDetails'  => $this->exam_details,
            ],
        );
    }
}
