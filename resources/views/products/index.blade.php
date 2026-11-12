<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Earl Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brand: #6366f1;
            --brand-dark: #4f46e5;
            --brand-soft: #eef2ff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --surface: #ffffff;
            --bg: #f6f7fb;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        /* ---------- Top bar ---------- */
        .topbar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            padding: 2.5rem 0 5.5rem;
        }
        .topbar h1 { font-size: 1.75rem; font-weight: 700; letter-spacing: -.02em; }
        .topbar p  { color: rgba(255,255,255,.75); margin: 0; }
        .brand-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,.18);
            backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }

        .page-body { margin-top: -3.5rem; padding-bottom: 3rem; }

        /* ---------- Stat cards ---------- */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 8px 24px rgba(15,23,42,.06);
            height: 100%;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 14px 32px rgba(15,23,42,.1);
        }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }
        .stat-label { font-size: .8rem; color: var(--muted); font-weight: 500; }
        .stat-value { font-size: 1.5rem; font-weight: 700; letter-spacing: -.02em; line-height: 1.2; }

        .ic-indigo { background: #eef2ff; color: #4f46e5; }
        .ic-green  { background: #ecfdf5; color: #059669; }
        .ic-amber  { background: #fffbeb; color: #d97706; }
        .ic-rose   { background: #fff1f2; color: #e11d48; }

        /* ---------- Main card ---------- */
        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 8px 24px rgba(15,23,42,.06);
            overflow: hidden;
        }
        .panel-head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--line);
        }
        .panel-head h5 { font-weight: 600; margin: 0; }
        .panel-head small { color: var(--muted); }

        .search-wrap { position: relative; min-width: 260px; }
        .search-wrap i {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }
        .search-wrap input {
            padding-left: 2.5rem;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #f8fafc;
            height: 44px;
        }
        .search-wrap input:focus {
            background: #fff;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(99,102,241,.15);
        }

        .btn-brand {
            background: var(--brand);
            border: none;
            color: #fff;
            border-radius: 12px;
            height: 44px;
            padding: 0 1.25rem;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(99,102,241,.35);
            transition: all .2s ease;
        }
        .btn-brand:hover {
            background: var(--brand-dark);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(99,102,241,.4);
        }

        /* ---------- Table ---------- */
        .table-modern { margin: 0; }
        .table-modern thead th {
            background: #f8fafc;
            color: var(--muted);
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            border-bottom: 1px solid var(--line);
            padding: .9rem 1.5rem;
            white-space: nowrap;
        }
        .table-modern tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-modern tbody tr { transition: background .15s ease; }
        .table-modern tbody tr:hover { background: #fafaff; }
        .table-modern tbody tr:last-child td { border-bottom: none; }

        .avatar {
            width: 42px; height: 42px;
            border-radius: 12px;
            background: var(--brand-soft);
            color: var(--brand-dark);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }
        .product-name { font-weight: 600; }
        .product-id   { font-size: .75rem; color: var(--muted); }
        .desc-cell {
            color: var(--muted);
            max-width: 340px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .price-pill {
            display: inline-block;
            background: #ecfdf5;
            color: #047857;
            font-weight: 600;
            padding: .3rem .7rem;
            border-radius: 999px;
            font-size: .875rem;
            white-space: nowrap;
        }

        .icon-btn {
            width: 36px; height: 36px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--muted);
            display: inline-flex; align-items: center; justify-content: center;
            transition: all .15s ease;
        }
        .icon-btn:hover.edit   { background: #fffbeb; border-color: #fcd34d; color: #b45309; }
        .icon-btn:hover.delete { background: #fff1f2; border-color: #fda4af; color: #be123c; }

        .panel-foot {
            padding: .9rem 1.5rem;
            border-top: 1px solid var(--line);
            background: #f8fafc;
            color: var(--muted);
            font-size: .85rem;
        }

        .empty-state { padding: 3.5rem 1rem; text-align: center; color: var(--muted); }
        .empty-state i { font-size: 2.75rem; color: #cbd5e1; display: block; margin-bottom: .75rem; }

        /* ---------- Modals ---------- */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(15,23,42,.25);
            overflow: hidden;
        }
        .modal-header { border-bottom: 1px solid var(--line); padding: 1.25rem 1.5rem; }
        .modal-body   { padding: 1.5rem; }
        .modal-footer { border-top: 1px solid var(--line); padding: 1rem 1.5rem; background: #f8fafc; }
        .modal-title  { font-weight: 600; }
        .modal-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-right: .75rem;
        }
        .form-label { font-weight: 500; font-size: .875rem; }
        .form-control, .input-group-text {
            border-radius: 12px;
            border: 1px solid var(--line);
            padding: .65rem .9rem;
        }
        .input-group .form-control { border-top-left-radius: 0; border-bottom-left-radius: 0; }
        .input-group .input-group-text {
            border-top-right-radius: 0; border-bottom-right-radius: 0;
            background: #f8fafc; color: var(--muted); font-weight: 600;
        }
        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(99,102,241,.15);
        }
        .btn-light-soft {
            background: #fff; border: 1px solid var(--line);
            border-radius: 12px; font-weight: 500; padding: .6rem 1.1rem;
        }
        .btn-light-soft:hover { background: #f1f5f9; }
        .btn-danger-soft {
            background: #e11d48; border: none; color: #fff;
            border-radius: 12px; font-weight: 600; padding: .6rem 1.1rem;
        }
        .btn-danger-soft:hover { background: #be123c; color: #fff; }

        /* ---------- Toast ---------- */
        .toast-wrap { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 1100; }
        .toast-modern {
            border: none;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(15,23,42,.18);
            overflow: hidden;
        }

        @media (max-width: 767px) {
            .table-modern thead th, .table-modern tbody td { padding: .85rem 1rem; }
            .search-wrap { min-width: 100%; }
        }
    </style>
</head>
<body>

{{-- ================= TOP BAR ================= --}}
<div class="topbar">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="brand-icon"><i class="bi bi-box-seam"></i></div>
            <div>
                <h1 class="mb-1">geeeeeeeeeeeeeeee</h1>
                <p>Ageeeeeeeeeeeeeeee</p>
            </div>
        </div>
    </div>
</div>

<div class="container page-body">

    {{-- ================= STATS ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon ic-indigo"><i class="bi bi-boxes"></i></div>
                <div>
                    <div class="stat-label">Total Products</div>
                    <div class="stat-value">{{ $products->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon ic-green"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <div class="stat-label">Total Value</div>
                    <div class="stat-value">₱{{ number_format($products->sum('price'), 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon ic-amber"><i class="bi bi-graph-up"></i></div>
                <div>
                    <div class="stat-label">Average Price</div>
                    <div class="stat-value">₱{{ number_format($products->avg('price') ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon ic-rose"><i class="bi bi-trophy"></i></div>
                <div>
                    <div class="stat-label">Highest Price</div>
                    <div class="stat-value">₱{{ number_format($products->max('price') ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= TABLE PANEL ================= --}}
    <div class="panel">
        <div class="panel-head d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5>All Products</h5>
                <small>Manage everything in your catalog</small>
            </div>

            <div class="d-flex flex-wrap gap-2 w-md-auto">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                </div>

                <button type="button" class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Product
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody id="productBody">
                    @foreach ($products as $product)
                        <tr class="product-row">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">{{ strtoupper(mb_substr($product->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-id">ID #{{ $product->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="desc-cell">{{ $product->description ?: '—' }}</div>
                            </td>
                            <td><span class="price-pill">₱{{ number_format($product->price, 2) }}</span></td>
                            <td class="text-end text-nowrap">
                                <button type="button"
                                        class="icon-btn edit btn-edit"
                                        title="Edit"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}"
                                        data-price="{{ $product->price }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button type="button"
                                        class="icon-btn delete btn-delete"
                                        title="Delete"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Empty state (no products at all) --}}
            @if ($products->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inboxes"></i>
                    <h6 class="mb-1">No products yet</h6>
                    <p class="mb-3">Get started by adding your first product.</p>
                    <button type="button" class="btn btn-brand" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="bi bi-plus-lg me-1"></i> Add Product
                    </button>
                </div>
            @endif

            {{-- Empty state (search found nothing) --}}
            <div class="empty-state d-none" id="noResults">
                <i class="bi bi-search"></i>
                <h6 class="mb-1">No matching products</h6>
                <p class="mb-0">Try a different search term.</p>
            </div>
        </div>

        <div class="panel-foot">
            Showing <strong id="shownCount">{{ $products->count() }}</strong>
            of <strong>{{ $products->count() }}</strong> products
        </div>
    </div>
</div>


{{-- ================= TOAST ================= --}}
@if (session('success'))
    <div class="toast-wrap">
        <div id="successToast" class="toast toast-modern align-items-center text-bg-success border-0" role="alert" data-bs-delay="3500">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endif


{{-- ================= ADD MODAL ================= --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="/products/store" method="POST">
                @csrf
                <input type="hidden" name="_form" value="add">

                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <span class="modal-icon ic-indigo"><i class="bi bi-plus-lg"></i></span>
                        Add Product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    @if ($errors->any() && old('_form') === 'add')
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('_form') === 'add' ? old('name') : '' }}"
                               class="form-control"
                               placeholder="e.g. Wireless Mouse"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Short description (optional)">{{ old('_form') === 'add' ? old('description') : '' }}</textarea>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number"
                                   name="price"
                                   value="{{ old('_form') === 'add' ? old('price') : '' }}"
                                   step="0.01"
                                   min="0"
                                   class="form-control"
                                   placeholder="0.00"
                                   required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-brand">
                        <i class="bi bi-check2 me-1"></i> Save Product
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ================= EDIT MODAL ================= --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="editForm" action="" method="POST">
                @csrf
                <input type="hidden" name="_form" value="edit">
                <input type="hidden" name="_id" id="edit_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <span class="modal-icon ic-amber"><i class="bi bi-pencil-square"></i></span>
                        Edit Product
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    @if ($errors->any() && old('_form') === 'edit')
                        <div class="alert alert-danger border-0 rounded-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="number"
                                   name="price"
                                   id="edit_price"
                                   step="0.01"
                                   min="0"
                                   class="form-control"
                                   required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-brand">
                        <i class="bi bi-check2 me-1"></i> Update Product
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ================= DELETE MODAL ================= --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <form id="deleteForm" action="" method="POST">
                @csrf

                <div class="modal-body text-center py-4">
                    <div class="stat-icon ic-rose mx-auto mb-3" style="width:60px;height:60px;font-size:1.6rem;">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">Delete product?</h5>
                    <p class="text-muted mb-0">
                        <strong id="deleteName"></strong> will be permanently removed.
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light-soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger-soft">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const editModal   = new bootstrap.Modal(document.getElementById('editModal'));
    const addModal    = new bootstrap.Modal(document.getElementById('addModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    // ---------- Edit ----------
    function fillEditForm(id, name, description, price) {
        document.getElementById('editForm').action = '/products/update/' + id;
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name ?? '';
        document.getElementById('edit_description').value = description ?? '';
        document.getElementById('edit_price').value = price ?? '';
    }

    document.querySelectorAll('.btn-edit').forEach(function (btn) {
        btn.addEventListener('click', function () {
            fillEditForm(
                btn.dataset.id,
                btn.dataset.name,
                btn.dataset.description,
                btn.dataset.price
            );
            editModal.show();
        });
    });

    // ---------- Delete ----------
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('deleteForm').action = '/products/delete/' + btn.dataset.id;
            document.getElementById('deleteName').textContent = btn.dataset.name;
            deleteModal.show();
        });
    });

    // ---------- Search ----------
    const searchInput = document.getElementById('searchInput');
    const rows        = document.querySelectorAll('.product-row');
    const noResults   = document.getElementById('noResults');
    const shownCount  = document.getElementById('shownCount');

    searchInput.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();
        let visible = 0;

        rows.forEach(function (row) {
            const match = row.textContent.toLowerCase().includes(term);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        shownCount.textContent = visible;
        noResults.classList.toggle('d-none', !(rows.length > 0 && visible === 0));
    });

    // ---------- Toast ----------
    const toastEl = document.getElementById('successToast');
    if (toastEl) {
        new bootstrap.Toast(toastEl).show();
    }

    // ---------- Reopen the right modal if validation failed ----------
    @if ($errors->any())
        @if (old('_form') === 'edit')
            fillEditForm(
                @json(old('_id')),
                @json(old('name')),
                @json(old('description')),
                @json(old('price'))
            );
            editModal.show();
        @else
            addModal.show();
        @endif
    @endif
</script>

</body>
</html>