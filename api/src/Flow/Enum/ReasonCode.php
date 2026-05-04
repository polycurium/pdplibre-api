<?php

declare(strict_types=1);

namespace App\Flow\Enum;

enum ReasonCode: string
{
    /** One or more attachments are empty. (ie IRR_VID_PJ) */
    case EmptyAttachement = 'EmptyAttachement';

    /** The type and/or extension of one or more attachments is not compliant. (ie IRR_EXT_DOC) */
    case AttachmentTypeError = 'AttachmentTypeError';

    /** The binary flow is empty. (ie IRR_VID_F) */
    case EmptyFlow = 'EmptyFlow';

    /** Other technical error. (ie AUTRE) */
    case OtherTechnicalError = 'OtherTechnicalError';

    /** Invalid XML schema. (ie IRR_SYNTAX) */
    case InvalidSchema = 'InvalidSchema';

    /** File size limit reached. (ie IRR_TAILLE_F) */
    case FileSizeExceeded = 'FileSizeExceeded';

    /** The flow type and/or extension are not compliant. (ie IRR_TYPE_F) */
    case FlowTypeError = 'FlowTypeError';

    /** The flow has already been sent and received. (ie N/A) */
    case AlreadyExistingFlow = 'AlreadyExistingFlow';

    /** Presence of a virus. (ie IRR_ANTIVIRUS) */
    case VirusFound = 'VirusFound';

    /** Checksum provided is different from computed one */
    case ChecksumMismatch = 'ChecksumMismatch';

    /** One or more statuses are inconsistent */
    case InvoiceLCInvalidStatus = 'InvoiceLCInvalidStatus';

    /** One or more statuses are incorrect or not allowed */
    case InvoiceLCStatusError = 'InvoiceLCStatusError';

    /** One or more rules are not matched */
    case InvoiceLCRuleError = 'InvoiceLCRuleError';

    /** One of the request is not authorized and requests permissions */
    case InvoiceLCAccessDenied = 'InvoiceLCAccessDenied';

    /** One or more amounts are not consistent in regards to the VAT */
    case InvoiceLCAmountError = 'InvoiceLCAmountError';
}
