<?php
namespace Vendor\CustomContactForm\Block;

class Contact extends \Magento\Framework\View\Element\Template
{
    protected $_formKey;
    protected $_template ="Vendor_CustomContactForm::contact.phtml";

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Data\Form\FormKey $formKey,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_formKey= $formKey;
    }

    public function getFormKey()
    {
        return $this->_formKey->getFormKey();
    }

    public function getFormAction()
    {
        return $this->_urlBuilder->getUrl('vendor/contact');
    }
}