<?php

/**
 * Plugin Name: Telegram Message Sender
 * Description: Плагин позволяет отправлять сообщения в телеграм-чат.
*/


// Свой пункт меню
function my_menu_page() {
  add_menu_page(
    'Настройка Telegram-сообщений',
    'Настройки TG',
    'manage_options',
    'mioka_tg-opts',
    'get_tg_opts_layout',
    'dashicons-format-aside',
    20,
  );
}

// Разметка к пункту меню
function get_tg_opts_layout() {
  echo '<div class="wrap">
    <h1>' . get_admin_page_title() . '</h1>
    <form method="post" action="options.php">';
  
      settings_fields( 'tg_opts_settings' );
      do_settings_sections( 'tg_opts' );
      submit_button();
  
    echo '</form></div>';
}

// Регистрация полей для страницы настроек
function tg_opts_fields() {
  // Для ввода токена
  register_setting(
    'tg_opts_settings',
    'bot_token',
    '',
  );

  // Для ввода id чата
  register_setting(
    'tg_opts_settings',
    'bot_chat_id',
    '',
  );

  // Для ввода шаблона сообщений
  register_setting(
    'tg_opts_settings',
    'bot_message',
    '',
  );

  add_settings_section(
    'tg_opts_section_id',
    'Настройка отправки сообщений',
    '',
    'tg_opts'
  );

  add_settings_field(
    'bot_token',
    'Токен бота:',
    'tg_bot_token_field', // функция для вывода,
    'tg_opts',
    'tg_opts_section_id',
    array(
      'label_for' => 'tg_opts',
      'class' => 'tg-class',
      'name' => 'bot_token',
    )
  );

  add_settings_field(
    'bot_chat_id',
    'Идентификатор чата:',
    'tg_bot_chat_id_field', // функция для вывода,
    'tg_opts',
    'tg_opts_section_id',
    array(
      'label_for' => 'tg_opts',
      'class' => 'tg-class',
      'name' => 'bot_chat_id',
    )
  );

  add_settings_field(
    'bot_message',
    'Шаблон сообщения бота:',
    'tg_bot_message_field', // функция для вывода,
    'tg_opts',
    'tg_opts_section_id',
    array(
      'label_for' => 'tg_opts',
      'class' => 'tg-class',
      'name' => 'bot_message',
    )
  );
}

// Вывод поля для ввода токена
function tg_bot_token_field($args) {
  $value = get_option($args['name']);

  printf(
    '<input type="text" id="%s" name="%s" value="%s" />',
    esc_attr( $args[ 'name' ] ),
    esc_attr( $args[ 'name' ] ),
    $value
  );
}

// Вывод поля для ввода шаблона сообщения
function tg_bot_message_field($args) {
  $value = get_option($args['name']);

  printf(
    'Используйте:<br>
    <b>{username}</b> - для подстановки <u>имени</u> пользователя,<br>
    <b>{usertel}</b> - для подстановки <u>телефона</u> пользователя,<br>
    <b>{usermsg}</b> - для подстановки <u>сообщения</u> пользователя
    <hr>
    <textarea name="%s" id="%s" cols="55" rows="13">%s</textarea>',
    esc_attr( $args[ 'name' ] ),
    esc_attr( $args[ 'name' ] ),
    esc_attr( $value )
  );
}

// Вывод поля для ввода id чата
function tg_bot_chat_id_field($args) {
  $value = get_option($args['name']);

  printf(
    '<input type="text" id="%s" name="%s" value="%s" />',
    esc_attr( $args[ 'name' ] ),
    esc_attr( $args[ 'name' ] ),
    $value
  );
}

// Кастомное уведомление
function true_custom_notice() {
  if(
    isset( $_GET[ 'page' ] )
    && 'mioka_tg-opts' == $_GET[ 'page' ]
    && isset( $_GET[ 'settings-updated' ] )
    && true == $_GET[ 'settings-updated' ]
  ) {
    echo '<div class="notice notice-success is-dismissible"><p>Настройки сообщений сохранены</p></div>';
  }
}

// Свой пункт меню на сайдбаре
add_action('admin_menu', 'my_menu_page');
add_action('admin_init', 'tg_opts_fields');
add_action( 'admin_notices', 'true_custom_notice' );

