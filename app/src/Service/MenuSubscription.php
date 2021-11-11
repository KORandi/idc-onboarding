<?php

namespace App\Service;

use App\Dto\RestaurantDto;
use App\Dto\SubscriptionDto;
use Exception;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MenuSubscription
{
    /**
     * @var SubscriptionDto[]
     */
    private array $data;
    private string $resourcePath;
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, string $subscriptionFileJSON /* binded value */)
    {
        $this->resourcePath = $subscriptionFileJSON;
        $this->data = $serializer->deserialize(file_get_contents($subscriptionFileJSON), "App\Dto\SubscriptionDto[]", "json");
        $this->serializer = $serializer;
    }

    /**
     * @param array $formData
     * @return bool
     * @throws Exception
     */
    public function processForm(array $formData): bool
    {
        $email = $formData["email"];
        /**
         * @var RestaurantDto[] $restaurants
         */
        $restaurants = $formData["restaurant"];

        foreach ($restaurants as $restaurant) {
            if (!$restaurant instanceof RestaurantDto) {
                throw new Exception;
            }
        }

        $newSubscription = new SubscriptionDto($email, $restaurants);
        $subIndex = $this->getSubscriptionIndex($newSubscription);
        if ($subIndex > -1) {
            $this->data[$subIndex] = $newSubscription;
        } else {
            $this->data[] = $newSubscription;
        }

        $this->updateFile();
        return true;
    }

    /**
     * @return SubscriptionDto[]
     */
    public function getSubscriptions(): array
    {
        return $this->data;
    }

    private function updateFile(): void
    {
        $file = fopen($this->resourcePath,'w');
        fwrite($file, $this->serializer->serialize($this->data, 'json'));
        fclose($file);
    }

    private function getSubscriptionIndex(SubscriptionDto $newSubscription): int
    {
        foreach ($this->data as $key => $subscription) {
            if ($subscription->getEmail() == $newSubscription->getEmail()) {
                return $key;
            }
        }
        return -1;
    }
}