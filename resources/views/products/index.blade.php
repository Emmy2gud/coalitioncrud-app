<x-layout>
    <h1>Product Form</h1>

    <form id="productForm">
        @csrf
        <input type="text" name="name" placeholder="Product Name" class="form-control mb-2" required>
        <input type="number" name="quantity" placeholder="Quantity in stock" class="form-control mb-2" required>
        <input type="number" step="0.01" name="price" placeholder="Price per item" class="form-control mb-2" required>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <hr>

    <h3>Products</h3>
    <table class="table table-bordered mt-3" id="productTable">
        <thead>
            <tr>
                <th>Product name</th>
                <th>Quantity in stock</th>
                <th>Price per item</th>
                <th>Datetime submitted</th>
                <th>Total value</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $p)
                <tr data-id="{{ $p->id }}">
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->quantity }}</td>
                    <td>{{ $p->price }}</td>
                    <td>{{ $p->created_at }}</td>
                    <td>{{ $p->quantity * $p->price }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning editBtn">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td colspan="2"><strong>{{ $total }}</strong></td>
            </tr>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


            $('#productForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "/products",
                method: "POST",
                data: $(this).serialize(),
                success: function (res) {
                    alert("✅ Product submitted successfully!");
                    location.reload();
                }, error: function (err) {
                    alert("❌ Something went wrong, please try again.");
                }

            });
        });

        $('.editBtn').click(function () {
            let row = $(this).closest('tr');
            let id = row.data('id');
            let name = prompt("Edit name:", row.find('td:eq(0)').text());
            let qty = prompt("Edit quantity:", row.find('td:eq(1)').text());
            let price = prompt("Edit price:", row.find('td:eq(2)').text());

            $.ajax({
                url: "/products/" + id,
                method: "PUT",
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    quantity: qty,
                    price: price
                },
                success: function (res) {
                    alert("✅ Product Updated successfully!");
                    location.reload();
                }, error: function (err) {
                    alert("❌ Something went wrong, please try again.");
                }
            });
        });

        $('.deleteBtn').click(function () {

            let row = $(this).closest('tr');
            let id = row.data('id');

            $.ajax({
                url: "/products/" + id,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    alert("✅ Product Deleted  successfully!");
                    location.reload();
                }, error: function (err) {
                    alert("❌ Something went wrong, please try again.");
                }
            });
        });
    </script>
</x-layout>
