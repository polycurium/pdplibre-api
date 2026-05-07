<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum FlowType: string
{
    // Standard fields

    case CustomerInvoice = 'CustomerInvoice';
    case SupplierInvoice = 'SupplierInvoice';
    case StateInvoice = 'StateInvoice';
    case CustomerInvoiceLc = 'CustomerInvoiceLC'; // CDAR lifecycle
    case SupplierInvoiceLc = 'SupplierInvoiceLC'; // CDAR lifecycle
    case StateCustomerInvoiceLc = 'StateCustomerInvoiceLC'; // CDAR lifecycle
    case StateSupplierInvoiceLc = 'StateSupplierInvoiceLC'; // CDAR lifecycle
    case AggregatedCustomerTransactionReport = 'AggregatedCustomerTransactionReport';
    case UnitaryCustomerTransactionReport = 'UnitaryCustomerTransactionReport';
    case AggregatedCustomerPaymentReport = 'AggregatedCustomerPaymentReport';
    case UnitaryCustomerPaymentReport = 'UnitaryCustomerPaymentReport';
    case UnitarySupplierTransactionReport = 'UnitarySupplierTransactionReport';
    case MultiFlowReport = 'MultiFlowReport';

    // Non-standard fields

    case PendingQualification = 'PendingQualification';

    /** @return array<self> */
    public static function standardCases(): array
    {
        return \array_filter(self::cases(), static fn (self $case) => self::PendingQualification !== $case);
    }
}
