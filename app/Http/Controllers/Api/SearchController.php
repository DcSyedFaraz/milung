<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PriceInquiry;
use App\Models\Products;
use App\Models\ShipmentOrder;
use App\Models\SupplierProfile;
use Auth;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle search requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Validate the search query and pagination parameters
        $request->validate([
            'query' => 'required|string|max:255',
            'page' => 'array', // Optional, per-index pages
            'page.*' => 'integer|min:1',
        ]);

        $query = $request->input('query');
        $pages = $request->input('page', []); // Associative array: index => page
        $perPage = 10;

        // Get authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userRole = $user->getRoleNames()->first(); // Assuming 'role' attribute exists

        // Determine accessible indices based on role
        $accessibleIndices = $this->getAccessibleIndices($userRole);
        // dd($accessibleIndices);

        $results = [];

        foreach ($accessibleIndices as $index) {
            $currentPage = isset($pages[$index]) ? (int) $pages[$index] : 1;

            switch ($index) {
                case 'orders':
                    $results['orders'] = $this->searchOrders($query, $user, $currentPage, $perPage);
                    break;
                case 'price_inquiries':
                    $results['price_inquiries'] = $this->searchPriceInquiries($query, $user, $currentPage, $perPage);
                    break;
                case 'shipment_orders':
                    $results['shipment_orders'] = $this->searchShipmentOrders($query, $user, $currentPage, $perPage);
                    break;
                default:
                    // Handle unknown index
                    break;
            }
        }

        return response()->json($results);
    }

    /**
     * Determine accessible indices based on user role.
     *
     * @param string $role
     * @return array
     */
    private function getAccessibleIndices($role)
    {
        switch ($role) {
            case 'Admin':
            case 'Internal':
                return ['orders', 'price_inquiries', 'shipment_orders'];
            case 'Supplier':
                return ['orders', 'price_inquiries', 'shipment_orders'];
            case 'Buyer':
                return ['orders', 'price_inquiries', 'shipment_orders'];
            default:
                return [];
        }
    }

    /**
     * Search orders based on query and user role.
     *
     * @param string $query
     * @param \App\Models\User $user
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function searchOrders($query, $user, $page, $perPage)
    {
        $builder = Order::query();

        // Apply role-based filtering
        if (in_array($user->role, ['Supplier', 'Buyer'])) {
            if ($user->role === 'Supplier') {
                $builder->where('supplier', $user->supplier_id);
            } elseif ($user->role === 'Buyer') {
                $builder->where('buyer', $user->buyer_id);
            }
        }

        // Apply full-text search or simple LIKE search
        // Assuming 'so_number' is unique and important, you might prioritize it
        $builder->where(function ($q) use ($query) {
            $q->where('so_number', 'LIKE', "%{$query}%")
                ->orWhere('id', 'LIKE', "%{$query}%");
        });

        // Paginate results
        $paginated = $builder->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
        ];
    }

    /**
     * Search price inquiries based on query and user role.
     *
     * @param string $query
     * @param \App\Models\User $user
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function searchPriceInquiries($query, $user, $page, $perPage)
    {
        $builder = PriceInquiry::query();

        // Apply role-based filtering
        if ($user->role === 'Supplier') {
            // Suppliers have access to price inquiries where their ID is in supplier_ids
            $builder->whereJsonContains('supplier_ids', $user->supplier_id);
        } elseif ($user->role === 'Buyer') {
            $builder->where('buyer', $user->buyer_id);
        }

        // Apply search on relevant fields
        $builder->where(function ($q) use ($query) {
            $q->where('inquiry_number', 'LIKE', "%{$query}%")
                ->orWhere('buyer', 'LIKE', "%{$query}%");
        });

        // Paginate results
        $paginated = $builder->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
        ];
    }

    /**
     * Search shipment orders based on query and user role.
     *
     * @param string $query
     * @param \App\Models\User $user
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function searchShipmentOrders($query, $user, $page, $perPage)
    {
        $builder = ShipmentOrder::query();

        // Apply role-based filtering
        if ($user->role === 'Supplier') {
            // Assuming suppliers can see shipment orders linked to their orders via so_number
            $builder->whereIn('so_number', function ($q) use ($user) {
                $q->select('so_number')
                    ->from('orders')
                    ->where('supplier', $user->supplier_id);
            });
        } elseif ($user->role === 'Buyer') {
            $builder->where('buyerid', $user->buyer_id);
        }

        // Apply search on relevant fields
        $builder->where(function ($q) use ($query) {
            $q->where('so_number', 'LIKE', "%{$query}%")
                ->orWhere('destination', 'LIKE', "%{$query}%");
        });

        // Paginate results
        $paginated = $builder->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total(),
        ];
    }
}
