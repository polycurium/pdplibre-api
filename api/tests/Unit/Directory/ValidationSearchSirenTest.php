<?php

declare(strict_types=1);

namespace App\Tests\Unit\Directory;

use App\Common\Exception\InvalidInputException;
use App\Directory\Enum\Order;
use App\Directory\Input\SearchSirenFilters;
use App\Directory\Input\SearchSirenFiltersBusinessName;
use App\Directory\Input\SearchSirenFiltersEntityType;
use App\Directory\Input\SearchSirenFiltersSiren;
use App\Directory\Input\SearchSirenSorting;
use App\Directory\Validation\SearchSirenValidator;
use PHPUnit\Framework\TestCase;

final class ValidationSearchSirenTest extends TestCase
{
    public function testValidateWithValidFieldsFiltersAndSorting(): void
    {
        $validator = new SearchSirenValidator();

        $filters = new SearchSirenFilters();

        $sirenFilter = new SearchSirenFiltersSiren();
        $sirenFilter->siren = '123456789';

        $businessNameFilter = new SearchSirenFiltersBusinessName();
        $businessNameFilter->businessName = 'business name test';

        $filters->siren = $sirenFilter;
        $filters->businessName = $businessNameFilter;

        $sorting = new SearchSirenSorting();
        $sorting->field = 'siren';
        $sorting->order = Order::ascending;

        $sorting2 = new SearchSirenSorting();
        $sorting2->field = 'businessName';
        $sorting2->order = Order::descending;

        $validator->validate(
            [
                'siren',
                'businessName',
                'entityType',
                'administrativeStatus',
                'idInstance',
            ],
            $filters,
            [$sorting, $sorting2],
        );

        self::assertTrue(true);
    }

    public function testThrowsIfFieldIsNotString(): void
    {
        $validator = new SearchSirenValidator();

        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage(
            'fields must be an array of strings'
        );

        $validator->validate(
            [123]
        );
    }

    public function testThrowsIfFieldIsInvalid(): void
    {
        $validator = new SearchSirenValidator();

        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage(
            'Invalid field "invalid field". Allowed: siren, businessName, entityType, administrativeStatus, idInstance'
        );

        $validator->validate(
            ['invalid field', 'siren']
        );
    }

    public function testThrowsIfSirenFilterIsInvalid(): void
    {
        $validator = new SearchSirenValidator();

        $filters = new SearchSirenFilters();

        $sirenFilter = new SearchSirenFiltersSiren();
        $sirenFilter->siren = 'invalid siren';

        $filters->siren = $sirenFilter;

        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage(
            'siren must be exactly 9 digits (0-9)'
        );

        $validator->validate(
            null,
            $filters,
        );
    }

    public function testThrowsIfBusinessNameFilterIsEmpty(): void
    {
        $validator = new SearchSirenValidator();

        $filters = new SearchSirenFilters();

        $businessNameFilter = new SearchSirenFiltersBusinessName();
        $businessNameFilter->businessName = '';

        $filters->businessName = $businessNameFilter;

        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage(
            'businessName cannot be empty'
        );

        $validator->validate(
            null,
            $filters,
        );
    }

    public function testThrowsIfSortingIsInvalid(): void
    {
        $validator = new SearchSirenValidator();

        $sorting = new SearchSirenSorting();
        $sorting->field = 'invalid field';
        $sorting->order = Order::ascending;

        $this->expectException(InvalidInputException::class);

        $validator->validate(
            null,
            null,
            [$sorting],
        );
    }

    public function testThrowsIfSortingOrderIsNull(): void
    {
        $validator = new SearchSirenValidator();

        $sorting = new SearchSirenSorting();
        $sorting->field = 'siren';

        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage(
            'Sorting order must exist'
        );

        $validator->validate(
            null,
            null,
            [$sorting],
        );
    }


}
