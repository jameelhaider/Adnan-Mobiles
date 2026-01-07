<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sql;
    public $filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sql, $filename)
    {
        $this->sql = $sql;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.database_backup')
                    ->subject('Database Backup Mail')
                    ->attachData($this->sql, $this->filename, [
                        'mime' => 'application/sql',
                    ]);
    }
}

