<?php

namespace CHK\ProductSoldCount\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Reports\Model\ResourceModel\Product\Sold\CollectionFactory;

/**
 * Class Data
 * @package CHK\ProductSoldCount\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var CollectionFactory
     */
    protected $_reportCollectionFactory;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param CollectionFactory $reportCollectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory  $reportCollectionFactory
    ) {
        $this->_reportCollectionFactory = $reportCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @param null $producID
     * @return int
     */
    public function getSoldQtyByProductId($producID=null) {
        $SoldProducts = $this->_reportCollectionFactory->create();
        $SoldProductCount = $SoldProducts->addOrderedQty()->addAttributeToFilter('product_id', $producID);
        if(!$SoldProductCount->count()) {
            return 0;
        }
        $product = $SoldProductCount->getFirstItem();
        return (int)$product->getData('ordered_qty');
    }
}
