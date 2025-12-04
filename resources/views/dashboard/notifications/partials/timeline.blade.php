@forelse($notifications as $index => $n)
    @php
        $type = str_contains($n->action, 'created') ? 'create' :
                (str_contains($n->action, 'updated') ? 'update' :
                (str_contains($n->action, 'deleted') ? 'delete' : 'info'));
        $isToday = $n->created_at->isToday();
    @endphp

    <div class="notification-item"
         x-show="showNotification('{{ $n->actor?->id }}', '{{ $type }}', '{{ $n->created_at->format('Y-m-d') }}')"
         style="animation-delay: {{ ($index % 50) * 0.05 }}s;">

        <div class="notification-card type-{{ $type }} animate__animated animate__fadeInUp">
            @if($isToday)
                <span class="today-badge">جديد</span>
            @endif

            <div class="notification-icon">
                @if($type == 'create') <i class='bx bx-plus-circle'></i>
                @elseif($type == 'update') <i class='bx bx-edit'></i>
                @elseif($type == 'delete') <i class='bx bx-trash'></i>
                @else <i class='bx bx-bell'></i>
                @endif
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold text-dark">{{ $n->actor?->name ?? 'النظام' }}</h6>
                    <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                </div>
                <p class="text-primary fw-semibold mb-1">{{ $n->action }}</p>
                <p class="text-muted small">{!! Str::limit($n->description, 120) !!}</p>
                <button @click="showDetails({{ $n->toJson() }})"
                        class="btn btn-sm btn-outline-primary rounded-pill mt-2">
                    <i class='bx bx-show'></i> عرض التفاصيل
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 text-muted">
        <p>لا توجد إشعارات إضافية</p>
    </div>
@endforelse