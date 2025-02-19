# Componist Core Benachrichtigung


## Erstellen ein neu Componist Core Benachrichtigung im Account

php snippet im Ihren code

```php
/*
* $userId = Account Benutzer id
* $email = Account Benutzer E-Mail adresse nach der gesucht wird und benutzer selektiert
* $title = Benachrichtigungs Title
* $messag = Benachrichtigung Nachricht
*/
ComponistCoreNotification::CreateMessage($userId|$email,$title,$message);

/*
* return new ComponistCoreNotification
*/
```