<?php
/**
 * @copyright Copyright (c) Myles Derham.
 * @license   https://craftcms.github.io/license/
 */

namespace thejoshsmith\commerce\xero\jobs;

use thejoshsmith\commerce\xero\Plugin;

use Craft;
use craft\queue\BaseJob;
use craft\commerce\Plugin as Commerce;

class SendToXeroJob extends BaseJob
{
    // Properties
    // =========================================================================

    /**
     * @var Int
     */
    public $orderID;


    // Protected Methods
    // ========================================================================

    protected function defaultDescription()
    {
        return Plugin::t('Send Order to Xero');
    }


    // Public Methods
    // =========================================================================

    public function execute($queue)
    {
        $totalSteps = 1;
        for ($step = 0; $step < $totalSteps; $step++) {
            $order = Commerce::getInstance()
                ->getOrders()
                ->getOrderById($this->orderID);
            Plugin::getInstance()->getXeroApi()->sendOrder($order);
            $this->setProgress($queue, $step / $totalSteps);
        }
    }
}
