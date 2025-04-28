<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Models\RepOffer;
use App\Models\User;
use App\Repositories\Supplier\User\Find\S_FindUserInterface;

class S_StatisticsRepOrderController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_FindUserInterface $findUser
     */
    public function __construct(private S_FindUserInterface $findUser)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $user_id)
    {
        $user = $this->findUser->find(113);
        return response()->json($this->getStatistics($user));
    }

    /**
     * Get User statistics.
     *
     * @param mixed $user
     * @return array
     */
    private function getStatistics(User $user): array
    {
        return [
            'allOrdersCount' => $this->getAllOrdersCount($user),
            'ordersAmountToday' => round( $this->ordersAmountToday($user), 2),
            'ordersAmounts' => round($this->getOrdersAmount($user), 2),
            'ajzaAmount' => round($this->getAjzaAmount($user), 2),
        ];
    }

    /**
     * Get all orders count.
     *
     * @param mixed $user
     * @return int
     */
    private function getAllOrdersCount($user): int
    {
        return $user->repOrders()->statisticsFilter(request())->count();
    }

    /**
     * Get pending orders count.
     *
     * @param mixed $user
     * @return int
     */
    private function ordersAmountToday(User $user): float
    {
        return RepOffer::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereDate('created_at', now()->format('Y-m-d'));
        })
            ->where('status', 'accepted')
            ->sum('price');
    }
    /**
     * Get orders amount today.
     *
     * @param mixed $user
     * @return float
     */
    private function getOrdersAmount(User $user): float
    {
        // Get all rep orders with the applied statistics filter
        $repOrders = $user->repOrders()->statisticsFilter(request())->get();

        // Initialize the total
        $total = 0;

        // Loop through each rep order and sum up the accepted offers
        foreach ($repOrders as $repOrder) {
            $total += $repOrder->offers()->where('status', 'accepted')->sum('price');
        }

        return (float) $total;
    }

    /**
     * Get ajza amount.
     *
     * @param mixed $user
     * @return float
     */
    private function getAjzaAmount(User $user): float
    {
        return $user->repOrders()->statisticsFilter(request())->get()->sum(function ($repOrder) {

            $acceptedOffer = $repOrder->offers()->where('status', 'accepted')->first();
            if ($acceptedOffer) {
                return $acceptedOffer->price * ($repOrder->ajza_percentage / 100);
            }
            return 0;
        });
    }
}
