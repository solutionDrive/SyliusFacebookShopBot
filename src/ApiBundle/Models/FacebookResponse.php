<?php
/**
 * Created by solutionDrive GmbH.
 *
 * @author   :  Julius Noack <noack@solutionDrive.de>
 * @date     :  14.10.17
 * @time     :  13:03
 * @copyright:  2017 solutionDrive GmbH
 */
namespace ApiBundle\Models;

class FacebookResponse
{
    /** @var  string */
    protected $object;

    /** @var  Entry */
    protected $entry;

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string $object
     * @return FacebookResponse
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return Entry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param Entry $entry
     * @return FacebookResponse
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
        return $this;
    }

    public function getArray()
    {
        return [
            'object' => $this->getObject(),
            'entry' => [[
                'id' => $this->getEntry()->getId(),
                'time' => $this->getEntry()->getTime(),
                'messaging' => [[
                    'sender' => [
                        'id' => $this->getEntry()->getMessaging()->getSender()->getId()
                    ],
                    'recipient' => [
                        'id' => $this->getEntry()->getMessaging()->getRecipient()->getId()
                    ],
                    'text' => $this->getEntry()->getMessaging()->getMessage()
                ]]
            ]]
        ];
    }
}