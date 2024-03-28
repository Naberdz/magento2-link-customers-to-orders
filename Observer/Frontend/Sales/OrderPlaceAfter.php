<?php

declare(strict_types=1);

namespace Wemessage\LinkCustomers\Observer\Frontend\Sales;

class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
	private $customerRepository;
	
	public function __construct(
		\Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
	){
		$this->customerRepository = $customerRepository;
	}

    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $order = $observer->getEvent()->getOrder();

        if (!$order->getCustomerId()) {
            $email = $order->getCustomerEmail();
			try {
				$customer = $this->customerRepository->get($email, $order->getStore()->getWebsiteId());
				
				if ($customer->getId()) {
					$order->setCustomerId($customer->getId());
					$order->setCustomerIsGuest(0);
					$order->save();
				}
			} catch (\Exception $e) {
				
			}
		}
    }
}

