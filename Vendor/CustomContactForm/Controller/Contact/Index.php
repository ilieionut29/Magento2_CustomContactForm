<?php
namespace Vendor\CustomContactForm\Controller\Contact;

use Zend\Log\Filter\Timestamp;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        array $data = []
    )
    {
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();

        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $senderEmail = $post['email'];
        $senderName = $post['name'];
        $ownerMail = $this->_scopeConfig ->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);        

        $emailTemplate = "custom_email_template";

        $requestData = array();
        if( isset($post['name']) && $post['name']) {
            $requestData['name'] = $post['name'];
        }
        if( isset($post['email']) && $post['email'] ){
            $requestData['email'] = $post['email'];
        }
        if( isset($post['phone-number']) && $post['phone-number'] ){
            $requestData['phone-number'] = $post['phone-number'];
        }
        if( isset($post['city']) && $post['city'] ){
            $requestData['city'] = $post['city'];
        }

        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($requestData);

        $transport = $this->_transportBuilder
            ->setTemplateIdentifier($emailTemplate)
            ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID, 'subject' => 'E-mail subject'])
            ->setTemplateVars(['var' => $postObject])
            ->setFrom(['name' => $senderName, 'email' => $ownerMail])
            ->addTo([$ownerMail])
            ->getTransport();
        $transport->sendMessage();

        $this->messageManager->addSuccess(__('Email has been sent successfully.'));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}