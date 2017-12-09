<?php
namespace Larasaas\Services;
/**
 * Created by PhpStorm.
 * User: zhoujun
 * Date: 2017/12/7
 * Time: 下午1:49
 */
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use Larasaas\Tenant\Contacts\DemoRepositoryInterface;

class DemoService  implements DemoRepositoryInterface
{
    /** @var Mailer */
    private $mail;

    /**
     * EmailService constructor.
     * @param Mailer $mail
     */
    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    /**
     * 發送Email
     * @param array $request
     */
    public function send(array $request)
    {
        $this->mail->queue('email.index', $request, function (Message $message) {
            $message->sender(env('MAIL_USERNAME'));
            $message->subject(env('MAIL_SUBJECT'));
            $message->to(env('MAIL_TO_ADDR'));
        });
    }
}