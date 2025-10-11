@extends('layouts.app')

@section('title', 'متجر الجوائز')
@push('css')
    <style>
        .market-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .market-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="white" opacity="0.08"/><circle cx="75" cy="75" r="1.5" fill="white" opacity="0.04"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.06"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.4;
        }

        .market-header h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            position: relative;
            z-index: 2;
            color:white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .market-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .stats-section {
            margin-bottom: 3rem;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-section {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .filter-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-title::after {
            content: '';
            width: 40px;
            height: 3px;
            background: #667eea;
            border-radius: 2px;
            margin-left: 0.5rem;
        }

        .form-select {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            background-color: white;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
        }

        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.85rem 2rem;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
            color: white;
        }

        .products-grid {
            margin-bottom: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 230px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-body {
            padding: 1.8rem;
            display: flex;
            flex-direction: column;
            height: calc(100% - 230px);
        }

        .product-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            line-height: 1.4;
            min-height: 2.8rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .points-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 0.6rem 1.1rem;
            border-radius: 25px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            width: fit-content;
        }

        .stock-info {
            margin-bottom: 1.2rem;
        }

        .stock-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .stock-available {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .stock-unavailable {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .product-meta {
            margin-bottom: 1.5rem;
        }

        .meta-item {
            background: #f8f9fa;
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            border-left: 3px solid #667eea;
        }

        .btn-exchange {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.9rem 1.5rem;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .btn-exchange:hover:not(.disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-exchange.disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
            background: white;
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin: 2rem 0;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 2rem;
            opacity: 0.4;
            color: #667eea;
        }

        .empty-state h4 {
            color: #495057;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .pagination .page-link {
            border: none;
            color: #667eea;
            padding: 0.8rem 1.2rem;
            margin: 0 2px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            background: white;
        }

        .pagination .page-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: #667eea;
            color: white;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 18px !important;
            border: none !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border-radius: 18px 18px 0 0 !important;
            border-bottom: none !important;
            padding: 1.5rem 2rem !important;
        }

        .modal-body {
            padding: 2rem !important;
        }

        .modal-footer {
            border-top: none !important;
            padding: 1rem 2rem 2rem !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .market-header {
                padding: 2.5rem 1.5rem;
                margin: 1rem;
                border-radius: 16px;
            }

            .market-header h2 {
                font-size: 2.2rem;
            }

            .filter-section {
                margin: 1rem;
                padding: 1.5rem;
            }

            .product-image-wrapper {
                height: 200px;
            }

            .product-body {
                padding: 1.5rem;
            }

            .stats-number {
                font-size: 1.8rem;
            }
        }

        /* Utilities */
        .filter-icon {
            width: 20px;
            height: 20px;
            fill: #667eea;
        }
    </style>

@endpush
@section('content')

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="market-header">
            <h2>🎁 متجر الجوائز</h2>
            <p>استبدل نقاطك بالجوائز المتاحة في مدرستك واحصل على مكافآت رائعة</p>
        </div>

        <div class="container">
            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">{{ $marketItems->total() }}</div>
                            <div class="stats-label">إجمالي المنتجات</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">{{ $marketItems->where('stock', '>', 0)->count() }}</div>
                            <div class="stats-label">منتجات متاحة</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number">{{ Auth::user()->flexible_points ?? 0 }}</div>
                            <div class="stats-label">نقاطك الحالية</div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Products Grid -->
            <div class="products-grid">
                <div class="row g-4">
                    @forelse($marketItems as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card product-card">
                                <!-- Product Image -->
                                <div class="product-image-wrapper">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('images')->url($item->image_url) }}"
                                         class="product-image"
                                         alt="{{ $item->name }}"
                                         loading="lazy">

                                    @if($item->stock <= 0)
                                        <div class="product-overlay">
                                            غير متاح
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Content -->
                                <div class="product-body">
                                    <!-- Product Title -->
                                    <h5 class="product-title">{{ $item->name }}</h5>

                                    <!-- Points Required -->
                                    <div class="points-badge">
                                        <i class="fas fa-coins"></i>
                                        {{ number_format($item->points_required) }} نقطة
                                    </div>

                                    <!-- Stock Status -->
                                    <div class="stock-info">
                                        @if($item->stock > 0)
                                            <span class="stock-badge stock-available">
                                            <i class="fas fa-check-circle"></i>
                                            متاح: {{ $item->stock }} قطعة
                                        </span>
                                        @else
                                            <span class="stock-badge stock-unavailable">
                                            <i class="fas fa-times-circle"></i>
                                            غير متاح حالياً
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Additional Info -->
                                    <div class="product-meta">
                                        @if($item->role)
                                            <div class="meta-item">
                                                <i class="fas fa-user-tag"></i>
                                                {{ $item->role->name }}
                                            </div>
                                        @endif

                                        @if($item->level)
                                            <div class="meta-item">
                                                <i class="fas fa-layer-group"></i>
                                                {{ $item->level->name }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Exchange Button -->
                                    <button type="button"
                                            class="btn btn-exchange {{ $item->stock <= 0 || (Auth::user()->flexible_points ?? 0) < $item->points_required ? 'disabled' : '' }}"
                                            {{ $item->stock <= 0 || (Auth::user()->flexible_points ?? 0) < $item->points_required ? 'disabled' : '' }}
                                            onclick="exchangeItem({{ $item->id }}, '{{ $item->name }}', {{ $item->points_required }})">
                                        @if($item->stock <= 0)
                                            <i class="fas fa-ban"></i>
                                            غير متاح
                                        @elseif((Auth::user()->flexible_points ?? 0) < $item->points_required)
                                            <i class="fas fa-exclamation-triangle"></i>
                                            نقاط غير كافية
                                        @else
                                            <i class="fas fa-shopping-cart"></i>
                                            استبدال الآن
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-gift"></i>
                                <h4 class="mt-3 mb-2">لا توجد منتجات متاحة</h4>
                                <p class="text-muted">لم يتم العثور على منتجات تطابق معايير البحث الخاصة بك</p>
                                <a href="{{ request()->url() }}" class="btn btn-outline-primary mt-3">
                                    <i class="fas fa-refresh me-2"></i>
                                    عرض جميع المنتجات
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($marketItems->hasPages())
                <div class="pagination-wrapper">
                    {{ $marketItems->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Exchange Confirmation Modal -->
    <div class="modal fade" id="exchangeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exchange-alt me-2"></i>
                        تأكيد الاستبدال
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-gift text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="mb-3">هل أنت متأكد من استبدال هذا المنتج؟</h6>
                    <p class="text-muted mb-3" id="exchangeDetails"></p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        لا يمكن التراجع عن عملية الاستبدال بعد التأكيد
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="confirmExchange">
                        <i class="fas fa-check me-2"></i>
                        تأكيد الاستبدال
                    </button>
                </div>
            </div>
        </div>
    </div>
    <form id="exchangeForm" action="{{ route('user.exchange') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="item_id" id="exchangeItemId">
    </form>

@endsection
@push('script')
    <script>
        function exchangeItem(itemId, itemName, pointsRequired) {
            document.getElementById('exchangeDetails').innerHTML =
                `<strong>${itemName}</strong><br>النقاط المطلوبة: <span class="text-primary">${pointsRequired.toLocaleString()} نقطة</span>`;

            // عند الضغط على تأكيد
            document.getElementById('confirmExchange').onclick = function() {
                document.getElementById('exchangeItemId').value = itemId;
                document.getElementById('exchangeForm').submit();
            };

            var modal = new bootstrap.Modal(document.getElementById('exchangeModal'));
            modal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animate stats numbers
            const statsNumbers = document.querySelectorAll('.stats-number');
            statsNumbers.forEach(stat => {
                const finalValue = parseInt(stat.textContent);
                let currentValue = 0;
                const increment = finalValue / 30;

                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        stat.textContent = finalValue;
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(currentValue);
                    }
                }, 50);
            });
        });
    </script>

@endpush
