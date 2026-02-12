<?php

namespace Modules\Shipment\Enums;

enum ShipmentStatusEnum: string
{
    case PENDING = 'PENDING'; // awaiting processing
    case PROCESSING = 'PROCESSING'; // being prepared for shipment

    case SHIPPED = 'SHIPPED'; // dispatched from warehouse
    case IN_TRANSIT = 'IN_TRANSIT'; // with carrier
    case OUT_FOR_DELIVERY = 'OUT_FOR_DELIVERY'; // with delivery agent
    case DELIVERED = 'DELIVERED'; // successfully delivered

    case FAILED = 'FAILED'; // delivery attempt failed
    case RETURNED = 'RETURNED'; // item returned by customer
    case CANCELLED = 'CANCELLED'; // shipping called before dispatch
}
