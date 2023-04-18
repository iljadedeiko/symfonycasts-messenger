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

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private PhotoPonkaficator $ponkaficator;

    private PhotoFileManager $photoManager;

    private EntityManagerInterface$entityManager;

    private ImagePostRepository $imagePostRepository;

    public function __construct(
        PhotoPonkaficator $ponkaficator,
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager,
        ImagePostRepository $imagePostRepository
    ) {
        $this->ponkaficator = $ponkaficator;
        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
    }

    public function __invoke(AddPonkaToImage $addPonkaToImage): void
    {
        $imagePostId = $addPonkaToImage->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);

        if (!$imagePost) {
            $this->logger->alert(sprintf('Image post %d was missing', $imagePostId));

            return;
        }

        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($imagePost->getFilename())
        );
        $this->photoManager->update($imagePost->getFilename(), $updatedContents);
        $imagePost->markAsPonkaAdded();

        $this->entityManager->flush();
    }
}
