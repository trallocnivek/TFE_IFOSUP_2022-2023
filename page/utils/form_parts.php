<?php
	// VARIABLES
	$var_list = ['robot', 'pseudo', 'firstname', 'lastname', 'email', 'password', 'descr_fr', 'descr_nl', 'descr_en', 'descr_de', 'descr_default', 'login', 'url'];
	$var_list_check_false = ['check_sold_out', 'check_closed', 'check_cancel', 'check_diary', 'check_gallery', 'check_demos'];
	$var_list_check_true = ['check_conditions', 'check_active'];
    $var_list_date = ['birthday'];
	foreach($var_list as $v) if(!isset(${$v})) ${$v} = '';
	foreach($var_list_check_false as $v) if(!isset(${$v})) ${$v} = false;
	foreach($var_list_check_true as $v) if(!isset(${$v})) ${$v} = true;
    foreach($var_list_date as $v) if(!isset(${$v})) ${$v} = '2019-01-01';
	// FORM_DATA
	$required = [
        'tag' => 'p',
        'attr' => ['class' => 'form-group required bold red'],
        'content' => $site->txt('form/require')
    ];
    $data_block = [
        'tag' => 'div',
        'attr' => ['class' => 'form-group']
    ];
	// LABEL_INPUT_BLOCK
	// # pseudo
	$input_pseudo = [
		'pseudo' => [
            'label' => $site->txt('word_pseudo') . ' :',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: @Pseudo#123',
                'class' => 'form-control',
                'value' => $pseudo,
                'oninput' => "verif_regexp('pseudo', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => 5,
                    'max' => 30
                ],
                'char' => [
                	'upper' => 1,
                	'lower' => 1,
                	'punct' => 1
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/pseudo')
            ],
            'autofocus'
        ]
    ];
    $input_login = [
        'login' => [
            'label' => $site->txt('word_login') . ' :',
            'input' => [
                'type' => 'text',
                'placeholder' => $site->txt('placeholder_login'),
                'class' => 'form-control',
                'value' => $login
            ],
            'infos' => [
                'count' => [
                    'min' => '1',
                    'max' => '60'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/login')
            ],
            'required',
            'autofocus'
        ]
    ];
    // # firstname & lastname
    $input_firstname = [
    	'firstname' => [
            'label' => $site->txt('word_firstname') . ' :',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: John',
                'class' => 'form-control',
                'value' => $firstname,
                'oninput' => "verif_regexp('firstname', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '1',
                    'max' => '60'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/firstname')
            ],
            'required'
        ]
    ];
    $input_lastname = [
    	'lastname' => [
            'label' => $site->txt('word_lastname') . ' :',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: Doe',
                'class' => 'form-control',
                'value' => $lastname,
                'oninput' => "verif_regexp('lastname', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '1',
                    'max' => '60'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/lastname')
            ],
            'required'
        ]
    ];
    $input_name = [
        'name' => [
            'label' => $site->txt('word_name') . ' :',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: John Doe',
                'class' => 'form-control'
            ],
            'infos' => [
                'count' => [
                    'min' => '1',
                    'max' => '60'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/name')
            ],
            'required',
            'autofocus'
        ]
    ];
    // # email
    $input_email = [
    	'email' => [
            'label' => $site->txt('word_mail') . ' :',
            'input' => [
                'type' => 'email',
                'placeholder' => 'ex: john.doe@mail.com',
                'class' => 'form-control',
                'value' => $email,
                'oninput' => "verif_regexp('email', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '6',
                    'max' => '255'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/email')
            ],
            'required'
        ]
    ];
    // # password & confirm
    $input_password = [
    	'password' => [
            'label' => $site->txt('word_password') . ' :',
            'input' => [
                'type' => 'password',
                'placeholder' => 'ex: password password ...',
                'class' => 'form-control',
                'value' => $password,
                'oninput' => "verif_regexp('password', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '6',
                    'max' => '255'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/password')
            ],
            'required'
        ]
    ];
    $input_pass_and_confirm = [
    	'password' => [
            'label' => $site->txt('word_password') . ' :',
            'input' => [
                'type' => 'password',
                'placeholder' => 'ex: password password ...',
                'class' => 'form-control',
                'value' => $password,
                'oninput' => "verif_regexp('password', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '6',
                    'max' => '255'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/password')
            ],
            'required'
        ],
        'confirm' => [
            'label' => $site->txt('word_confirm') . ' :',
            'input' => [
                'type' => 'password',
                'placeholder' => 'ex: confirm password ...',
                'class' => 'form-control',
                'value' => '',
                'oninput' => "verif_regexp('confirm', this);"
            ],
            'infos' => [
                'count' => [
                    'min' => '6',
                    'max' => '255'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/confirm')
            ],
            'required'
        ]
    ];
    // # create elem
    // # @ title db
   	$input_db_title_elem = [
   		'db_elem_title' => [
   			'label' => 'db_title_elem : ',//$site->txt(''),
   			'input' => [
   				'type' => 'text',
   				'placeholder' => 'ex: txt_no_space',
   				'class' => 'form-control',
                // 'oninput' => "verif_regexp('db_title_elem', this);"
   			],
   			'infos' => [],
   			'required'
   		]
   	];
    $input_url = [
        'url' => [
            'label' => 'url : ', //$site->txt('word_url'),
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: ?page=page_name&mode=admin&action=create',
                'class' => 'form-control'
            ],
            'required',
            'infos' => []
        ]
    ];
   	$input_date = [
   		'date' => [
   			'label' => 'date : ',//$site->txt(''),
   			'input' => [
   				'type' => 'date',
   				'class' => 'form-control'
   			],
   			'infos' => [],
   			'required'
   		]
   	];
   	$input_birthday = [
   		'birthday' => [
   			'label' => 'birthday : ',//$site->txt(''),
   			'input' => [
   				'type' => 'date',
   				'class' => 'form-control',
                'value' => $birthday
   			],
   			'infos' => []
   		]
   	];
    $input_hour = [
   		'hour' => [
   			'label' => 'hour',//$site->txt(''),
   			'input' => [
   				'type' => 'time',
   				'class' => 'form-control'
   			],
   			'infos' => [],
   			'required'
   		]
   	];
    $input_price = [
   		'price' => [
   			'label' => 'price',//$site->txt(''),
   			'input' => [
   				'type' => 'text',
   				'placeholder' => 'ex: %{ entry = 0.0€ }%, %{ presale = 0.0€ }%',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];
   	// 
    $input_tel = [
        'format_tel' => [
            'label' => [
                'attr' => ['class' => 'select_tel'],
                'content' => 'format tel : '
            ],
            'select' => [
                'attr' => ['class' => 'form-control select_tel'],
                'content' => [
                    ['attr' => ['value' => '+32', 'selected'], 'content' => 'BE: +32'],
                    ['attr' => ['value' => '+33'], 'content' => 'FR: +33'],
                    ['attr' => ['value' => '+44'], 'content' => 'EN: +44'],
                    ['attr' => ['value' => '+49'], 'content' => 'DE: +49'],
                    ['attr' => ['value' => 'x'], 'content' => '-- autre --'],
                ]
            ]
        ],
   		'tel' => [
   			'label' => [
                'attr' => ['class' => 'select_tel'],
                'content' => $site->txt('word_tel') . ' : ',
            ],
   			'input' => [
   				'type' => 'tel',
   				'placeholder' => 'ex: 012/34.56.78',
   				'class' => 'input_tel'
   			],
   			'infos' => []
   		]
   	];
    $input_gsm = [
        'format_gsm' => [
            'label' => [
                'attr' => ['class' => 'select_tel'],
                'content' => 'format gsm : '
            ],
            'select' => [
                'attr' => ['class' => 'form-control select_tel'],
                'content' => [
                    ['attr' => ['value' => '+32', 'selected'], 'content' => 'BE: +32'],
                    ['attr' => ['value' => '+33'], 'content' => 'FR: +33'],
                    ['attr' => ['value' => '+44'], 'content' => 'EN: +44'],
                    ['attr' => ['value' => '+49'], 'content' => 'DE: +49'],
                    ['attr' => ['value' => 'x'], 'content' => '-- autre --'],
                ]
            ]
        ],
   		'gsm' => [
   			'label' => [
                'attr' => ['class' => 'select_tel'],
                'content' => $site->txt('word_gsm') . ' : ',
            ],
   			'input' => [
   				'type' => 'tel',
   				'placeholder' => 'ex: 0123/45.67.89',
   				'class' => 'input_tel'
   			],
   			'infos' => []
   		]
   	];
    $input_google_map = [
   		'google_map' => [
   			'label' => $site->txt('word_googlemap'),
   			'input' => [
   				'type' => 'url',
   				'placeholder' => 'ex: https://goo.gl/maps/psDs84bJFBkW3gVn8',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];
    $input_street = [
        'street' => [
            'label' => $site->txt('word_street') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: des hirondelles',
                'class' => 'form-control'
            ]
        ]
    ];
    $input_numero = [
        'numero' => [
            'label' => [
                'attr' => ['class' => 'label_addr_num'],
                'content' => $site->txt(175) . ' : '
            ],
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: 22',
                'class' => 'input_addr_num',
                'value' => ''
            ]
        ],
        'bte' => [
            'label' => [
                'attr' => ['class' => 'label_addr_num'],
                'content' => $site->txt('word_bte') . ' : '
            ],
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: A',
                'class' => 'input_addr_bte',
                'value' => ''
            ]
        ]
    ];
    $input_town = [
        'town' => [
            'label' => $site->txt('word_town') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: Hoeilaart',
                'class' => 'form-control'
            ]
        ]
    ];
    $input_cp = [
        'cp' => [
            'label' => $site->txt('word_cp') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: 1350',
                'class' => 'form-control'
            ]
        ]
    ];
    $input_land = [
        'land' => [
            'label' => $site->txt('word_land') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: Belgique',
                'class' => 'form-control'
            ]
        ]
    ];
    $input_district = [
        'district' => [
            'label' => $site->txt('word_district') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: Vlaamsbrabant',
                'class' => 'form-control'
            ]
        ]
    ];
    $input_poster = [
   		'poster' => [
   			'label' => 'poster',//$site->txt(''),
   			'input' => [
   				'type' => 'file',
   				'placeholder' => 'ex: file.ext',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];
   /* $input_gallery = [
   		'gallery' => [
   			'label' => 'price',//$site->txt(''),
   			'select' => [
   				'type' => 'url',
   				'placeholder' => 'ex: ',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];*/
   	// description fr nl en de
   	// select id event planner
    $input_planner = [
   		'planner' => [
   			'label' => 'event planner',//$site->txt(''),
   			'input' => [
   				'type' => 'text',
   				'placeholder' => 'ex: ',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];
    $input_metier = [
        'metier' => [
            'label' => $site->txt('word_job') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: ',
                'class' => 'form-control'
            ],
            'infos' => []
        ]
    ];
    $input_instru = [
        'instru' => [
            'label' => $site->txt('word_instru') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: batterie',
                'class' => 'form-control'
            ],
            'infos' => []
        ]
    ];
    $input_functions = [
        'functions' => [
            'label' => $site->txt('word_function') . ' : ',
            'input' => [
                'type' => 'text',
                'placeholder' => 'ex: webmaster',
                'class' => 'form-control'
            ],
            'infos' => []
        ]
    ];
    $input_reservation = [
   		'reverv' => [
   			'label' => 'reservation',//$site->txt(''),
   			'input' => [
   				'type' => 'url',
   				'placeholder' => 'ex: url',
   				'class' => 'form-control'
   			],
   			'infos' => []
   		]
   	];
    $input_check_soldout_closed_canceled = [
   		'sold_out' => [
   			'label' => 'sold out',//$site->txt(''),
   			'input' => [
   				'type' => 'checkbox'
   			],
   			'infos' => []
   		],
   		'closed' => [
   			'label' => 'closed',//$site->txt(''),
   			'input' => [
   				'type' => 'checkbox'
   			],
   			'infos' => []
   		],
   		'canceled' => [
   			'label' => 'canceled',//$site->txt(''),
   			'input' => [
   				'type' => 'checkbox'
   			],
   			'infos' => []
   		]
   	];
   	if($check_sold_out) $input_check_soldout_closed_canceled['sold_out']['input'][] = 'checked';
   	if($check_closed) 	$input_check_soldout_closed_canceled['closed']['input'][] = 'checked';
   	if($check_cancel) 	$input_check_soldout_closed_canceled['cancel']['input'][] = 'checked';
    $input_check_news = [
        'event' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => 'événement' . ' :'
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
            ]
        ],
        'gallery' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => 'galerie' . ' :'
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
            ]
        ],
        'demos' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => 'démos' . ' :'
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
           ]
        ]
    ];
    $conditions_check = [
        'conditions' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => HTML::get('tag', [
                    'tag' => 'a', 'attr' => ['href' => './?page=conditions'], 'content' => $site->txt('form_conditions') . ' :']
                )
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
            ],
            'required'
        ]
    ];
    $news_check = [
        'news_active' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => /*$site->txt(232) . */'newsletter : '
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
            ]
        ]
    ];
    $active_check = [
        'page_active' => [
            'label' => [
                'attr' => ['class' => 'checkbox'],                
                'content' => /*$site->txt(232) . */'active : '
            ],
            'input' => [
                'type' => 'checkbox',
                'class' => 'form-control checkbox'
            ]
        ]
    ];
   	if($check_conditions) $conditions['input'][] = 'checked';
    if($check_diary) $input_check_news['event']['input'][] = 'checked';
    if($check_gallery) $input_check_news['gallery']['input'][] = 'checked';
    if($check_demos) $input_check_news['demos']['input'][] = 'checked';
    if($active_check) $active_check['page_active']['input'][] = 'checked';
    // LABEL_TEXTAREA_BLOCK
    $description = [
   		'descr_fr' => [
   			'label' => 'description fr',//$site->txt(''),
   			'textarea' => [
   				'attr' => [
   					'placeholder' => 'ex: ',
   					'class' => 'form-control',
   					'cols' => 30,
   					'rows' => 10
   				],
   				'content' => $descr_fr
   			],
   			'infos' => []
   		],
   		'descr_nl' => [
   			'label' => 'description nl',//$site->txt(''),
   			'textarea' => [
   				'attr' => [
   					'placeholder' => 'ex: ',
   					'class' => 'form-control',
   					'cols' => 30,
   					'rows' => 10
   				],
   				'content' => $descr_nl
   			],
   			'infos' => []
   		],
   		'descr_en' => [
   			'label' => 'description en',//$site->txt(''),
   			'textarea' => [
   				'attr' => [
   					'placeholder' => 'ex: ',
   					'class' => 'form-control',
   					'cols' => 30,
   					'rows' => 10
   				],
   				'content' => $descr_en
   			],
   			'infos' => []
   		],
   		'descr_de' => [
   			'label' => 'description de',//$site->txt(''),
   			'textarea' => [
   				'attr' => [
   					'placeholder' => 'ex: ',
   					'class' => 'form-control',
   					'cols' => 30,
   					'rows' => 10
   				],
   				'content' => $descr_de
   			],
   			'infos' => []
   		]
   	];
   	$simple_descr = [
   		'description' => [
   			'label' => 'description : ',//$site->txt(''),
   			'textarea' => [
   				'attr' => [
   					'placeholder' => 'ex: ',
   					'class' => 'form-control',
   					'cols' => 30,
   					'rows' => 10
   				],
   				'content' => $descr_default
   			],
   			'infos' => []
   		]
   	];
    $textarea_groups = [
        'groups' => [
            'label' => $site->txt('word_groups') . ' : ',
            'textarea' => [
                'attr' => [
                    'placeholder' => 'ex: ',
                    'class' => 'form-control',
                    'cols' => 30,
                    'rows' => 10
                ],
                'content' => ''
            ],
            'infos' => []
        ]
    ];
    $textarea_website = [
        'website' => [
            'label' => $site->txt(169) . ' : ',
            'textarea' => [
                'attr' => [
                    'placeholder' => 'ex: https//:www.website.be',
                    'class' => 'form-control',
                    'cols' => 30,
                    'rows' => 10
                ],
                'content' => ''
            ],
            'infos' => []
        ]
    ];
    $textarea_msg = [
        'msg' => [
            'label' => $site->txt('word_msg') . ' :',
            'textarea' => [
                'attr' => [
                    'placeholder' => $site->txt('word_msg') . ' ...',
                    'class' => 'form-control',
                    'cols' => 30,
                    'rows' => 10
                ],
                // 'content' => 'test'
            ],
            'infos' => [
                'count' => [
                    'min' => '6',
                    'max' => '255'
                ]//,
                // 'valid' => $site->txt('form/valid'),
                // 'invalid' => $site->txt('form/invalid/email')
            ],
            'required'
        ]
    ];
    // LABEL_SELECT_BLOCK
    $select_lang = [
        'lang' => [
            'label' => 'lang :',
            'select' => [
                'attr' => ['class' => 'form-control'],
                'content' => [
                    ['attr' => ['value' => 'de'], 'content' => 'Deutsche'],
                    ['attr' => ['value' => 'en'], 'content' => 'English'],
                    ['attr' => ['value' => 'fr'], 'content' => 'Français'],
                    ['attr' => ['value' => 'nl', 'selected'], 'content' => 'Nederlands']
                ]
            ]
        ]
    ];
    $select_sexe = [
        'sexe' => [
            'label' => 'sexe : ',
            'select' => [
                'attr' => ['class' => 'form-control'],
                'content' => [
                    ['attr' => ['value' => 'x', 'selected'], 'content' => '-- choisir --'],
                    ['attr' => ['value' => 'f'], 'content' => 'femme'],
                    ['attr' => ['value' => 'h'], 'content' => 'homme'],
                ]
            ]
        ]
    ];
    $select_format_tel = [
        'format_tel' => [
            'label' => 'format tel : ',
            'select' => [
                'attr' => ['class' => 'form-control'],
                'content' => [
                    ['attr' => ['value' => 'be', 'selected'], 'content' => 'BE: +32'],
                    ['attr' => ['value' => 'fr'], 'content' => 'FR: +33'],
                    ['attr' => ['value' => 'en'], 'content' => 'EN: +44'],
                    ['attr' => ['value' => 'de'], 'content' => 'DE: +49'],
                    ['attr' => ['value' => 'x'], 'content' => '-- autre --'],
                ]
            ]
        ]
    ];
    $select_format_gsm = [
        'format_gsm' => [
            'label' => 'format gsm : ',
            'select' => [
                'attr' => ['class' => 'form-control'],
                'content' => [
                    ['attr' => ['value' => 'be', 'selected'], 'content' => 'BE: +32'],
                    ['attr' => ['value' => 'fr'], 'content' => 'FR: +33'],
                    ['attr' => ['value' => 'en'], 'content' => 'EN: +44'],
                    ['attr' => ['value' => 'de'], 'content' => 'DE: +49'],
                    ['attr' => ['value' => 'x'], 'content' => '-- autre --'],
                ]
            ]
        ]
    ];
    $select_auth_id = [
        'auth_id' => [
            'label' => 'authorisation : ',
            'select' => [
                'attr' => ['class' => 'form-control'],
                'content' => [
                    ['attr' => ['value' => 'aucun', 'selected'], 'content' => '-- veuillez choisir --'],
                    ['attr' => ['value' => '1'], 'content' => 'admin'],
                    ['attr' => ['value' => '2'], 'content' => 'site'],
                    ['attr' => ['value' => '3'], 'content' => 'newsletter'],
                    ['attr' => ['value' => '4'], 'content' => 'user'],
                    ['attr' => ['value' => '5'], 'content' => 'group'],
                    ['attr' => ['value' => '6'], 'content' => 'grant']
                ]
            ],
            'required'
        ]
    ];
    // LABEL_CAPTCHA_BLOCK
   	$captcha = [
        // [
            'captcha' => [
                'label' => $site->txt('form_robot') . ' : ',
                'input' => [
                    'type' => 'text',
                    'placeholder' => 'ex: code',
                    'class' => 'form-control',
                    'value' => $robot
                ],
                'required'
            ],
            'img_captcha' => [
                'tag' => 'img',
                'attr' => [
                    'id' => 'img_robot',
                    'class' => 'img_robot',
                    'src' => './php/image.php',
                    'title' => 'click to change code',
                    'onclick' => "this.src = './php/image.php?' + Math.random();"
                ]
            ]
        // ]
    ];
    // image
    $input_visitcard = [
        'visitcard' => [
            'label' => $site->txt('word_visitcard') . ' : ',
            'input' => [
                'type' => 'file',
                'placeholder' => 'ex: image.png',
                'class' => 'form-control'
            ],
            'infos' => []
        ]
    ];  
?>