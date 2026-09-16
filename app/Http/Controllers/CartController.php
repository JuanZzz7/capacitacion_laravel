<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    protected function getCartQuery()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        return CartItem::with('product')
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->when(! $userId, fn ($q) => $q->where('session_id', $sessionId));
    }

    /**
     * Display the shopping cart.
     */
    public function index(Request $request): View
    {
        $cartItems = $this->getCartQuery()->get();

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);

        // Coupon calculation
        $couponCode = session('applied_coupon');
        $discountRate = ($couponCode === 'KINETIC15') ? 0.15 : 0;
        $discount = round($subtotal * $discountRate, 2);

        // Free shipping threshold = $240.00
        $freeShippingThreshold = 240.00;
        $shippingCost = ($subtotal >= $freeShippingThreshold || $subtotal == 0) ? 0.00 : 12.00;
        $remainingForFreeShipping = max(0, round($freeShippingThreshold - $subtotal, 2));
        $shippingProgress = $freeShippingThreshold > 0
            ? min(100, round(($subtotal / $freeShippingThreshold) * 100, 1))
            : 100;

        $total = max(0, $subtotal - $discount + $shippingCost);

        return view('cart.index', compact(
            'cartItems',
            'subtotal',
            'discount',
            'shippingCost',
            'total',
            'freeShippingThreshold',
            'remainingForFreeShipping',
            'shippingProgress',
            'couponCode'
        ));
    }

    /**
     * Add product to shopping cart.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $userId = Auth::id();
        $sessionId = session()->getId();
        $quantity = (int) ($request->quantity ?? 1);
        $size = $request->size ?? 'Única';
        $color = $request->color ?? 'Estándar';

        $cartItem = CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })
            ->where('product_id', $product->id)
            ->where('size', $size)
            ->where('color', $color)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', '¡Producto añadido a tu bolsa de rendimiento!');
    }

    /**
     * Update quantity of an item in cart.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:increase,decrease,set',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $cartItem = $this->getCartQuery()->where('id', $id)->firstOrFail();

        if ($request->action === 'increase') {
            $cartItem->quantity += 1;
            $cartItem->save();
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
        } elseif ($request->action === 'set' && $request->quantity) {
            $cartItem->quantity = (int) $request->quantity;
            $cartItem->save();
        }

        return redirect()->route('cart.index')->with('success', 'Bolsa actualizada con éxito.');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(int $id): RedirectResponse
    {
        $cartItem = $this->getCartQuery()->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.index')->with('info', 'Artículo eliminado de la bolsa.');
    }

    /**
     * Apply promo discount coupon.
     */
    public function applyCoupon(Request $request): RedirectResponse
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        if ($code === 'KINETIC15') {
            session(['applied_coupon' => 'KINETIC15']);

            return redirect()->route('cart.index')->with('success', '¡Cupón KINETIC15 aplicado! Disfrutas de un 15% de descuento.');
        }

        return redirect()->route('cart.index')->with('error', 'El código de cupón ingresado no es válido o ha expirado.');
    }

    /**
     * Complete demonstrative checkout and record order.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $cartItems = $this->getCartQuery()->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->subtotal);
        $couponCode = session('applied_coupon');
        $discountRate = ($couponCode === 'KINETIC15') ? 0.15 : 0;
        $discount = round($subtotal * $discountRate, 2);
        $shippingCost = ($subtotal >= 240.00) ? 0.00 : 12.00;
        $total = max(0, $subtotal - $discount + $shippingCost);

        $order = Order::create([
            'order_number' => 'ORD-'.strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'customer_name' => Auth::user()?->name ?? ($request->customer_name ?: 'Atleta Kinetic'),
            'customer_email' => Auth::user()?->email ?? ($request->customer_email ?: 'cliente@kineticsports.com'),
            'customer_phone' => $request->customer_phone ?: '+34 600 000 000',
            'shipping_address' => $request->shipping_address ?: 'Av. del Rendimiento 42, Madrid, España',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'coupon_code' => $couponCode,
            'status' => 'completed',
            'payment_method' => $request->payment_method ?: 'Tarjeta de Crédito',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'size' => $item->size,
                'color' => $item->color,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
            ]);
        }

        // Clear cart and coupon
        $this->getCartQuery()->delete();
        session()->forget('applied_coupon');

        return redirect()->route('home')->with('success', "¡Pedido {$order->order_number} confirmado! Hemos enviado los detalles a tu correo.");
    }
}
