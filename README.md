## Плагин для отправки сообщений в телеграм

> Пример использования:
```
  $bot_token = get_option('bot_token');
  $bot_chat_id = get_option('bot_chat_id');
  $bot_msg_template = get_option('bot_message');
```

> Далее обращаемся к API Telegram
```
$response = file_get_contents(
    "https://api.telegram.org/bot$bot_token/sendMessage?&chat_id=$bot_chat_id&parse_mode=Markdown&text=$bot_msg_template"
  );
```

> И сообщение отправляется в указанный в $bot_chat_id чат :)