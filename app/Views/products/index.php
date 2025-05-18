<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1>Products</h1>

        <!-- Tombol Tambah -->
        <button id="btnAdd" class="btn btn-primary mb-3">Tambah Produk</button>

        <!-- Tabel Produk -->
        <table id="productTable" class="display">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="formAddProduct">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" name="price" required>
              </div>
              <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" name="category_id" required>
                  <?php foreach ($categories as $cat): ?>
                   <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>

                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>

<h2>Edit Produk</h2>
<form id="editForm" style="display: none;">
    <input type="hidden" id="editId">
    <label>Nama: <input type="text" id="editName"></label><br>
    <label>Harga: <input type="number" id="editPrice"></label><br>
    <label>Kategori:
        <select id="editCategory">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <button type="submit">Simpan Perubahan</button>
</form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            const table = $('#productTable').DataTable({
                ajax: {
                    url: '/product/getAll',
                    dataSrc: 'products'
                },
              columns: [
                { data: 'name' },
                { data: 'price' },
                { data: 'category_name' },
     {
        data: 'id',
        render: function(data, type, row) {
            return `
                <button onclick="editProduct(${data}, '${row.name}', ${row.price}, ${row.category_id})">Edit</button>
                <button onclick="deleteProduct(${data})">Hapus</button>
            `;
        }
    }
]
            });

            // Show Modal
            $('#btnAdd').click(() => {
                $('#formAddProduct')[0].reset();
                $('#modalAdd').modal('show');
            });

            // Submit Create Form
            $('#formAddProduct').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/product/create',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function () {
                        $('#modalAdd').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (xhr) {
                        alert('Gagal menyimpan data');
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function deleteProduct(id) {
            if (!confirm('Yakin ingin menghapus produk ini?')) return;
            $.ajax({
                url: '/product/delete/' + id,
                type: 'DELETE',
                success: function () {
                    $('#productTable').DataTable().ajax.reload();
                }
            });
        }
        function editProduct(id, name, price, categoryId) {
    $('#editId').val(id);
    $('#editName').val(name);
    $('#editPrice').val(price);
    $('#editCategory').val(categoryId);
    $('#editForm').show();
}

$('#editForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: '/product/update/' + $('#editId').val(),
        method: 'POST',
        data: {
            name: $('#editName').val(),
            price: $('#editPrice').val(),
            category_id: $('#editCategory').val()
        },
        success: function () {
            $('#productTable').DataTable().ajax.reload();
            $('#editForm').hide();
        }
    });
});

    </script>
</body>
</html>
