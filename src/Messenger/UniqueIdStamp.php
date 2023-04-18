<?php

/*
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * https://www.nfq.lt
 */

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Messenger\Stamp\StampInterface;

class UniqueIdStamp implements StampInterface
{
    private string $uniqueId;

    public function __construct()
    {
        $this->uniqueId = uniqid('', true);
    }

    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}
