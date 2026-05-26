<?php

return [
    'cannot_edit_suspended' => 'Cannot edit a suspended service.',
    'quantity_below_reserved' => 'Cannot reduce quantity below :reserved reserved units.',
    'cannot_make_unlimited_with_requests' => 'Cannot convert a limited service to unlimited because there are pending or accepted requests associated with it.',
    'cannot_delete_with_requests' => 'Cannot delete the service because there are requests associated with it.',
    'cannot_approve_non_pending' => 'Cannot approve a service unless it is pending.',
    'cannot_reject_non_pending' => 'Cannot reject a service unless it is pending.',
    'cannot_suspend_not_approved' => 'Cannot suspend a service unless it is approved.',
    'cannot_reactivate_not_suspended' => 'Cannot reactivate a service unless it is suspended.',
    'cannot_reactivate_quantity_exceeded' => 'Cannot reactivate the service because reserved quantity (:reserved) exceeds total quantity (:available).',
    'missing_required_fields' => 'The following required fields are missing: :fields',
    'field_required' => 'The :field field is required.',
    'invalid_option' => 'The selected value for :field is invalid.',
    'created' => 'Service created successfully and is pending review.',
    'updated' => 'Service updated successfully.',
    'resubmitted_for_review' => 'Service updated and resubmitted for review.',
    'deleted' => 'Service deleted successfully.',
    'list_retrieved' => 'Services list retrieved successfully.',
    'retrieved' => 'Service details retrieved successfully.',
];
