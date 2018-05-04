<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/11/23
 * Time: 0:09
 */
return [
    'table_config' => [
        [
            'table' => 'system_user',//table of system users
            'field' => [
                ['name', 'pwd', 'permission'],
                ['varchar(20)', 'char(32)', 'tinyint(1)'],
                [
                    'COLLATE utf8_unicode_ci',//name: system user name
                    'COLLATE utf8_unicode_ci',//password: system user password
                    'unsigned not null'//system user's permission,remain to be defined,1-255
                ]
            ],
            'primary_key' => 'id',//default primary key id, auto_increment
            'key' => [],
            'foreign_key' => []
        ],
        [
            'table' => 'app',//message callback
            'field' => [
                ['name', 'sys_user_id', 'app_file'],
                ['varchar(64)', 'int(10)', 'varchar(64)'],
                [
                    'COLLATE utf8_unicode_ci',
                    'unsigned not null',
                    'COLLATE utf8_unicode_ci',
                ],
            ],
            'primary_key' => 'id',
            'key' => [
                [
                    'name' => 's_id',
                    'field' => ['sys_user_id']
                ]
            ],
            'foreign_key' => [
                [
                    'name' => 'fa_sys_uid',
                    'key' => 'sys_user_id',
                    'foreign_table' => 'system_user',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ]
            ]
        ],
        [
            'table' => 'group',//user's group
            'field' => [
                ['name', 'sys_user_id', 'app_id'],
                ['char(10)', 'int(10)', 'int(10)'],
                [
                    'COLLATE utf8_unicode_ci',
                    'unsigned not null',
                    'unsigned not null',
                ],
            ],
            'primary_key' => 'id',
            'key' => [
                [
                    'name' => 'sid_aid',
                    'field' => ['sys_user_id', 'app_id']
                ]
            ],
            'foreign_key' => [
                [
                    'name' => 'fg_sys_uid',
                    'key' => 'sys_user_id',
                    'foreign_table' => 'system_user',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ],
                [
                    'name' => 'fg_app_id',
                    'key' => 'app_id',
                    'foreign_table' => 'app',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ]
            ]
        ],
        [
            'table' => 'message',
            'field' => [
                ['sys_user_id', 'app_id', 'platform', 'title', 'content', 'type', 'content_extra', 'target',
                    'target_extra', 'push_time', 'status'],
                [
                    'int(10)', 'int(10)', 'tinyint(1)', 'char(10)', 'char(50)', 'tinyint(3)', 'varchar(1500)',
                    'tinyint(1)', 'varchar(500)', 'int(10)', 'tinyint(3)'
                ],
                [
                    'unsigned not null',//sys_user_id: system user id,foreign key, index
                    'unsigned not null',//app_id, foreign key, index
                    'unsigned not null default 0',//platform: android = 0,ios = 1
                    'not null COLLATE utf8_unicode_ci',//title: length <= 10
                    'not null COLLATE utf8_unicode_ci',//content: length <= 50
                    'unsigned not null default 0',//type: reserve field for content(like redirect to a url)
                    'COLLATE utf8_unicode_ci',//content_extra: varchar,length <= 1500(the default length of a url)
                    'unsigned not null default 0',//target: all = 0, group = 1, app_users = 2
                    'COLLATE utf8_unicode_ci',//target_extra:id list of groups or users, split by ','
                    'unsigned not null',//message push time
                    'unsigned not null default 0',//message status:0 => waiting, 100 => send
                ]
            ],
            'primary_key' => 'id',
            'key' => [
                [
                    'name' => 'sid_aid',
                    'field' => ['sys_user_id', 'app_id']
                ]
            ],
            'foreign_key' => [
                [
                    'name' => 'fm_sys_uid',
                    'key' => 'sys_user_id',
                    'foreign_table' => 'system_user',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ],
                [
                    'name' => 'fm_app_id',
                    'key' => 'app_id',
                    'foreign_table' => 'app',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ]
            ]
        ],
        [
            'table' => 'app_user',
            'field' => [
                ['name', 'sys_user_id', 'app_id', 'group_id'],
                ['varchar(64)', 'int(10)', 'int(10)', 'int(10)'],
                [
                    'COLLATE utf8_unicode_ci',
                    'unsigned not null',
                    'unsigned not null',
                    'unsigned not null',
                ],
            ],
            'primary_key' => 'id',
            'key' => [
                [
                    'name' => 'sid_aid_gid',
                    'field' => ['sys_user_id', 'app_id', 'group_id']
                ]
            ],
            'foreign_key' => [
                [
                    'name' => 'fau_sys_uid',
                    'key' => 'sys_user_id',
                    'foreign_table' => 'system_user',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ],
                [
                    'name' => 'fau_app_id',
                    'key' => 'app_id',
                    'foreign_table' => 'app',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ],
                [
                    'name' => 'fau_group_id',
                    'key' => 'group_id',
                    'foreign_table' => 'group',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ]
            ]
        ],
        [
            'table' => 'message_callback',//message callback
            'field' => [
                ['message_id', 'received', 'clicked'],
                ['int(10)', 'tinyint(1)', 'tinyint(1)'],
                [
                    'unsigned not null',
                    'unsigned not null',
                    'unsigned not null',
                ],
            ],
            'primary_key' => 'id',
            'key' => [
                [
                    'name' => 'mid',
                    'field' => ['message_id']
                ]
            ],
            'foreign_key' => [
                [
                    'name' => 'fmc_mes_id',
                    'key' => 'message_id',
                    'foreign_table' => 'message',
                    'foreign_key' => 'id',
                    'extra' => 'on update cascade on delete cascade'
                ]
            ]
        ],

    ]
];