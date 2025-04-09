<?php
/**
 * 配置文件
 */
return [
    // 默认分页
    'default_page_num'  => env('DEFAULT_PAGE_NUM', 1),
    'default_page_size'  => env('DEFAULT_PAGE_SIZE', 100),

    'payment_options' => [
        'Visa', 'Mastercard', 'SEPA', 'American Express', 'Debit card', 'Credit Cards', 'discover', 'iDeal',
        'Solo', 'Amex', 'ELO', 'Diners Club', 'Boleto', 'Paypal', 'Maestro', 'Bank transfer', 'Klarna',
        'Afterpay', 'Swish', 'Venmo', 'Troy', 'Stripe', 'Discover card', 'AmazonPay', 'Aura', 'Sofort', 'Caixa', 'Verse', 'Eps', 'PIX',
        'JCB', 'Bizum', 'Apple Pay'
    ]
];
