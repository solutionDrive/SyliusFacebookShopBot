<?php
/**
 * Created by solutionDrive GmbH.
 *
 * @author   :  Julius Noack <noack@solutionDrive.de>
 * @date     :  14.10.17
 * @time     :  13:02
 * @copyright:  2017 solutionDrive GmbH
 */

namespace ApiBundle\Models;

class Messaging
{
    /** @var  User */
    protected $sender;

    /** @var  User */
    protected $recipient;

    /** @var  string */
    protected $message;

    /** @var  string */
    protected $attachment;

    /**
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     * @return Messaging
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     * @return Messaging
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param User $recipient
     * @return Messaging
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Messaging
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getArray()
    {
        $aBase = [
            'sender' => [
                'id' => $this->getSender()->getId()
            ],
            'recipient' => [
                'id' => $this->getRecipient()->getId()
            ]
        ];

        if ($this->getAttachment() !== null) {
            $aBase['message']['attachment']['type'] = 'image';
            $aBase['message']['attachment']['payload']['url'] = $this->getAttachment();
        } else {
            $aBase['message']['text'] = $this->getMessage();
        }

        return $aBase;
    }
}