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

        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

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
