<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get the cart of the logged user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $cartItems = Cart::query()
            ->with(['store', 'product'])
            ->where('user_id', $request->user('sanctum')->id)
            ->get();

        $cart = [];

        foreach ($cartItems as $item) {
            $product = [
                'id' => $item->product->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'remaining_qty' => $item->product->quantity,
                'selected_qty' => $item->quantity,
            ];

            $cart[$item->store->id]['id'] = $item->store->id;
            $cart[$item->store->id]['name'] = $item->store->store_name;
            $cart[$item->store->id]['products'][] = $product;
        }

        $reIndexedCart = array_values($cart);

        return response()->json(['message' => 'Cart fetched', 'cart' => $reIndexedCart], 200);
    }

    /**
     * Add/Increment product to cart.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        $cartItem = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', 1);

            if (!$cartItem->save()) {
                return response()->json(['message' => 'Could not update cart quantity.'], 400);
            };
        } else {
            $cartItem = Cart::create([
                'user_id' => $request->user()->id,
                'store_id' => $product->store_id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return response()->json(['message' => 'Added to cart.', 'item' => $cartItem], 201);
    }

    /**
     * Remove/decrement product to cart.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $cartItem = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'No product found.'], 400);
        }

        if ($request->boolean('clear') || $cartItem->quantity <= 1) {
            $cartItem->delete();
            return response()->json(['message' => 'Item removed.'], 200);
        }

        $cartItem->decrement('quantity', 1);
        return response()->json(['message' => 'Item quantity decreased.'], 200);
    }

    /**
     * Remove all items in the user's cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $cartItems = Cart::query()
            ->where('user_id', $request->user()->id)
            ->delete();

        return response()->json(['message' => 'Cart cleared.'], 200);
    }
}