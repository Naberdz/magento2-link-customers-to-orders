<?php

declare(strict_types=1);

namespace Wemessage\LinkCustomers\Observer\Frontend\Customer;

class RegisterSuccess implements \Magento\Framework\Event\ObserverInterface
{
    private $orderCollection;
    
    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollection
    ){
        $this->orderCollection = $orderCollection;
    }

    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $customer = $observer->getEvent()->getCustomer();
        if($customer->getId()){
            $customerOrder = $this->orderCollection->create()->addAttributeToFilter('customer_email', $customer->getEmail());
            foreach($customerOrder as $order){
                if($order->getCustomerIsGuest()) $this->linkOrderToCustomer($order, $customer);
            }
        }
    }
    
    private function linkOrderToCustomer($order, $customer){
        
        if ($customer->getId()) {
            try {
                $order->setCustomerId($customer->getId());
                $order->setCustomerIsGuest(0);
                $order->save();
            } catch(\Exception $e){
                
            }
        }
    }
}

