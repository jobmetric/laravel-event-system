<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Event System Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Event System for
    | various messages that we need to display to the user.
    |
    */

    "validation" => [
        "class_exist" => "کلاس ':class' وجود ندارد.",
    ],

    "messages" => [
        "created" => "رویداد با موفقیت ایجاد شد.",
        "deleted" => "رویداد با موفقیت حذف شد.",
        "change_status" => "وضعیت رویداد با موفقیت تغییر کرد.",
    ],

    "exceptions" => [
        "event_system_by_name_not_found" => "سیستم رویداد با نام :name یافت نشد.",
        "event_system_not_found" => "سیستم رویداد با شماره :number یافت نشد.",
    ],

    "fields" => [
        "name" => "نام",
        "description" => "توضیحات",
        "event" => "رویداد",
        "listener" => "شنونده",
        "priority" => "اولویت",
        "status" => "وضعیت",
    ],

    'events' => [
        'event_system_deleted' => [
            'group' => 'سیستم رویداد',
            'title' => 'حذف سیستم رویداد',
            'description' => 'هنگامی که یک سیستم رویداد حذف می‌شود، این رویداد فعال می‌شود.',
            'tags' => ['سیستم رویداد', 'حذف', 'مدیریت'],
        ],

        'event_system_deleting' => [
            'group' => 'سیستم رویداد',
            'title' => 'در حال حذف سیستم رویداد',
            'description' => 'هنگامی که یک سیستم رویداد در حال حذف است، این رویداد فعال می‌شود.',
            'tags' => ['سیستم رویداد', 'حذف', 'مدیریت'],
        ],

        'event_system_stored' => [
            'group' => 'سیستم رویداد',
            'title' => 'ذخیره سیستم رویداد',
            'description' => 'هنگامی که یک سیستم رویداد ذخیره می‌شود، این رویداد فعال می‌شود.',
            'tags' => ['سیستم رویداد', 'ذخیره‌سازی', 'مدیریت'],
        ],
    ],

];
