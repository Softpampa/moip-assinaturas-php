<?php

namespace Softpampa\Moip\Subscription;

use Softpampa\Moip\Subscription\Contracts\MoipHttpClient;
use Softpampa\Moip\Subscription\Resources\Customers;
use Softpampa\Moip\Subscription\Resources\Invoices;
use Softpampa\Moip\Subscription\Resources\Payments;
use Softpampa\Moip\Subscription\Resources\Plans;
use Softpampa\Moip\Subscription\Resources\Preferences;
use Softpampa\Moip\Subscription\Resources\Subscriptions;

/**
 * Class Api.
 */
class Api
{
    /**
     * @var MoipHttpClient
     */
    protected $client;

    /**
     * @var Customers
     */
    protected $customers;

    /**
     * @var Invoices
     */
    protected $invoices;

    /**
     * @var Payments
     */
    protected $payments;

    /**
     * @var Plans
     */
    protected $plans;

    /**
     * @var Preferences
     */
    protected $preferences;

    /**
     * @var Subscriptions
     */
    protected $subscriptions;

    /**
     * @param MoipHttpClient $client
     */
    public function __construct(MoipHttpClient $client)
    {
        $this->client = $client;
        $this->customers = new Customers($this->client);
        $this->invoices = new Invoices($this->client);
        $this->payments = new Payments($this->client);
        $this->plans = new Plans($this->client);
        $this->preferences = new Preferences($this->client);
        $this->subscriptions = new Subscriptions($this->client);
    }

    /**
     * @return Customers
     */
    public function customers()
    {
        return $this->customers;
    }

    /**
     * @return Invoices
     */
    public function invoices()
    {
        return $this->invoices;
    }

    /**
     * @return Payments
     */
    public function payments()
    {
        return $this->payments;
    }

    /**
     * @return Plans
     */
    public function plans()
    {
        return $this->plans;
    }

    /**
     * @return Preferences
     */
    public function preferences()
    {
        return $this->preferences;
    }

    /**
     * @return Subscriptions
     */
    public function subscriptions()
    {
        return $this->subscriptions;
    }
}
