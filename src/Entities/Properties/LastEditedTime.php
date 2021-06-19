<?php

namespace FiveamCode\LaravelNotionApi\Entities\Properties;

use DateTime;
use Exception;
use FiveamCode\LaravelNotionApi\Entities\PropertyItems\RichDate;
use FiveamCode\LaravelNotionApi\Exceptions\HandlingException;

/**
 * Class LastEditedTime
 * @package FiveamCode\LaravelNotionApi\Entities\Properties
 */
class LastEditedTime extends Property
{
    /**
     * @throws HandlingException
     */
    protected function fillFromRaw(): void
    {
        parent::fillFromRaw();
        if ($this->rawContent == null) {
            throw HandlingException::instance('The property-type is last_edited_time, however the raw data-structure is null. Please check the raw response-data.');
        }

        try {
            $this->content = new DateTime($this->rawContent);
        } catch (Exception $e) {
            throw HandlingException::instance('The content of last_edited_time is not a valid ISO 8601 date time string.');
        }
    }


    /**
     * @return DateTime
     */
    public function getContent(): DateTime
    {
        return $this->content;
    }
}
