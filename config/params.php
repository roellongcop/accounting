<?php

return [
    'user.passwordResetTokenExpire' => 3600,
    'pagination' => [25 => 25, 50 => 50, 75 => 75, 100 => 100],
    'receivable_status' => [
        0 => ['id' => 0, 'label' => 'Un-Paid', 'class' => 'warning'],
        1 => ['id' => 1, 'label' => 'Partially Paid', 'class' => 'primary'],
        2 => ['id' => 2, 'label' => 'Fully Paid', 'class' => 'success'],
    ],
    'payable_status' => [
        0 => ['id' => 0, 'label' => 'Un-Paid', 'class' => 'warning'],
        1 => ['id' => 1, 'label' => 'Partial Paid', 'class' => 'primary'],
        2 => ['id' => 2, 'label' => 'Fully Paid', 'class' => 'success'],
    ],
    'cash_flow_statuses' => [
        0 => ['id' => 0, 'label' => 'Pending', 'class' => 'warning'],
        1 => ['id' => 1, 'label' => 'Completed', 'class' => 'success'],
    ],
    'cash_flow_types' => [
        0 => ['id' => 0, 'label' => 'Account Payable', 'class' => 'default'],
        1 => ['id' => 1, 'label' => 'Account Receivable', 'class' => 'primary'],
    ],
    'genders' => [
        'male' => ['id' => 'male', 'label' => 'Male', 'class' => 'primary'],
        'female' => ['id' => 'female', 'label' => 'Female', 'class' => 'danger'],
        'other' => ['id' => 'other', 'label' => 'Other', 'class' => 'warning'],
    ],
    'record_status' => [
        0 => ['id' => 0, 'label' => 'In-active', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Active', 'class' => 'success'],
    ],
    'ip_types' => [
        0 => ['id' => 0, 'label' => 'Black List', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'White List', 'class' => 'danger'],
    ],
    'notification_status' => [
        0 => ['id' => 0, 'label' => 'New', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Read', 'class' => 'success'],
    ],
    'notification_types' => [
        0 => ['id' => 0, 'type' => 'notification_change_password', 'label' => 'Password Changed']
    ],
    'user_status' => [
        0 => ['id' => 0, 'label' => 'Archived', 'class' => 'danger'],
        9 => ['id' => 9, 'label' => 'Not Verified', 'class' => 'warning'],
        10 => ['id' => 10, 'label' => 'Active', 'class' => 'success'],
    ],
    'user_block_status' => [
        0 => ['id' => 0, 'label' => 'Allowed', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Blocked', 'class' => 'danger'],
    ],
    'visit_log_actions' => [
        0 => ['id' => 0, 'label' => 'Login', 'class' => 'success'],
        1 => ['id' => 1, 'label' => 'Logout', 'class' => 'danger'],
    ],
    'whitelist_ip_only' => [
        0 => ['id' => 0, 'label' => 'All', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Whitelist Only', 'class' => 'success'],
    ],
    'enable_visitor' => [
        0 => ['id' => 0, 'label' => 'Disable', 'class' => 'danger'],
        1 => ['id' => 1, 'label' => 'Enable (require internet connection)', 'class' => 'success'],
    ],
    'months' => [
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ]
];