# ArsenalPay Payment Module for Joomshopping of Joomla! CMS

*Arsenal Media LLC*

[Arsenal Pay processing server]( https://arsenalpay.ru/ )

## Version
1.0.1

*For Joomshopping 3&4 and Joomla! 2.5&3.x*

## Source
[Official integration guide page]( https://arsenalpay.ru/developers.html )

Basic feature list:

 * Allows seamlessly integrate unified payment frame into your site.
 * New payment method ArsenalPay will appear to pay for your products and services.
 * Allows to pay using mobile commerce and bank aquiring. More methods are about to become available. Please check for updates.
 * Supports two languages (Russian, English).

For more information go to [arsenalpay.com](https://arsenalpay.com)
 
## How to install
1. Download the latest release [Joomshopping-ArsenalPay-CMS-\*.\*.\*.zip](https://github.com/ArsenalPay/Joomshopping-ArsenalPay-CMS/releases/) (IMPORTANT! The archive must contain the structure of the project itself started at `components`, without any additional folder in the upper level of the structure.)
2. Go to Joomla! admin panel.
3. There go  to **Components > JoomShopping > Install & Update**.
4. Upload  ArsenalPay module zip package. 

## Configuration 

1. Go to **Components > JoomShopping > Options > Payments**.
2. There find **ArsenalPay** and click on **Edit**.
3. In **General** tab you can change the **Title** of ArsenalPay payment method as you wish it will be appeared at your site.
4. Go into **Config** tab and make following settings there:
 - Fill out **Unique token**, **Sign key** fields with your received token and key.
 - Set **Frame URL** as `https://arsenalpay.ru/payframe/pay.php`
 - Set **Payment type** as `card` to activate payments with bank cards or `mk` to activate payments from mobile phone accounts.
 - **css parameter**. You can specify CSS file to apply it to the view of payment frame by inserting its url.
 - You can specify ip address only from which it will be allowed to receive callback requests about payments onto your site in **Allowed IP address** field.
 - Your online shop will be receiving callback requests about processed payments for automatically change of order status. The callbacks will be received onto the address assigned in the field **Callback URL** of the payment module settings.
 - If it is needed to check a payer order number before payment processing you should fill out the field of **Check URL** in the module settings with url-address to which ArsenalPay will be sending requests with check parameters. By default the address is the same with **Callback URL**. 
 - Set order statuses for successful, pending and failed transactions.
 - Set **Frame mode** as `1` to display payment page inside frame at your site, as `0` to redirect a payer directly to the payment page url.
 - You can adjust **width**, **height**, **frameborder** and **scrolling** of ArsenalPay payment frame by setting iframe parameters.
5. Save your settings by clicking on **Save & Close**

## How to delete
1. Go to **Components > JoomShopping > Options > Payments** in Joomla! admin panel
2. **Delete** ArsenalPay payment method.
3. To delete completely all module files go to your web site server via ftp and delete *pm_arsenalpay* folder from its installed directory path `pathToYourSiteFoler/components/com_jshopping/payments/`. 

## Usage
After successful installation and proper settings new choice of payment method with ArsenalPay will appear on your site. To make payment for an order a payer will need to:

1. Choose goods from the shop catalog.
2. Go into the order page.
3. Choose the ArsenalPay payment method.
4. Check the order detailes and confirm the order.
5. After filling out the information depending on the payment type he will receive SMS about payment confirmation or will be redirected to the page with the result of his payment.

------------------
### О МОДУЛЕ
* Модуль платежной системы ArsenalPay под Joomshopping позволяет легко встроить платежную страницу на Ваш сайт.
* После установки модуля у Вас появится новый вариант оплаты товаров и услуг через платежную систему ArsenalPay.
* Платежная система ArsenalPay позволяет совершать оплату с различных источников списания средств: мобильных номеров (МТС/Мегафон/Билайн/TELE2), пластиковых карт (VISA/MasterCard/Maestro). Перечень доступных источников средств постоянно пополняется. Следите за обновлениями.
* Модуль поддерживает русский и английский языки.

### УСТАНОВКА 
1. Скачайте последний релиз платежного модуля ArsenalPay [Joomshopping-ArsenalPay-CMS-\*.\*.\*.zip](https://github.com/ArsenalPay/Joomshopping-ArsenalPay-CMS/releases/) (ВАЖНО! Архив должен сам содержать структуру проекта, начинающуюся с `components`, без дополнительной папки на верхнем уровне этой структуры.)
2. Зайдите в администрирование Joomla!.
3. Затем пройдите в раздел **Компоненты > JoomShopping > Установка и обновление**.
4. Загрузите скачанный на первом шаге архив c модулем ArsenalPay.

### НАСТРОЙКА
1. После установки зайдите в раздел **Компоненты > JoomShopping > Опции > Способ оплаты**.
2. Найдите в списке **ArsenalPay** и нажмите на **Редактировать**.
3. Во вкладке **Главная** Вы можете изменить **Название** платежного метода ArsenalPay так, как Вы хотите отобразить его на Вашем сайте.
4. Переключитесь  на вкладку **Конфигурация**:
 - Заполните поля **Уникальный токен** и **Ключ (key)**, присвоенными Вам токеном и ключом для подписи.
 - Установите **URL-адрес фрейма** как `https://arsenalpay.ru/payframe/pay.php`
 - Установите **Тип оплаты** как `card` для активации платежей с пластиковых карт или  как `mk` — платежей с аккаунтов мобильных телефонов.
 - Вы можете задать **Параметр css** для применения к отображению платежного фрейма, указав url css-файла.
 - Вы можете задать ip-адрес, только с которого будут разрешены обратные запросы о совершаемых платежах, в поле **Разрешенный IP-адрес**.
 - Ваш интернет-магазин будет получать уведомления о совершенных платежах: на адрес, указанный в поле **URL для обратного запроса**, от ArsenalPay будет поступать запрос с результатом платежа для фиксирования статусов заказа в системе предприятия.
 - При необходимости осуществления проверки номера заказа перед проведением платежа, Вы должны заполнить поле **URL для проверки**, на который от ArsenalPay будет поступать запрос на проверку. По умолчанию значение совпадает с **URL для обратного запроса**.
 - Установите статус для успешных, ожидаемых и неудавшихся платежей.
 - Вы можете устанавливать **Режим отображения фрейма**. Значение `1` соответствует отображению платежной страницы внутри фрейма на Вашем сайте, `0` - пользователь будет перенаправляться напрямую по адресу платежной страницы.
 - Вы можете подгонять ширину, высоту, границу и прокрутку платежного фрейма, задавая соответствующие значения параметров iframe.
5. Сохраните настройки нажатием на **Сохранить и закрыть**.

### УДАЛЕНИЕ
1. Пройдите в раздел **Компоненты > JoomShopping > Опции > Способ оплаты**  администрирования Joomla!
2. Удалите созданный при установке способ оплаты ArsenalPay;
3. Зайдите на сервер, где хранится Ваш сайт, например, через ftp, и удалите директорию *pm_arsenalpay*, находящуюся по пути `путьКПапкеВашегоСайта/components/com_jshopping/payments/`.

### ИСПОЛЬЗОВАНИЕ
После успешной установки и настройки модуля на сайте появится возможность выбора платежной системы ArsenalPay.
Для оплаты заказа с помощью платежной системы ArsenalPay нужно:

1. Выбрать из каталога товар, который нужно купить.
2. Перейти на страницу оформления заказа (покупки).
3. В разделе "Платежные системы" выбрать платежную систему ArsenalPay.
4. Перейти на страницу подтверждения введенных данных и ввода источника списания средств (мобильный номер, пластиковая карта и т.д.).
5. После ввода данных об источнике платежа, в зависимости от его типа, либо придет СМС о подтверждении платежа, либо покупатель будет перенаправлен на страницу с результатом платежа.

### ОПИСАНИЕ РЕШЕНИЯ
ArsenalPay – удобный и надежный платежный сервис для бизнеса любого размера. 

Используя платежный модуль от ArsenalPay, вы сможете принимать онлайн-платежи от клиентов по всему миру с помощью: 
пластиковых карт международных платёжных систем Visa и MasterCard, эмитированных в любом банке
баланса мобильного телефона операторов МТС, Мегафон, Билайн, Ростелеком и ТЕЛЕ2
различных электронных кошельков 

### Преимущества сервиса: 
 - Самые низкие тарифы
 - Бесплатное подключение и обслуживание
 - Легкая интеграция
 - Агентская схема: ежемесячные выплаты разработчикам
 - Вывод средств на расчетный счет без комиссии
 - Сервис смс оповещений
 - Персональный личный кабинет
 - Круглосуточная сервисная поддержка клиентов 

А ещё мы можем взять на техническую поддержку ваш сайт и создать для вас мобильные приложения для Android и iOS. 

ArsenalPay – увеличить прибыль просто! 
Мы работаем 7 дней в неделю и 24 часа в сутки. А вместе с нами множество российских и зарубежных компаний. 

### Как подключиться: 
1. Вы скачали модуль и установили его у себя на сайте;
2. Отправьте нам письмом ссылку на Ваш сайт на pay@arsenalpay.ru;
3. Мы Вам вышлем коммерческие условия и технические настройки;
4. После Вашего согласия мы отправим Вам проект договора на рассмотрение.
5. Подписываем договор и приступаем к работе.

Всегда с радостью ждем ваших писем с предложениями. 
pay@arsenalpay.ru 
[arsenalpay.ru](https://arsenalpay.ru)





 



