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
### � ������
* ������ ��������� ������� ArsenalPay ��� Joomshopping ��������� ����� �������� ��������� �������� �� ��� ����.
* ����� ��������� ������ � ��� �������� ����� ������� ������ ������� � ����� ����� ��������� ������� ArsenalPay.
* ��������� ������� ArsenalPay ��������� ��������� ������ � ��������� ���������� �������� �������: ��������� ������� (���/�������/������/TELE2), ����������� ���� (VISA/MasterCard/Maestro). �������� ��������� ���������� ������� ��������� �����������. ������� �� ������������.
* ������ ������������ ������� � ���������� �����.

�� ����� ��������� ����������� � ��������� ������� ArsenalPay ����������� �� ������ [arsenalpay.ru](http://arsenalpay.ru)

### ��������� 
1. ��������  zip ����� ���������� ������ ArsenalPay �� `http://guthub` .
2. ������� � ����������������� Joomla!.
3. ����� �������� � ������ **���������� > JoomShopping > ��������� � ����������**.
4. ��������� ��������� �� ������ ���� ����� c ������� ArsenalPay.

### ���������
1. ����� �������� ������� � ������ **���������� > JoomShopping > ����� > ������ ������**.
2. ������� � ������ **ArsenalPay** � ������� �� **�������������**.
7. �� ������� **�������** �� ������ �������� **��������** ���������� ������ ArsenalPay ���, ��� �� ������ ���������� ��� �� ����� �����;.
8. �������������  �� ������� **������������**:
- ��������� ���� **���������� �����** � **���� (key) **, ������������ ��� ������� � ������ ��� �������.
- ���������� **URL-����� ������** ��� `https://arsenalpay.ru/payframe/pay.php`
- ���������� **��� �������** ��� `card` ��� ��������� �������� � ����������� ���� ���  ��� `mk` � �������� � ��������� ��������� ���������.
- �� ������ ���������� ip-�����, ������ � �������� ����� ��������� �������� ������� � ����������� ��������.
- �� ������ ������ **�������� css** ��� ���������� � ����������� ���������� ������, ������ url css-�����.
- �� ������ ������������� **����� ����������� ������**. �������� `1` ������������� ����������� ������ ������ ������ ����� , ����� ������������ ����� ���������������� �������� �� ����� ���������� ������.
- �� ������ ��������� ������, ������, ������� � ��������� ���������� ������, ������� ��������������� �������� ���������� iframe.
��������� ��������� �������� �� **�������� � �������**.


### ��������
1. �������� � ������ **���������� > JoomShopping > ����� > ������ ������**  ����������������� Joomla!
2. ������� ��������� ��� ��������� ������ ������ ArsenalPay;
3. ������� �� ������, ��� �������� ��� ����, ��������, ����� ftp, � ������� ���������� pm_arsenalpay, ����������� �� ���� `���������������������/components/com_jshopping/payments/`.

### �������������
����� �������� ��������� � ��������� ������ �� ����� �������� ����������� ������ ��������� ������� ArsenalPay.
��� ������ ������ � ������� ��������� ������� ArsenalPay �����:

1. ������� �� �������� �����, ������� ����� ������.
2. ������� �� �������� ���������� ������ (�������).
3. � ������� "��������� �������" ������� ��������� ������� ArsenalPay.
4. ������� �� �������� ������������� ��������� ������ � ����� ��������� �������� ������� (��������� �����, ����������� ����� � �.�.).
5. ����� ����� ������ �� ��������� ������� � ����������� �� ��� ����, ��� ���� ������ ��� � ������������� �������, ���� �� ������ �������������� �� �������� � ����������� �������.
6. ��� ��������-������� ����� �������� ����������� � ����������� ��������: �� �����, ��������� � ���� "Url �������", �� ArsenalPay �������� ������ � ����������� ������� ��� ������������ �������� ������ � ������� �����������.
������ �������� �� ������ `http(s)://����������������/index.php?option=com_jshopping&controller=checkout&task=step7&act=notify&js_paymentclass=pm_arsenalpay&no_lang=1`
7. ��� ������������� ������������� �������� ������ ���������� ����� ����������� �������, �� ������ ��������� ���� "Url �������� ������ ����������", �� ������� �� ArsenalPay �������� ������ �� ��������.

 



 