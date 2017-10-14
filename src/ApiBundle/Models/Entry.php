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

class Entry
{
    /** @var  int */
    protected $id;

    /** @var  int */
    protected $time;

    /** @var  Messaging */
    protected $messaging;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Entry
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param int $time
     * @return Entry
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @return Messaging
     */
    public function getMessaging()
    {
        return $this->messaging;
    }

    /**
     * @param Messaging $messaging
     * @return Entry
     */
    public function setMessaging($messaging)
    {
        $this->messaging = $messaging;
        return $this;
    }
}