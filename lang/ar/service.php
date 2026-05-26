<?php

return [
    'cannot_edit_suspended' => 'لا يمكن تعديل خدمة معلقة.',
    'quantity_below_reserved' => 'لا يمكن تخفيض الكمية إلى أقل من :reserved وحدة محجوزة.',
    'cannot_make_unlimited_with_requests' => 'لا يمكن تحويل خدمة محدودة إلى غير محدودة لأن هناك طلبات معلقة أو مقبولة مرتبطة بها.',
    'cannot_delete_with_requests' => 'لا يمكن حذف الخدمة لأن هناك طلبات مرتبطة بها.',
    'cannot_approve_non_pending' => 'لا يمكن قبول الخدمة إلا إذا كانت في حالة "قيد المراجعة".',
    'cannot_reject_non_pending' => 'لا يمكن رفض الخدمة إلا إذا كانت في حالة "قيد المراجعة".',
    'cannot_suspend_not_approved' => 'لا يمكن تعليق الخدمة إلا إذا كانت مقبولة.',
    'cannot_reactivate_not_suspended' => 'لا يمكن إعادة تنشيط الخدمة إلا إذا كانت معلقة.',
    'cannot_reactivate_quantity_exceeded' => 'لا يمكن إعادة تنشيط الخدمة لأن الكمية المحجوزة (:reserved) تتجاوز الكمية الإجمالية (:available).',
    'missing_required_fields' => 'الحقول المطلوبة التالية ناقصة: :fields',
    'field_required' => 'الحقل :field مطلوب.',
    'invalid_option' => 'القيمة المحددة للحقل :field غير صالحة.',
    'created' => 'تم إنشاء الخدمة بنجاح، وهي تنتظر المراجعة.',
    'updated' => 'تم تحديث الخدمة بنجاح.',
    'resubmitted_for_review' => 'تم تحديث الخدمة وإعادة إرسالها للمراجعة.',
    'deleted' => 'تم حذف الخدمة بنجاح.',
    'list_retrieved' => 'تم جلب قائمة الخدمات بنجاح.',
    'retrieved' => 'تم جلب بيانات الخدمة بنجاح.',
];
