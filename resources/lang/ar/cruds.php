<?php

return [
    'userManagement' => [
        'title'          => 'إدارة المستخدمين',
        'title_singular' => 'إدارة المستخدمين',
    ],
    'permission' => [
        'title'          => 'الصلاحيات',
        'title_singular' => 'الصلاحية',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'المجموعات',
        'title_singular' => 'مجموعة',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'العنوان',
            'title_helper'       => ' ',
            'permissions'        => 'الصلاحيات',
            'permissions_helper' => ' ',
            'created_at'         => 'تاريخ الإنشاء',
            'created_at_helper'  => ' ',
            'updated_at'         => 'تاريخ التحديث',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'تاريخ الحذف',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'المستخدمين',
        'title_singular' => 'مستخدم',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'الإسم',
            'name_helper'              => ' ',
            'email'                    => 'البريد الإلكتروني',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'كلمة السر',
            'password_helper'          => ' ',
            'roles'                    => 'الصلاحيات',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'تاريخ الإنشاء',
            'created_at_helper'        => ' ',
            'updated_at'               => 'تاريخ التحديث',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'تاريخ الحذف',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'basicCRM' => [
        'title'          => 'إعدادات العملاء',
        'title_singular' => 'إعدادات العملاء',
    ],
    'crmStatus' => [
        'title'          => 'الحالات',
        'title_singular' => 'الحالات',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'الاسم',
            'name_helper'       => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
    ],
    'crmCustomer' => [
        'title'          => 'العملاء',
        'title_singular' => 'العملاء',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'status'             => 'الحالة',
            'status_helper'      => ' ',
            'email'              => 'الايميل',
            'email_helper'       => ' ',
            'phone'              => 'رقم الهاتف',
            'phone_helper'       => ' ',
            'address'            => 'العنوان',
            'address_helper'     => ' ',
            'description'        => 'الوصف',
            'description_helper' => ' ',
            'created_at'         => 'تاريخ الإنشاء',
            'created_at_helper'  => ' ',
            'updated_at'         => 'تاريخ التحديث',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'تاريخ الحذف',
            'deleted_at_helper'  => ' ',
            'name'               => 'الإسم',
            'name_helper'        => ' ',
            'balance'            => 'الرصيد',
        ],
    ],
    'crmNote' => [
        'title'          => 'الملاحظات',
        'title_singular' => 'الملاحظات',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'customer'          => 'العميل',
            'customer_helper'   => ' ',
            'note'              => 'الملاحظة',
            'note_helper'       => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
    ],
    'crmDocument' => [
        'title'          => 'الملفات',
        'title_singular' => 'الملفات',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'customer'             => 'العميل',
            'customer_helper'      => ' ',
            'document_file'        => 'الملف',
            'document_file_helper' => ' ',
            'name'                 => 'إسم الملفات',
            'name_helper'          => ' ',
            'description'          => 'وصف الملفات',
            'description_helper'   => ' ',
            'created_at'           => 'تاريخ الإنشاء',
            'created_at_helper'    => ' ',
            'updated_at'           => 'تاريخ التحديث',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'تاريخ الحذف',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'auditLog' => [
        'title'          => 'سجل الحركات',
        'title_singular' => 'سجل الحركات',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'description'         => 'الوصف',
            'description_helper'  => ' ',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => ' ',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => ' ',
            'user_id'             => 'User ID',
            'user_id_helper'      => ' ',
            'properties'          => 'Properties',
            'properties_helper'   => ' ',
            'host'                => 'Host',
            'host_helper'         => ' ',
            'created_at'          => 'تاريخ الإنشاء',
            'created_at_helper'   => ' ',
            'updated_at'          => 'تاريخ التحديث',
            'updated_at_helper'   => ' ',
        ],
    ],
    'city' => [
        'title'          => 'المدن',
        'title_singular' => 'المدن',
        'fields'         => [
            'id'                   => 'ID',
            'id_helper'            => ' ',
            'name'                 => 'اسم المدينة',
            'name_helper'          => ' ',
            'created_at'           => 'تاريخ الإنشاء',
            'created_at_helper'    => ' ',
            'updated_at'           => 'تاريخ التحديث',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'تاريخ الحذف',
            'deleted_at_helper'    => ' ',
            'governorate'          => 'المحافظة',
            'governorate_helper'   => ' ',
            'default_price'        => 'سعر التوصيل الإفتراضي',
            'default_price_helper' => ' ',
        ],
    ],
    'setting' => [
        'title'          => 'إعدادات',
        'title_singular' => 'إعدادات',
    ],
    'governorate' => [
        'title'          => 'المحافظات',
        'title_singular' => 'المحافظات',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'اسم المحافظة',
            'name_helper'       => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
    ],
    'post' => [
        'title'          => 'الأطردة',
        'title_singular' => 'الأطردة',
        'fields'         => [
            'id'                            => 'ID',
            'id_helper'                     => ' ',
            'delivery_price'                => 'سعر التوصيل',
            'delivery_price_helper'         => ' ',
            'customer_invoice_total'        => 'مجموع وصل المستلم',
            'customer_invoice_total_helper' => ' ',
            'governorate'                   => 'المحافظة',
            'governorate_helper'            => ' ',
            'city'                          => 'المدينة',
            'city_helper'                   => ' ',
            'delivery_address'              => 'عنوان التوصيل',
            'delivery_address_helper'       => ' ',
            'notes'                         => 'ملاحظات',
            'notes_helper'                  => ' ',
            'created_at'                    => 'تاريخ الإنشاء',
            'created_at_helper'             => ' ',
            'updated_at'                    => 'تاريخ التحديث',
            'updated_at_helper'             => ' ',
            'deleted_at'                    => 'تاريخ الحذف',
            'deleted_at_helper'             => ' ',
            'status'                        => 'حالة البريد',
            'status_helper'                 => ' ',
            'receiver_name'                 => 'اسم المستلم',
            'receiver_name_helper'          => ' ',
            'receiver_phone_number'         => 'رقم المستلم',
            'receiver_phone_number_helper'  => ' ',
            'sender'                        => 'اسم المرسل',
            'sender_helper'                 => ' ',
            'sender_total'                  => 'مجموع مبلغ المرسل',
            'sender_total_helper'           => ' ',
            'invoice'                       => 'الفاتورة التي تم حسابها فيها',
            'invoice_helper'                => ' ',
            'barcode'                       => 'الباركود',
            'barcode_helper'                => ' ',
            'delivered'                     => 'تم التوصيل',
            'rejected'                       => 'مرفوض',
        ],
    ],
    'invoice' => [
        'title'          => 'الوصولات العملاء',
        'title_singular' => 'الوصولات العملاء',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'customer'          => 'العميل',
            'customer_helper'   => ' ',
            'amount'            => 'المبلغ الواصل للعميل',
            'amount_helper'     => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
        'download' => 'تحميل الفاتورة',
        'print' => 'طباعة الفاتورة',
        'serial' => 'رقم الفاتورة',
        'date' => 'تاريخ الفاتورة',
        'seller' => 'البائع',
        'buyer' => 'العميل',
        'phone' => 'رقم الهاتف',
        'address' => 'العنوان',
        'description' => 'الوصف',
        'price' => 'سعر المنتج',
        'sub_total' => 'سعر المنتج الإجمالى',
        'total_amount' => 'إجمالى المبلغ المستحق',
        'rejected_items' => 'المنتجات المرتجعة',
        'no_customers' => 'عدد العملاء',
        'pay_until' => 'يرجى دفع الفاتورة قبل',
        'quantity' => 'الكمية',
        'status' => 'حالة البريد',
        'total_discount' => 'إجمالى المرتجع',
        'discount' => 'سعر المرتجع',
    ],
    'representative' => [
        'title'          => 'المندوبين',
        'title_singular' => 'المندوبين',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'name'                => 'اسم المندوب',
            'name_helper'         => ' ',
            'phone_number'        => 'رقم الهاتف',
            'phone_number_helper' => ' ',
            'created_at'          => 'تاريخ الإنشاء',
            'created_at_helper'   => ' ',
            'updated_at'          => 'تاريخ التحديث',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'تاريخ الحذف',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'postStatus' => [
        'title'          => 'حالات الطلبات',
        'title_singular' => 'حالات الطلبات',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'name'              => 'اسم الحالة',
            'name_helper'       => ' ',
            'created_at'        => 'تاريخ الإنشاء',
            'created_at_helper' => ' ',
            'updated_at'        => 'تاريخ التحديث',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'تاريخ الحذف',
            'deleted_at_helper' => ' ',
        ],
    ],
];
