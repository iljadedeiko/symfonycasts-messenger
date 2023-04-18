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

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImagePostControllerTest extends WebTestCase
{
    public function testCreate(): void
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(
            __DIR__.'/../fixtures/test-picture.png',
            'test-picture.png'
        );
        $client->request('POST', '/api/images/', [], [
            'file' => $uploadedFile,
        ]);

        self::assertResponseIsSuccessful();
    }
}
