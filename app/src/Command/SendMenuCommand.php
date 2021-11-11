<?php

namespace App\Command;

use App\Service\EmailService;
use App\Service\MenuSubscription;
use App\Service\RestaurantService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMenuCommand extends Command
{
    protected static $defaultName = 'app:email:send';

    private EmailService $emailService;
    private MenuSubscription $menuSubscription;
    private RestaurantService $restaurantService;

    /**
     * @param EmailService $emailService
     * @param MenuSubscription $menuSubscription
     * @param RestaurantService $restaurantService
     */
    public function __construct(
        EmailService $emailService,
        MenuSubscription $menuSubscription,
        RestaurantService $restaurantService
    )
    {
        $this->emailService = $emailService;
        $this->menuSubscription = $menuSubscription;
        $this->restaurantService = $restaurantService;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setDescription("Send menu of restaurants to emails");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $subscriptions = $this->menuSubscription->getSubscriptions();

        foreach ($subscriptions as $subscription) {
            try {
                $restaurants = $this->restaurantService->loadMenus($subscription->getRestaurants());
                $this->emailService->sendMenu($subscription->getEmail(), $restaurants);
            } catch (Exception $e) {
                $message = $e->getMessage();
                $output->writeln("ERROR: $message");
                return COMMAND::FAILURE;
            }
        }

        return COMMAND::SUCCESS;
    }
}