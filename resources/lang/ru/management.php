<?php
/**
 * Created by PhpStorm.
 * User: Shaman
 * Date: 01.06.2020
 * Time: 00:02
 */
return [
    'images' => [
        'page_title' => 'Личный кабинет',
        'title' => 'Настройки -> Изображения',
        'images_count' => 'Количество изображений',
        'reworked_count' => 'Количество обработанных',
        'need_rework' => 'Необходимо обработать',
        'problems_gallery' => 'Количество проблемных изображений в галлереях',
        'problems_restaurant' => 'Количество проблемных изображений в ресторанах',
        'clear_mins' => 'Очистить миниатюры',
        'create_mins' => 'Создать миниатюры',
        'remove_problems' => 'Удалить проблемные записи',
    ],
    'roles' => [
        'index' => [
            'page_title' => 'Роли',
            'title' => 'Роли пользователей',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одной роли польлзователя',
            'name' => 'Название',
            'edit' => 'Редактировать',
        ],
        'form' => [
            'page_title' => 'Работа с ролями',
            'title' => 'Новая роль пользователя',
            'save' => 'Cохранить',
            'name' => 'Название',
            'alias' => 'Ключевое слово',
            'use' => 'Используется как должность в ресторане',
        ],
    ],
    'users' => [
        'index' => [
            'page_title' => 'Пользователи',
            'title' => 'Пользователи ресурса',
            'add' => 'Добавить',
            'name' => 'Имя, Фамилия',
            'role' => 'Роль',
            'phone' => 'Телефоны',
            'remove' => 'Удалить',
        ],
        'form' => [
            'page_title' => 'Работа с пользователем',
            'user' => 'Пользователь',
            'new_user' => 'Новый пользователь',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'role' => 'Роль пользователя',
            'phone' => 'Телефон',
            'back' => 'Назад',
            'save' => 'Cохранить',
        ],
    ],
    'faq' => [
        'index' => [
            'page_title' => 'Часто задаваемые вопросы',
            'add' => 'Добавить',
            'empty' => 'На данный момент нет таких вопросов',
            'question' => 'Вопрос',
            'status' => 'Статус',
            'order' => 'Порядок сортировки',
            'publicated' => 'Опубликован',
            'unpublicated' => 'Не опубликован',
            'edit' => 'Редактировать',
        ],
        'form' => [
            'page_title' => 'Работа с часто задаваемыми вопросами',
            'new' => 'Новый вопрос',
            'save' => 'Cохранить',
            'settings' => 'Настройки',
            'publicate' => 'Опубликовать',
            'order' => 'Порядок сортировки',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
        ],
    ],
    'articles' => [
        'index' => [
            'page_title' => 'Статьи',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одной статьи',
            'name' => 'Название (Заголовок)',
            'status' => 'Статус',
            'order' => 'Порядок сортировки',
            'publicated' => 'Опубликован',
            'unpublicated' => 'Не опубликован',
            'edit' => 'Редактировать',
        ],
        'form' => [
            'page_title' => 'Работа со статьями',
            'new' => 'Новая статья',
            'save' => 'Cохранить',
            'settings' => 'Настройки',
            'publicate' => 'Опубликовать',
            'order' => 'Порядок сортировки',
            'position' => 'Размещение',
            'top_menu' => 'Верхнее меню',
            'bottom_1' => 'Подвал, колонка 1',
            'bottom_2' => 'Подвал, колонка 2',
            'heading' => 'Заголовок (h1)',
            'text' => 'Текст',
        ],
    ],
    'cuisines' => [
        'index' => [
            'page_title' => 'Кухни',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одного типа кухни',
            'name' => 'Название',
            'edit' => 'Редактировать',
        ],
        'form' => [
            'page_title' => 'Работа с кухнями',
            'new' => 'Новый тип кухни',
            'save' => 'Cохранить',
            'name' => 'Название',
        ],
    ],
    'cities' => [
        'index' => [
            'page_title' => 'Города',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одного города',
            'name' => 'Название (Заголовок)',
            'status' => 'Статус',
            'order' => 'Порядок сортировки',
            'enabled' => 'Включена',
            'disabled' => 'Отключена',
            'edit' => 'Редактировать',
            'remove' => 'Удалить',
        ],
        'form' => [
            'page_title' => 'Работа с городами',
            'new' => 'Новый город',
            'save' => 'Cохранить',
            'settings' => 'Настройки',
            'heading' => 'Заголовок (h1)',
            'text' => 'Текст',
            'active' => 'Активна',
            'order' => 'Порядок сортировки',
        ],
    ],
    'restaurant_types' => [
        'index' => [
            'page_title' => 'Типы заведений',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одного типа заведения',
            'name' => 'Название (Заголовок)',
            'status' => 'Статус',
            'order' => 'Порядок сортировки',
            'enabled' => 'Включена',
            'disabled' => 'Отключена',
            'edit' => 'Редактировать',
        ],
        'form' => [
            'page_title' => 'Работа с типами заведений',
            'new' => 'Новый тип заведения',
            'save' => 'Cохранить',
            'settings' => 'Настройки',
            'heading' => 'Заголовок (h1)',
            'text' => 'Текст',
            'active' => 'Активна',
            'order' => 'Порядок сортировки',
        ],
    ],
    'workload' => [
        'index' => [
            'page_title' => 'Загруженность заведений',
            'name' => 'Заведения',
        ],
        'form' => [
            'page_title' => 'Загруженность заведения',
            'schedule' => 'Расписание заведения и залов',
            'state' => 'Выберите состояние',
            'free' => 'Свободен',
            'partial' => 'Частично занят',
            'busy' => 'Занят',
            'end' => 'Выходной',
        ]
    ],
    'restaurants' => [
        'index' => [
            'page_title' => 'Заведения',
            'add' => 'Добавить',
            'empty' => 'На данный момент не создано ни одного ресторана',
            'name' => 'Название',
            'city' => 'Город',
            'type' => 'Тип',
            'remove' => 'Удалить',
        ],
        'view' => [
            'general' => 'Основная информация',
            'settings' => 'Настройки',
            'image' => 'Изображение',
            'yes' => 'есть',
            'no' => 'нет',
            'status' => 'Статус',
            'publicated' => 'Опубликован',
            'unpublicated' => 'Не опубликован',
            'order' => 'Сортировка',
            'city' => 'Город',
            'type' => 'Тип',
            'cuisine' => 'Кухня',
            'table_deposit' => 'Депозит столика',
            'banket_deposit' => 'Депозит банкета',
            'volume' => 'Вместимость ресторана',
            'video_link' => 'Ссылка на видео',
            'gift' => 'Подарок',
            'uah' => 'грн',
            'ppl' => 'человек',
            'heading' => 'Заголовок',
            'filled' => 'заполнен',
            'not_filled' => 'не заполнен',
            'address' => 'Адрес',
            'schedule' => 'Расписание',
            'discount' => 'Скидки',
            'staff' => 'Персонал',
            'name_surname' => 'Фамилия Имя',
            'position' => 'Должность',
            'phone' => 'Телефон',
            'gallery' => 'Галлерея',
            'empty_gallery' => 'Галлерея пока пуста',
            'menu' => 'Меню',
            'empty_menu' => 'В меню пока ничего нет',
            'halls' => 'Залы',
            'no_halls_gallery' => 'Галлереи пока нет',
            'no_halls' => 'Пока не создано ни одного зала',
        ],
        'form' => [
            'page_title' => 'Работа с ресторанами',
            'new_restaurant' => 'Новое заведение',
            'save' => 'Cохранить',
            'settings' => 'Настройки',
            'chars' => 'Характеристики',
            'heading' => 'Заголовок (h1)',
            'text' => 'Текст',
            'order_sort' => 'Порядок сортировки',
            'publicate' => 'Опубликовать',
            'file_upload' => 'Загрузите файл',
            'video_link' => 'Ссылка на видео',
            'table_deposit' => 'Депозит при заказе столика (грн)',
            'coffee_price' => 'Стоимость чашки кофе (грн)',
            'max_size' => 'Максимальная вместимость (человек)',
            'choose_city' => 'Выберите город',
            'choose_type' => 'Выберите тип',
            'choose_cuisine' => 'Выберите типы кухни',
            'city' => 'Город',
            'type' => 'Тип(-ы) заведений',
            'cuisine' => 'Кухня',
            'address' => 'Адрес',
            'gifts' => 'Подарки',
            'has_gifts' => 'Есть подарки',
            'gift_text' => 'Текст подарка',
            'schedule' => 'График работы',
            'discount' => 'Скидки',
        ]
    ],
    'staff' => [
        'page_title' => 'Работники',
        'new_worker' => 'Создание работника',
        'exists' => 'Такая запись уже есть!',
        'search_filters' => 'Фильтры для поиска',
        'name' => 'Имя',
        'surname' => 'Фамилия',
        'phone' => 'Телефон',
        'search' => 'Поиск',
        'choose_user' => 'Выберите пользователя из списка и его должность в ресторане',
        'empty_filter' => 'Заданным фильтрам не подходит ни один пользователь, попробуйте изменить параметры поиска',
        'make' => 'Назначить',
    ],
    'galleries' => [
        'page_title' => 'Работа с галереей',
        'restaurant_gallery' => 'Галлерея ресторана',
        'recommendation' => '*Рекомендуется загружать не более 15 изображений. Максимальная ширина изображения - 2400 пикселей, высота - 1350.',
        'photo' => 'Фото',
        'upload_file' => 'Загрузите один или несколько файлов',
        'add' => 'Добавить изображения',
        'save' => 'Сохранить изменения',
        'image' => 'Изображение',
        'info' => 'Информация',
        'description' => 'Описание',
    ],
    'menu' => [
        'page_title' => 'Работа с меню',
        'menu' => 'Меню',
        'recommendation' => '*Рекомендуется загружать не более 15 изображений',
        'photo' => 'Фото',
        'files_upload' => 'Загрузите один или несколько файлов',
        'add' => 'Добавить изображения',
        'save' => 'Сохранить изменения',
        'image' => 'Изображение',
        'info' => 'Информация',
        'title' => 'Название',
        'description' => 'Описание (грамовка/цена):',
    ],
    'halls' => [
        'page_title' => 'Залы ресторана',
        'new_hall' => 'Новый зал',
        'photo' => 'Фото',
        'files_upload' => 'Загрузите один или несколько файлов',
        'add_images' => 'Добавить изображения',
        'save' => 'Сохранить',
        'title' => 'Название',
        'count' => 'Вместимость',
        'order' => 'Сортировка',
        'choose_type' => 'Выберите подходящий тип',
        'hall' => 'Зал',
        'open_air' => 'Летняя площадка',
        'hotel' => 'Отель',
        'location_type' => 'Тип локации',
        'publicate' => 'Опубликовать',
        'image' => 'Изображение',
        'info' => 'Информация',
        'heading' => 'Заголовок',
        'subheading' => 'Подзаголовок',
    ],
    'admin_order' => [
        'index' => [
            'page_title' => 'Бронирования',
            'title'=>'Бронирования',
            'restaurant'=>'Ресторан',
            'date_time'=>'Дата и время',
            'status'=>'Статус',
            'empty'=>'На данный момент нет заказов.'
        ],
        'form' => [
            'page_title' => 'Просмотр бронирования',
            'info'=>'Информация о клиенте',
            'edit'=>'Редактирование брони',
            'date'=>'Дата',
            'time'=>'Время',
            'count'=>'Количество гостей',
            'deposit'=>'Депозит',
        ],
        'show' => [
            'page_title' => 'Просмотр бронирования',
            'details'=>'Детали заказа',
            'hall'=>'Зал',
            'set'=>'указан',
            'not_set'=>'не указан',
            'date_time'=>'Дата и время',
            'count'=>'Количество человек',
            'deposit'=>'Депозит',
            'service_deposit'=>'Депозит через сервис',
            'status'=>'Статус',
            'client'=>'Информация о клиенте',
            'name'=>'ФИО',
            'phone'=>'Телефон',
            'edit'=>'Редактировать',
            'accept'=>'Потвердить',
            'decline'=>'Отклонить',
        ]
    ],
];