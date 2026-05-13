<?php

declare(strict_types=1);

namespace App\Tests\Application\Directory;

use App\Directory\Doctrine\Entity\LegalUnitPayloadHistory;
use App\Directory\Enum\EntityType;
use App\Directory\Enum\LegalUnitAdministrativeStatus;
use App\Directory\Enum\Order;
use App\Directory\Input\SearchSirenSorting;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SearchSirenTest extends WebTestCase
{
// TODO
//    public function testSearchSiren(): void
//    {
//        $client = self::createClient();
//        $container = self::getContainer();
//
//        $em = $container->get('doctrine')->getManager();
//
//        $em->createQuery('DELETE FROM App\Directory\Doctrine\Entity\LegalUnitPayloadHistory e')
//            ->execute();
//
//        $entity = LegalUnitPayloadHistory::create(
//            idInstance: 1,
//            siren: '123456789',
//            businessName: 'test business name',
//            entityType: EntityType::Public,
//            administrativeStatus: LegalUnitAdministrativeStatus::A,
//        );
//
//        $em->persist($entity);
//        $em->flush();
//
//        $client->request(
//            'POST',
//            '/v1/siren/search',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json'],
//            json_encode([
//                'filters' => [
//                    'businessName' => [
//                        'businessName' => 'test business name',
//                    ],
//                ],
//            ])
//        );
//
//        self::assertResponseIsSuccessful();
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        self::assertSame(25, $response['limit']);
//
//        self::assertSame(1, $response['results'][0]['idInstance']);
//        self::assertSame('123456789', $response['results'][0]['siren']);
//        self::assertSame('test business name', $response['results'][0]['businessName']);
//        self::assertSame('Public', $response['results'][0]['entityType']);
//        self::assertSame('A', $response['results'][0]['administrativeStatus']);
//    }
//
//    public function testSearchSirenWithFields(): void
//    {
//        $client = self::createClient();
//        $container = self::getContainer();
//
//        $em = $container->get('doctrine')->getManager();
//
//        $em->createQuery('DELETE FROM App\Directory\Doctrine\Entity\LegalUnitPayloadHistory e')
//            ->execute();
//
//        $entity = LegalUnitPayloadHistory::create(
//            idInstance: 1,
//            siren: '123456789',
//            businessName: 'test business name',
//            entityType: EntityType::Public,
//            administrativeStatus: LegalUnitAdministrativeStatus::A,
//        );
//
//        $em->persist($entity);
//        $em->flush();
//
//        $client->request(
//            'POST',
//            '/v1/siren/search',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json'],
//            json_encode([
//                'fields' => [
//                    'siren',
//                    'businessName',
//                ],
//                'filters' => [
//                    'businessName' => [
//                        'businessName' => 'test business name',
//                    ],
//                ],
//            ])
//        );
//
//        self::assertResponseIsSuccessful();
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        self::assertCount(1, $response['results']);
//
//        self::assertArrayNotHasKey('idInstance', $response['results'][0]);
//        self::assertSame('123456789', $response['results'][0]['siren']);
//        self::assertSame('test business name', $response['results'][0]['businessName']);
//        self::assertArrayNotHasKey('entityType', $response['results'][0]);
//        self::assertArrayNotHasKey('administrativeStatus', $response['results'][0]);
//    }
//    public function testSearchSirenWithSorting(): void
//    {
//        $client = self::createClient();
//        $container = self::getContainer();
//
//        $em = $container->get('doctrine')->getManager();
//
//        $em->createQuery('DELETE FROM App\Directory\Doctrine\Entity\LegalUnitPayloadHistory e')
//            ->execute();
//
//        $entity = LegalUnitPayloadHistory::create(
//            idInstance: 1,
//            siren: '123456789',
//            businessName: 'test business name',
//            entityType: EntityType::Public,
//            administrativeStatus: LegalUnitAdministrativeStatus::A,
//        );
//
//        $em->persist($entity);
//        $em->flush();
//
//        $sorting = new SearchSirenSorting();
//        $sorting->field = 'siren';
//        $sorting->order = Order::ascending;
//
//        $client->request(
//            'POST',
//            '/v1/siren/search',
//            [],
//            [],
//            ['CONTENT_TYPE' => 'application/json'],
//            json_encode([
//                'filters' => [
//                    'businessName' => [
//                        'businessName' => 'test business name',
//                    ],
//                ],
//                'sorting' => [$sorting]
//            ])
//        );
//
//        self::assertResponseIsSuccessful();
//
//        $response = json_decode($client->getResponse()->getContent(), true);
//
//        self::assertCount(1, $response['results']);
//
//        self::assertSame(1, $response['results'][0]['idInstance']);
//        self::assertSame('123456789', $response['results'][0]['siren']);
//        self::assertSame('test business name', $response['results'][0]['businessName']);
//        self::assertSame('Public', $response['results'][0]['entityType']);
//        self::assertSame('A', $response['results'][0]['administrativeStatus']);
//    }
//    public function testNoResult(): void
//    {
//
//    }
}
