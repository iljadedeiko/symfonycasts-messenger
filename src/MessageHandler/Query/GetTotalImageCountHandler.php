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

namespace App\MessageHandler\Query;

use App\Message\Query\GetTotalImageCount;
use App\Repository\ImagePostRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetTotalImageCountHandler implements MessageHandlerInterface
{
    private ImagePostRepository $imagePostRepository;

    public function __construct(ImagePostRepository $imagePostRepository)
    {
        $this->imagePostRepository = $imagePostRepository;
    }

    public function __invoke(GetTotalImageCount $getTotalImageCount): int
    {
        return $this->imagePostRepository->getImagePostCount();
    }
}
