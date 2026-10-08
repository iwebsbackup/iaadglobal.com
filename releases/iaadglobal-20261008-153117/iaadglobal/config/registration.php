<?php

// Single source of truth for fees, terms and cancellation.
// Read anywhere with config('registration.…'), e.g.
//   config('registration.packages.non_residential.rows.0.prices.early')  // 12500

return [
    'gst' => 18,

    // `ends` = last day (IST) the tier applies; null = open-ended.
    'tiers' => [
        'early'   => ['label' => 'Early Bird', 'note' => 'Till 15 Oct 2026',         'ends' => '2026-10-15'],
        'regular' => ['label' => 'Regular',    'note' => '16 Oct – 30 Nov 2026',     'ends' => '2026-11-30'],
        'onspot'  => ['label' => 'On Spot',    'note' => '01 Dec 2026 onwards',      'ends' => null],
    ],

    'packages' => [

        'non_residential' => [
            'title'    => 'Non-Residential Package',
            'subtitle' => null,
            'rows'     => [
                ['category' => 'Participants',        'prices' => ['early' => 12500, 'regular' => 19500, 'onspot' => 25000]],
                ['category' => 'Accompanying Person', 'prices' => ['early' => 10000, 'regular' => 12500, 'onspot' => 15000]],
                ['category' => 'SAARC AAD Member',    'prices' => ['early' => 9000,  'regular' => 16000, 'onspot' => 22500]],
                ['category' => 'Post Graduate Student', 'prices' => ['early' => 7500,  'regular' => 7500,  'onspot' => 7500]],
                ['category' => 'Any Workshop',        'flat' => 5500],
            ],
            'includes' => [
                'Conference Lunch & High Tea / Coffee on Sunday & Monday (20 & 21 Dec 2026)',
                'Conference Registration Kit',
                'Visit to Trade Exhibition',
            ],
        ],

        'residential' => [
            'title'    => 'Residential Package (3 Nights & 4 Days)',
            'subtitle' => 'Check-in: 19 December 2026 · Check-out: 22 December 2026',
            'rows'     => [
                ['category' => 'Single Occupancy',                          'prices' => ['early' => 59000, 'regular' => 64000, 'onspot' => 70000]],
                ['category' => 'Double Occupancy With Accompanying Person', 'prices' => ['early' => 69000, 'regular' => 76500, 'onspot' => 85000]],
            ],
            'includes' => [
                'Breakfast on Sunday, Monday & Tuesday (20, 21 & 22 Dec 2026)',
                'Conference Lunch & High Tea / Coffee on Sunday & Monday (20 & 21 Dec 2026)',
                'Conference Gala Dinner on Sunday 20 Dec 2026 & Farewell Dinner on Monday 21 Dec 2026',
                'Conference Registration Kit',
                'Visit to Trade Exhibition',
            ],
        ],
    ],

    'workshops' => [
        'AI in Dermatology: A Unique Concept',
        'Botulinum Toxin A – Upper Face',
        'Botulinum Toxin A – Lower Face',
        'Contour Threads',
        'Fillers (Mid Face)',
        'Fillers (Lower Face)',
        'Hydrobooster',
        'Mastering Injectables with Simulation Models (Digital Cadaver Table + Face Simulation Models)',
    ],

    'terms' => [
        'It is mandatory for each delegate to fill the online registration form.',
        'The registration will be confirmed within 30 days of receipt of payment in bank.',
        'Confirmation of the registration will be sent to the registered email ID.',
        'PG students are required to upload a Letter of HOD.',
        'Online transaction charges will be applied according to the guidelines of the concerned bank. Transaction charges are to be borne by delegates.',
        'A valid photo identification card is mandatory at the entrance of the conference area.',
        'A confirmation email containing your Registration Receipt/ID will be sent to all registered delegates.',
        'Please note that the registration fee excludes 18% GST (Goods and Services Tax).',
        'For any card payment, an additional fee will be charged as per the bank policy.',
        'Refund includes only the registration base amount and does not include GST & card payment charges.',
        'Should you have any inquiries or encounter any difficulties during the registration process, please reach out to the Professional Conference Organizer.',
    ],

    'payment_note' => 'Transactions conducted through the online payment gateway options are subject to a handling fee. This charge encompasses platform handling fees, payment gateway charges and convenience fees.',

    // NOTE: confirm wording with the organisers (source text was ambiguous).
    'cancellation' => [
        ['when' => 'Up to 15 Oct 2026',  'refund' => '75%',       'note' => 'of the registration amount paid'],
        ['when' => 'Up to 15 Nov 2026',  'refund' => '50%',       'note' => 'of the registration amount paid'],
        ['when' => 'After 01 Dec 2026',  'refund' => 'No refund', 'note' => null],
    ],

    'cancellation_notes' => [
        'All cancellations must be made in writing and sent to the DiCD 2026 Helpdesk.',
        'The refund process will begin only 30 days after the completion of the conference.',
    ],
];
