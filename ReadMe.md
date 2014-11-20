# ArsenalPay Payment Plugin for Joomshopping of Joomla! CMS

[Arsenal Media LLC](http://www.arsenalmedia.ru/index.php/en)
[Arsenal Pay processing server]( https://arsenalpay.ru/ )



## Version
1.0.0

##Source
[Official integration guide page]( https://arsenalpay.ru/site/integration/ )


Basic feature list:

 * Module allows seamlessly integrate unified payment frame into your site 
 * New payment method ArsenalPay will appear to pay for your products and services
 * Allows to pay using mobile commerce and bank aquiring. More methods are about to become available. Check for updates.
* Supports two languages (Russian, English).

For more information go to [arsenalpay.ru](http://arsenalpay.ru)
 
## How to install
1. Download the  zip archive of this plugin from:
	`http://github/`
2. Go to Joomla! admin panel.
3. There go  to **Components > JoomShopping > Install & Update**
4. Upload  arsenalpay plugin zip package. 

## Configuration 

1. Go to ** Components > JoomShopping > Options > Payments**.
2. There find **ArsenalPay** and click on **Edit**.
3. In **General** tab you can change the **Title** of ArsenalPay payment method as you wish it will appear at your site.
4. Go into **Config** tab and make following settings there:
- Fill out **Unique token**, **Sign key** fields with your received token and key.
- Set **Frame URL** as `https://arsenalpay.ru/payframe/pay.php`
- Set **Payment type** as `card` to activate payments with bank cards or `mk` to activate payments from mobile phone accounts.
- You can specify ip address only from which it will be allowed to receive callback requests about payments onto your site in **Allowed IP address** field.
- **css parameter**. You can specify CSS file to apply it to the view of payment frame by inserting its url.
- You can adjust **width**, **height**, **frameborder** and **scrolling** of ArsenalPay payment frame by setting iframe parameters.
- Set **Frame mode** as `1` to display payment frame inside your site, otherwise a payer will be redirected directly to the payment frame url.
- Set order statuses for successfull, pending and failed transactions.
Save your settings by clicking on **Save & Close**

## How to delete
1. Go to **Components > JoomShopping > Options > Payments** in Joomla! admin panel
2. **Delete** ArsenalPay payment method
3. To delete completely all plugin files go to your web site server via ftp and delete **pm_arsenalpay** folder from `pathToYourSiteFoler/components/com_jshopping/payments/`. 

## Usage
After successful installation and proper settings new choice of payment method with ArsenalPay will appear on your site. To make payment for an order you will need:
1. To choose goods from the shop catalog.
2. To go into the order page.
3. To choose the ArsenalPay payment method.
4. To check the order detailes and confirm the order.
5. After filling out the information depending on your payment type you will receive SMS about payment confirmation or will be redirected to the page with the result of your payment.
6. Your online shop will be receiving callback requests about processed payments to change automatically order statuses. The callbacks will be received onto the address assigned in the field **Callback URL** of the payment module settings.
Callback address is `http(s)://yourSiteAddress/index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1`
7. If it is needed to check a payer order number before payment processing you should fill out the field of **Check URL** in the module settings with address to which ArsenalPay will be sending requests with check parameters. By default the address is the same with **Callback URL**. 

------------------
### О МОДУЛЕ
* Модуль платежной системы ArsenalPay под Joomshopping позволяет легко встроить платежную страницу на Ваш сайт.
* После установки модуля у Вас появится новый вариант оплаты товаров и услуг через платежную систему ArsenalPay.
* Платежная система ArsenalPay позволяет совершать оплату с различных источников списания средств: мобильных номеров (МТС/Мегафон/Билайн/TELE2), пластиковых карт (VISA/MasterCard/Maestro). Перечень доступных источников средств постоянно пополняется. Следите за обновлениями.
* Модуль поддерживает русский и английский языки.

За более подробной информацией о платежной системе ArsenalPay обращайтесь по адресу [arsenalpay.ru](http://arsenalpay.ru)

### УСТАНОВКА 
1. Скачайте  zip архив платежного модуля ArsenalPay на `http://guthub` .
2. Зайдите в администрирование Joomla!.
3. Затем пройдите в раздел **Компоненты > JoomShopping > Установка и обновление**.
4. Загрузите скачанный на первом шаге архив c модулем ArsenalPay.

### НАСТРОЙКА
1. После загрузки зайдите в раздел **Компоненты > JoomShopping > Опции > Способ оплаты**.
2. Найдите в списке **ArsenalPay** и нажмите на **Редактировать**.
7. Во вкладке **Главная** Вы можете изменить **Название** платежного метода ArsenalPay так, как Вы хотите отображать его на Вашем сайте;.
8. Переключитесь  на вкладку **Конфигурация**:
- Заполните поля **Уникальный токен** и **Ключ (key) **, присвоенными Вам токеном и ключом для подписи.
- Установите **URL-адрес фрейма** как `https://arsenalpay.ru/payframe/pay.php`
- Установите **Тип платежа** как `card` для активации платежей с пластиковых карт или  как `mk` — платежей с аккаунтов мобильных телефонов.
- Вы можете установить ip-адрес, только с которого будут разрешены обратные запросы о совершаемых платежах.
- Вы можете задать **Параметр css** для применения к отображению платежного фрейма, указав url css-файла.
- Вы можете устанавливать **режим отображения фрейма**. Значение `1` соответствует отображению фрейма внутри Вашего сайта , иначе пользователь будет перенаправляться напрямую на адрес платежного фрейма.
- Вы можете подгонять ширину, высоту, границу и прокрутку платежного фрейма, задавая соответствующие значения параметров iframe.
Сохраните настройки нажатием на **Сохранит и закрыть**.


### УДАЛЕНИЕ
1. Пройдите в раздел **Компоненты > JoomShopping > Опции > Способ оплаты**  администрирования Joomla!
2. Удалите созданный при установке способ оплаты ArsenalPay;
3. Зайдите на сервер, где хранится Ваш сайт, например, через ftp, и удалите директорию pm_arsenalpay, находящуюся по пути `путьКПапкеВашегоСайта/components/com_jshopping/payments/`.

### ИСПОЛЬЗОВАНИЕ
После успешной установки и настройки модуля на сайте появится возможность выбора платежной системы ArsenalPay.
Для оплаты заказа с помощью платежной системы ArsenalPay нужно:

1. Выбрать из каталога товар, который нужно купить.
2. Перейти на страницу оформления заказа (покупки).
3. В разделе "Платежные системы" выбрать платежную систему ArsenalPay.
4. Перейти на страницу подтверждения введенных данных и ввода источника списания средств (мобильный номер, пластиковая карта и т.д.).
5. После ввода данных об источнике платежа в зависимости от его типа, Вам либо придет СМС о подтверждении платежа, либо Вы будете перенаправлены на страницу с результатом платежа.
6. Ваш интернет-магазин будет получать уведомления о совершенных платежах: на адрес, указанный в поле "Url колбэка", от ArsenalPay поступит запрос с результатом платежа для фиксирования статусов заказа в системе предприятия.
Колбэк доступен по адресу `http(s)://адресВашегоСайта/index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1`
7. При необходимости осуществления проверки номера получателя перед совершением платежа, Вы должны заполнить поле "Url проверки номера получателя", на который от ArsenalPay поступит запрос на проверку.

 



 