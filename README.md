# 📥 Magento 2 - Simple Contact Form

 📝 - this module sends an email to store ownerc <br />
 📝 - contains a form with 4 fields <br />
 📝 - use it on whatever page you want <br />
 <br />
 <br />
👨🏻‍💻 Install <br />
- copy Vendor folder in app/code
- enable module with php bin/magento module:enable Vendor_CustomContactForm
- run next commands <br />
`php bin/magento setup:upgrade;` <br />
`php bin/magento setup:di:compile`<br />
`php bin/magento setup:static-content:deploy -f`<br />
`php bin/magento cache:clear`; 
- call it on page with `{{block class="Vendor\CustomContactForm\Block\Contact"}}`
