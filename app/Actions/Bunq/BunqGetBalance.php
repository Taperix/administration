<?php


namespace App\Actions\Bunq;


use bunq\Context\ApiContext;
use bunq\Context\BunqContext;
use bunq\Model\Generated\Endpoint\MonetaryAccount;
use bunq\Model\Generated\Object\Amount;
use bunq\Util\BunqEnumApiEnvironmentType;

class BunqGetBalance
{

    /**
     * @return Amount
     */
    public function execute(): Amount
    {
        $apiContext = ApiContext::create(
            BunqEnumApiEnvironmentType::PRODUCTION(),
            config('company.bunq.apiKey'),
            'My First PHP bunq Implementation!'
        );

        BunqContext::loadApiContext($apiContext);

        $monetaryAccountListing = MonetaryAccount::listing();

        $monetaryAccounts = $monetaryAccountListing->getValue();
        $monetaryAccount = $monetaryAccounts[0]->getMonetaryAccountBank();
        return $monetaryAccount->getBalance();
    }
}
