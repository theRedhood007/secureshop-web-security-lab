<div class="cart-index">
    <h1>Your Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->book->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->book->price, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            <strong>Total: ${{ number_format($totalPrice, 2) }}</strong>
        </div>

        <div>
            <a href="{{ route('checkout') }}">Proceed to Checkout</a>
        </div>
    @endif
</div>